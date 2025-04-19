<?php
include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($connect, "DELETE FROM skills WHERE id = $id LIMIT 1");
    set_message('Skill has been deleted');
    header('Location: skills.php');
    exit;
}

include('includes/header.php');
?>

<!-- Page‑specific CSS -->
<style>
/*==========================
  Global Variables
==========================*/
:root {
  --primary-color:  #6C63FF;
  --danger-color:   #f44336;
  --text-color:     #333333;
  --bg-light:       #f9f9f9;
  --bg-hover:       #f1f1f1;
  --border-color:   #e0e0e0;
  --font-family:    'Poppins', sans-serif;
}

/*==========================
  Page Wrapper
==========================*/
.container {
  max-width: 900px;
  margin: 2rem auto;
  padding: 0 1rem;
  font-family: var(--font-family);
  color: var(--text-color);
}

/*==========================
  Page Heading
==========================*/
h2 {
  font-size: 1.75rem;
  font-weight: 600;
  text-align: center;
  color: var(--primary-color);
  margin-bottom: 1.5rem;
}

/*==========================
  Skills Table
==========================*/
.skills-table {
  width: 100%;
  border-collapse: collapse;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  margin-bottom: 2rem;
}

.skills-table thead th {
  background-color: var(--primary-color);
  color: #fff;
  text-align: left;
  padding: 0.75rem 1rem;
}

.skills-table th,
.skills-table td {
  border-bottom: 1px solid var(--border-color);
  padding: 0.75rem 1rem;
  vertical-align: middle;
}

.skills-table tbody tr:nth-child(even) {
  background-color: var(--bg-light);
}

.skills-table tbody tr:hover {
  background-color: var(--bg-hover);
}

.skills-table .center {
  text-align: center;
}

/*==========================
  Action Buttons
==========================*/
.actions a {
  display: inline-block;
  padding: 0.5rem 0.75rem;
  margin: 0 0.25rem;
  border-radius: 4px;
  color: #fff;
  text-decoration: none;
  font-size: 0.875rem;
  transition: opacity 0.2s;
}

.actions .btn-edit {
  background-color: var(--primary-color);
}

.actions .btn-delete {
  background-color: var(--danger-color);
}

.actions a:hover {
  opacity: 0.9;
}

/*==========================
  “Add Skill” Button
==========================*/
.btn-add {
  display: inline-block;
  background-color: var(--primary-color);
  color: #fff;            
  text-decoration: none;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  font-weight: 500;
  transition: opacity 0.2s;
}

a.btn-add,
a.btn-add i {
  color: #fff !important;
}


.btn-add:hover {
  opacity: 0.9;
}
</style>

<h2>Manage Skills</h2>

<table class="skills-table">
  <thead>
    <tr>
      <th class="center">ID</th>
      <th>Name</th>
      <th class="center">Level</th>
      <th class="center">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $result = mysqli_query($connect, "SELECT * FROM skills ORDER BY skill_name DESC");
    while ($record = mysqli_fetch_assoc($result)):
        $id    = (int)$record['id'];
        $name  = htmlspecialchars($record['skill_name']);
        $level = (int)$record['skill_level'];
    ?>
    <tr>
      <td class="center"><?= $id ?></td>
      <td><?= $name ?></td>
      <td class="center"><?= $level ?>%</td>
      <td class="actions">
        <a href="skills_edit.php?id=<?= $id ?>" class="btn-edit">Edit</a>
        <a href="skills.php?delete=<?= $id ?>"
           class="btn-delete"
           onclick="return confirm('Are you sure you want to delete this skill?');">
          Delete
        </a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<p>
  <a href="skills_add.php" class="btn-add">
    <i class="fas fa-plus-square"></i> Add Skill
  </a>
</p>

<?php include('includes/footer.php'); ?>
