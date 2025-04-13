<?php

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if(isset($_GET['delete']))
{
    $query = 'DELETE FROM skills
        WHERE id = '.$_GET['delete'].'
        LIMIT 1';
    mysqli_query($connect, $query);
    
    set_message('Skill has been deleted');
    
    header('Location: skills.php');
    die();
}

include('includes/header.php');

$query = 'SELECT *
    FROM skills
    ORDER BY skill_name DESC';
$result = mysqli_query($connect, $query);

?>

<h2>Manage Skills</h2>

<table>
    <tr>
        <th align="center">ID</th>
        <th align="left">Name</th>
        <th align="center">Level</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php while($record = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td align="center"><?php echo $record['id']; ?></td>
            <td align="left">
                <?php echo htmlentities($record['skill_name']); ?>
            </td>
            <td align="center"><?php echo $record['skill_level']; ?></td>
            <td align="center"><a href="skills_edit.php?id=<?php echo $record['id']; ?>">Edit</a></td>
            <td align="center">
                <a href="skills.php?delete=<?php echo $record['id']; ?>" onclick="return confirm('Are you sure you want to delete this skill?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<p><a href="skills_add.php">Add Skill</a></p>

<?php

include('includes/footer.php');

?>