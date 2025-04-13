<?php
include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if(isset($_POST['skill_name'])) {
    if($_POST['skill_name'] && $_POST['skill_level']) {
        $query = 'INSERT INTO skills (
            skill_name,
            skill_level
        ) VALUES (
            "'.mysqli_real_escape_string($connect, $_POST['skill_name']).'",
            "'.mysqli_real_escape_string($connect, $_POST['skill_level']).'"
        )';
        mysqli_query($connect, $query);
        
        set_message('Skill has been added');
    }
    
    header('Location: skills.php');
    die();
}

include('includes/header.php');
?>

<h2>Add Skill</h2>

<form method="post">
    <label for="skill_name">Skill Name:</label>
    <input type="text" name="skill_name" id="skill_name" required>
    
    <br>
    
    <label for="skill_level">Skill Level:</label>
    <input type="text" name="skill_level" id="skill_level" required>
    
    <br>
    
    <input type="submit" value="Add Skill">
</form>

<p><a href="skills.php"><i class="fas fa-arrow-circle-left"></i> Return to Skill List</a></p>

<?php
include('includes/footer.php');
?>