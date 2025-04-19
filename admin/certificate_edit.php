<?php
include 'includes/database.php';
include 'includes/config.php';
include 'includes/functions.php';

secure();


if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: certificates.php');
    exit;
}
$id = (int)$_GET['id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['name','issuer','date'] as $f) {
        if (empty($_POST[$f])) {
            set_message('Please fill in all required fields.', 'error');
            header("Location: certificate_edit.php?id=$id");
            exit;
        }
    }

    
    $name   = mysqli_real_escape_string($connect, $_POST['name']);
    $issuer = mysqli_real_escape_string($connect, $_POST['issuer']);
    $date   = mysqli_real_escape_string($connect, $_POST['date']);
    $desc   = mysqli_real_escape_string(
                  $connect,
                  $_POST['description'] ?? ''
              );

    // Update
    $sql = "
      UPDATE certificates
         SET name        = '$name',
             issuer      = '$issuer',
             date        = '$date',
             description = '$desc'
       WHERE id = $id
      LIMIT 1
    ";
    mysqli_query($connect, $sql);
    set_message('Certificate has been updated');
    header('Location: certificates.php');
    exit;
}

// Fetch existing data
$res = mysqli_query(
    $connect,
    "SELECT * FROM certificates WHERE id = $id LIMIT 1"
);
if (! $cert = mysqli_fetch_assoc($res)) {
    header('Location: certificates.php');
    exit;
}
mysqli_free_result($res);

include 'includes/header.php';
?>

<div class="container">
  <h2>Edit Certificate</h2>
  <form method="post">
    <label for="name">Certificate Name:</label><br>
    <input type="text" id="name" name="name"
           value="<?= htmlspecialchars($cert['name']) ?>" required><br><br>

    <label for="issuer">Issuer:</label><br>
    <input type="text" id="issuer" name="issuer"
           value="<?= htmlspecialchars($cert['issuer']) ?>" required><br><br>

    <label for="date">Date:</label><br>
    <input type="date" id="date" name="date"
           value="<?= htmlspecialchars($cert['date']) ?>" required><br><br>

    <label for="description">Description (optional):</label><br>
    <textarea id="description" name="description" rows="5"><?= 
      htmlspecialchars($cert['description'])
    ?></textarea><br><br>

    <input type="submit" value="Update Certificate">
    <a href="certificates.php" class="btn">Cancel</a>
  </form>
</div>

<?php include 'includes/footer.php'; ?>
