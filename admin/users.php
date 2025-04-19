<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_GET['delete'] ) )
{
  $query = 'DELETE FROM users
    WHERE id = '.(int)$_GET['delete'].'
    LIMIT 1';
  mysqli_query( $connect, $query );
  
  set_message( 'User has been deleted' );
  
  header( 'Location: users.php' );
  die();
}

include( 'includes/header.php' );
?>

<!-- Page‑specific styles -->
<style>
:root {
  --primary-color:  #6C63FF;
  --danger-color:   #f44336;
  --text-color:     #333;
  --bg-light:       #f9f9f9;
  --border-color:   #e0e0e0;
  --font-family:    'Poppins', sans-serif;
}

h2 {
  font-family: var(--font-family);
  font-size: 1.8rem;
  color: var(--primary-color);
  text-align: center;
  margin: 2rem 0 1rem;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-family: var(--font-family);
  color: var(--text-color);
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  margin-bottom: 1.5rem;
}

table th,
table td {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid var(--border-color);
  text-align: left;
  vertical-align: middle;
}

table th {
  background-color: var(--primary-color);
  color: #fff;
  font-weight: 600;
}

table tr:nth-child(even) {
  background-color: var(--bg-light);
}

table tr:hover {
  background-color: #f1f1f1;
}

td.center,
th.center {
  text-align: center;
}

/* Links/buttons */
a {
  color: var(--primary-color);
  text-decoration: none;
  font-weight: 500;
}

a:hover {
  text-decoration: underline;
}

.actions a {
  display: inline-block;
  margin: 0 0.25rem;
  padding: 0.4rem 0.8rem;
  border-radius: 4px;
  font-size: 0.875rem;
  transition: background 0.2s, color 0.2s;
}

.actions .edit {
  background-color: var(--primary-color);
  color: #fff;
}

.actions .delete {
  background-color: var(--danger-color);
  color: #fff;
}

.actions .edit:hover,
.actions .delete:hover {
  opacity: 0.9;
}

.btn-add-user {
  display: inline-block;
  margin-top: 1rem;
  background-color: var(--primary-color);
  color: #fff !important; 
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  font-family: var(--font-family);
  font-weight: 500;
  text-decoration: none;
  transition: opacity 0.2s;
}


.btn-add-user:hover {
  opacity: 0.9;
}
</style>

<h2>Manage Users</h2>

<?php
$query = 'SELECT *
  FROM users 
  '.( ( $_SESSION['id'] != 1 && $_SESSION['id'] != 4 )
      ? 'WHERE id = '.(int)$_SESSION['id'].' '
      : '' ).'
  ORDER BY last,first';
$result = mysqli_query( $connect, $query );
?>

<table>
  <tr>
    <th class="center">ID</th>
    <th>Name</th>
    <th>Email</th>
    <th class="center">Edit</th>
    <th class="center">Delete</th>
    <th class="center">Active</th>
  </tr>
  <?php while( $record = mysqli_fetch_assoc( $result ) ): ?>
    <tr>
      <td class="center"><?php echo $record['id']; ?></td>
      <td><?php echo htmlentities( $record['first'] . ' ' . $record['last'] ); ?></td>
      <td>
        <a href="mailto:<?php echo htmlentities($record['email']); ?>">
          <?php echo htmlentities($record['email']); ?>
        </a>
      </td>
      <td class="center actions">
        <a href="users_edit.php?id=<?php echo $record['id']; ?>"
           class="edit">Edit</a>
      </td>
      <td class="center actions">
        <?php if( $_SESSION['id'] != $record['id'] ): ?>
          <a href="users.php?delete=<?php echo $record['id']; ?>"
             onclick="return confirm('Are you sure you want to delete this user?');"
             class="delete">Delete</a>
        <?php endif; ?>
      </td>
      <td class="center"><?php echo $record['active']; ?></td>
    </tr>
  <?php endwhile; ?>
</table>

<p>
  <a href="users_add.php" class="btn-add-user">
    <i class="fas fa-plus-square"></i> Add User
  </a>
</p>

<?php
include( 'includes/footer.php' );
?>
