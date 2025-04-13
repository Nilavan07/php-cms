<?php
include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

// Redirect if no ID is provided
if(!isset($_GET['id'])) {
    header('Location: skills.php');
    die();
}

// Process form submission
if(isset($_POST['skill_name'])) {
    if($_POST['skill_name'] && $_POST['skill_level']) {
        $query = 'UPDATE skills SET
            skill_name = "'.mysqli_real_escape_string($connect, $_POST['skill_name']).'",
            skill_level = "'.mysqli_real_escape_string($connect, $_POST['skill_level']).'"
            WHERE id = '.intval($_GET['id']).'
            LIMIT 1';
        mysqli_query($connect, $query);
        
        set_message('Skill has been updated');
        header('Location: skills.php');
        die();
    }
}

// Fetch the existing skill data
$query = 'SELECT * FROM skills WHERE id = '.intval($_GET['id']).' LIMIT 1';
$result = mysqli_query($connect, $query);

if(!mysqli_num_rows($result)) {
    header('Location: skills.php');
    die();
}

$record = mysqli_fetch_assoc($result);

include('includes/header.php');
?>

<h2>Edit Skill</h2>

<form method="post">
    <label for="skill_name">Skill Name:</label>
    <input type="text" name="skill_name" id="skill_name" 
           value="<?php echo htmlentities($record['skill_name']); ?>" required>
    
    <br>
    
    <label for="skill_level">Skill Level:</label>
    <input type="text" name="skill_level" id="skill_level" 
           value="<?php echo htmlentities($record['skill_level']); ?>" required>
    
    <br>
    
    <input type="submit" value="Update Skill">
</form>

<p><a href="skills.php"><i class="fas fa-arrow-circle-left"></i> Return to Skill List</a></p>

<?php
include('includes/footer.php');
?>