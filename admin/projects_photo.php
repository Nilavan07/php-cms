<?php
include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if(!isset($_GET['id'])) {
    header('Location: projects.php');
    die();
}

if(isset($_FILES['photo'])) {
    if($_FILES['photo']['error'] == 0) {
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
        
        $query = 'UPDATE projects SET photo = ? WHERE id = ? LIMIT 1';
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "si", $photo, $_GET['id']);
        mysqli_stmt_execute($stmt);
        
        set_message('Project photo has been updated');
        header('Location: projects.php');
        die();
    }
}

if(isset($_GET['delete'])) {
    $query = 'UPDATE projects SET photo = NULL WHERE id = '.$_GET['id'].' LIMIT 1';
    mysqli_query($connect, $query);
    set_message('Project photo has been deleted');
    header('Location: projects.php');
    die();
}

$query = 'SELECT * FROM projects WHERE id = '.$_GET['id'].' LIMIT 1';
$result = mysqli_query($connect, $query);

if(!mysqli_num_rows($result)) {
    header('Location: projects.php');
    die();
}

$record = mysqli_fetch_assoc($result);

include('includes/header.php');
?>

<h2>Edit Project Photo</h2>

<p>Note: For best results, photos should be approximately 800 x 800 pixels.</p>

<?php if(!empty($record['photo'])): ?>
    <p><img src="data:image/jpeg;base64,<?= base64_encode($record['photo']) ?>" style="max-width: 200px; height: auto;"></p>
    <p><a href="projects_photo.php?id=<?php echo $_GET['id']; ?>&delete"><i class="fas fa-trash-alt"></i> Delete this Photo</a></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
    <label for="photo">Photo:</label>
    <input type="file" name="photo" id="photo" accept="image/jpeg,image/png,image/gif" required>
    <br>
    <input type="submit" value="Save Photo">
</form>

<p><a href="projects.php"><i class="fas fa-arrow-circle-left"></i> Return to Project List</a></p>

<?php include('includes/footer.php'); ?>