<?php
include 'includes/database.php';
include 'includes/config.php';
include 'includes/functions.php';

secure();


if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($connect, "DELETE FROM certificates WHERE id = $id LIMIT 1");
    set_message('Certificate has been deleted');
    header('Location: certificates.php');
    exit;
}


$result = mysqli_query(
    $connect,
    "SELECT * FROM certificates ORDER BY date DESC"
);

include 'includes/header.php';
?>


<style>
:root {
  --primary-color:  #6C63FF;
  --danger-color:   #f44336;
  --text-color:     #333;
  --bg-light:       #f9f9f9;
  --border-color:   #e0e0e0;
  --font-family:    'Poppins', sans-serif;
}

.container {
  max-width: 900px;
  margin: 2rem auto;
  padding: 0 1rem;
  font-family: var(--font-family);
  color: var(--text-color);
}

h2 {
  font-size: 1.75rem;
  font-weight: 600;
  text-align: center;
  color: var(--primary-color);
  margin-bottom: 1.5rem;
}

.alert {
  padding: 0.75rem 1rem;
  border-radius: 4px;
  margin-bottom: 1rem;
  font-weight: 500;
}
.alert-success {
  background-color: var(--primary-color);
  color: #fff;
}

.table {
  width: 100%;
  border-collapse: collapse;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  margin-bottom: 1.5rem;
}
.table th,
.table td {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid var(--border-color);
  vertical-align: middle;
  text-align: left;
}
.table thead {
  background-color: var(--primary-color);
  color: #fff;
}
.table tbody tr:nth-child(even) {
  background-color: var(--bg-light);
}
.table tbody tr:hover {
  background-color: #f1f1f1;
}

.btn {
  display: inline-block;
  padding: 0.5rem 0.75rem;
  border-radius: 4px;
  color: #fff;
  text-decoration: none;
  font-size: 0.875rem;
  font-weight: 500;
  transition: opacity 0.2s;
}
.btn:hover {
  opacity: 0.8;
}

.btn-sm {
  font-size: 0.8rem;
  padding: 0.4rem 0.6rem;
  background-color: var(--primary-color);
}

.btn-danger {
  background-color: var(--danger-color);
}

.btn-primary {
  background-color: var(--primary-color);
}

.btn,
.btn-sm,
.btn-primary,
.btn-danger,
.btn-add,
.btn.view-btn,
.btn.danger-btn {
  color: #fff !important;
}

</style>

<div class="container">
  <h2>Manage Certificates</h2>

  <?php if ($msg = get_message()): ?>
    <div class="alert alert-success">
      <?= htmlspecialchars($msg) ?>
    </div>
  <?php endif; ?>

  <?php if (mysqli_num_rows($result) > 0): ?>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Issuer</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['issuer']) ?></td>
          <td><?= htmlspecialchars($row['date']) ?></td>
          <td>
            <a href="certificate_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm">Edit</a>
            <a href="certificates.php?delete=<?= $row['id'] ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Delete this certificate?');">
               Delete
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No certificates found.</p>
  <?php endif; ?>

  <p><a href="certificate_add.php" class="btn btn-primary">
    <i class="fas fa-plus-square"></i> Add Certificate
  </a></p>
</div>

<?php include 'includes/footer.php'; ?>
