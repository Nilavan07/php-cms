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

<div class="container">
    <h2>Manage Messages</h2>
    
    <?php if(isset($_SESSION['admin_message'])): ?>
        <div class="alert alert-<?= $_SESSION['admin_message']['type'] ?>">
            <?= $_SESSION['admin_message']['text'] ?>
        </div>
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
                        <a href="contact.php?delete=<?= $row['id'] ?>" 
                           class="btn danger-btn" 
                           onclick="return confirm('Are you sure?')">Delete</a>
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