<?php
include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if(isset($_GET['delete'])) {
    $query = 'DELETE FROM projects WHERE id = '.$_GET['delete'].' LIMIT 1';
    mysqli_query($connect, $query);
    
    // resets the count to 0
    $query = 'SET @count = 0';
    mysqli_query($connect, $query);
    $query = 'UPDATE projects SET projects.id = @count:= @count + 1';
    mysqli_query($connect, $query);
    $query = 'ALTER TABLE projects AUTO_INCREMENT = 1';
    mysqli_query($connect, $query);
    
    set_message('Project has been deleted');
    header('Location: projects.php');
    die();
}

include('includes/header.php');

$query = 'SELECT * FROM projects ORDER BY date DESC';
$result = mysqli_query($connect, $query);
?>

<h2>Manage Projects</h2>

<table class="project-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Preview</th>
            <th>Project Details</th>
            <th>Type</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $counter = 1;
        while($record = mysqli_fetch_assoc($result)): 
        ?>
        <tr>
            <td class="center"><?php echo $counter; ?></td>
            <td class="center">
                <?php if(!empty($record['photo'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($record['photo']); ?>" width="80" height="80" class="project-thumbnail">
                <?php else: ?>
                    <img src="includes/image/profile.png" width="80" height="80" class="project-thumbnail">
                <?php endif; ?>
            </td>
            <td>
                <div class="project-title"><?php echo htmlentities($record['title']); ?></div>
                <div class="project-content"><?php echo substr(htmlentities($record['content']), 0, 100); ?>...</div>
                <?php if(!empty($record['url'])): ?>
                <div class="project-url">
                    <a href="<?php echo htmlentities($record['url']); ?>" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Project
                    </a>
                </div>
                <?php endif; ?>
            </td>
            <td class="center"><?php echo $record['type']; ?></td>
            <td class="center"><?php echo date('M Y', strtotime($record['date'])); ?></td>
            <td class="actions">
                <a href="projects_photo.php?id=<?php echo $record['id']; ?>" class="btn-photo">
                    <i class="fas fa-camera"></i>
                </a>
                <a href="projects_edit.php?id=<?php echo $record['id']; ?>" class="btn-edit">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="projects.php?delete=<?php echo $record['id']; ?>" 
                   class="btn-delete"
                   onclick="return confirm('Are you sure you want to delete this project?');">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        <?php 
        $counter++;
        endwhile; 
        ?>
    </tbody>
</table>

<div class="add-project">
    <a href="projects_add.php" class="btn-add">
        <i class="fas fa-plus-square"></i> Add New Project
    </a>
</div>

<style>
    :root {
  --primary-color: #6C63FF;
  --secondary-color: #2196F3;
  --danger-color:   #f44336;
  --success-color:  #4CAF50;
  --text-color:     #333;
  --bg-light:       #f9f9f9;
  --bg-hover:       #f1f1f1;
  --border-color:   #e0e0e0;
  --font-family:    'Poppins', sans-serif;
}

.project-table {
  width: 100%;
  border-collapse: collapse;
  margin: 2rem 0;
  font-family: var(--font-family);
  font-size: 0.95rem;
  color: var(--text-color);
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.project-table thead th {
  background-color: var(--primary-color);
  color: #fff;
  text-align: left;
  padding: 1rem;
}

.project-table th,
.project-table td {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid var(--border-color);
  vertical-align: middle;
}

.project-table tbody tr:nth-child(even) {
  background-color: var(--bg-light);
}

.project-table tbody tr:hover {
  background-color: var(--bg-hover);
}

.center {
  text-align: center;
}

.project-thumbnail {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border: 1px solid var(--border-color);
  border-radius: 4px;
}

.project-title {
  font-weight: 600;
  margin-bottom: 0.25rem;
}

.project-content {
  color: #666;
  font-size: 0.85rem;
  margin-bottom: 0.5rem;
}

.project-url a {
  color: var(--primary-color);
  text-decoration: none;
  font-size: 0.85rem;
}
.project-url a:hover {
  text-decoration: underline;
}

.actions {
  display: flex;
  gap: 0.5rem;
  justify-content: center;
}

.actions a {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 4px;
  color: #fff;
  text-decoration: none;
  font-size: 1rem;
}

.btn-photo {
  background-color: var(--success-color);
}

.btn-edit {
  background-color: var(--secondary-color);
}

.btn-delete {
  background-color: var(--danger-color);
}

.add-project {
  text-align: center;
  margin: 2rem 0;
}

.btn-add {
  display: inline-block;
  background-color: var(--primary-color);
  color: #fff;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  text-decoration: none;
  font-weight: 500;
}
.btn-add:hover {
  background-color: darken(var(--primary-color), 10%);
}


<?php include('includes/footer.php'); ?>