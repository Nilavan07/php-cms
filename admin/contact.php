<?php
require __DIR__.'/includes/database.php';
require __DIR__.'/includes/config.php';
require __DIR__.'/includes/functions.php';

secure(); 

if (isset($_GET['delete'])) {
    try {
        $stmt = $connect->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->bind_param('i', $_GET['delete']);
        $stmt->execute();
        
        $_SESSION['admin_message'] = [
            'type' => 'success',
            'text' => 'Message deleted successfully'
        ];
    } catch(Exception $e) {
        $_SESSION['admin_message'] = [
            'type' => 'error',
            'text' => 'Error deleting message: ' . $e->getMessage()
        ];
    }
    header("Location: contact.php");
    exit();
}

try {
    $stmt = $connect->prepare("SELECT * FROM messages ORDER BY sent_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
} catch(Exception $e) {
    die("Error retrieving messages: " . $e->getMessage());
}

include(__DIR__.'/includes/header.php');
?>


<style>
:root {
  --primary-color:  #6C63FF;
  --danger-color:   #f44336;
  --success-color:  #4CAF50;
  --text-color:     #333;
  --bg-light:       #f9f9f9;
  --border-color:   #e0e0e0;
  --font-family:    'Poppins', sans-serif;
}

.btn.view-btn,
  .btn.view-btn i,
  .btn.danger-btn,
  .btn.danger-btn i {
    color: #fff !important;
  }

.container {
  max-width: 800px;
  margin: 2rem auto;
  padding: 0 1rem;
  font-family: var(--font-family);
}

h2 {
  color: var(--primary-color);
  margin-bottom: 1rem;
  text-align: center;
}

.alert {
  padding: 0.75rem 1rem;
  border-radius: 4px;
  margin-bottom: 1rem;
  font-weight: 500;
}
.alert-success {
  background-color: var(--success-color);
  color: #fff;
}
.alert-error {
  background-color: var(--danger-color);
  color: #fff;
}

.message-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.message-table th,
.message-table td {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid var(--border-color);
  text-align: left;
  vertical-align: middle;
}
.message-table thead {
  background-color: var(--primary-color);
  color: #fff;
}
.message-table tbody tr:nth-child(even) {
  background-color: var(--bg-light);
}
.message-table tbody tr:hover {
  background-color: #f1f1f1;
}

.btn {
  display: inline-block;
  padding: 0.5rem 0.75rem;
  border-radius: 4px;
  color: #f1f1f1;
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 500;
  transition: opacity 0.2s;
}

.btn:hover {
  opacity: 0.8;
}
.view-btn {
  background-color: var(--primary-color);
  color: #fff;      
}

.danger-btn {
  background-color: var(--danger-color);
  color: #fff;     
}
</style>

<div class="container">
    <h2>Manage Messages</h2>
    
    <?php if(isset($_SESSION['admin_message'])): ?>
        <div class="alert alert-<?= $_SESSION['admin_message']['type'] ?>"><?= htmlspecialchars($_SESSION['admin_message']['text']) ?></div>
        <?php unset($_SESSION['admin_message']); ?>
    <?php endif; ?>

    <?php if($result->num_rows > 0): ?>
        <table class="message-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= date('M j, Y H:i', strtotime($row['sent_at'])) ?></td>
                    <td>
                        <a href="contact_view.php?id=<?= $row['id'] ?>" class="btn view-btn">View</a>
                        <a href="contact.php?delete=<?= $row['id'] ?>" class="btn danger-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No messages found</p>
    <?php endif; ?>
</div>

<?php include(__DIR__.'/includes/footer.php'); ?>
