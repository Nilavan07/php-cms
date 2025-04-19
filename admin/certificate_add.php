<?php
include 'includes/database.php';
include 'includes/config.php';
include 'includes/functions.php';

secure();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    foreach (['name','issuer','date'] as $f) {
        if (empty($_POST[$f])) {
            set_message('Please fill in all required fields.', 'error');
            header('Location: certificate_add.php');
            exit;
        }
    }

    
    $name    = mysqli_real_escape_string($connect, $_POST['name']);
    $issuer  = mysqli_real_escape_string($connect, $_POST['issuer']);
    $date    = mysqli_real_escape_string($connect, $_POST['date']);
    $desc    = mysqli_real_escape_string(
                   $connect,
                   $_POST['description'] ?? ''
               );

    
    $sql = "
      INSERT INTO certificates
        (name, issuer, date, description)
      VALUES
        ('$name', '$issuer', '$date', '$desc')
    ";
    mysqli_query($connect, $sql);
    set_message('Certificate has been added');
    header('Location: certificates.php');
    exit;
}

include 'includes/header.php';
?>

<div class="container">
  <h2>Add Certificate</h2>
  <form method="post">
    <label for="name">Certificate Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="issuer">Issuer:</label><br>
    <input type="text" id="issuer" name="issuer" required><br><br>

    <label for="date">Date:</label><br>
    <input type="date" id="date" name="date" required><br><br>

    <label for="description">Description (optional):</label><br>
    <textarea id="description" name="description" rows="5"></textarea><br><br>

    <input type="submit" value="Add Certificate">
    <a href="certificates.php" class="btn">Cancel</a>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
