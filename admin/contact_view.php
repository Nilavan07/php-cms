<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/includes/database.php';  
require __DIR__ . '/includes/functions.php';

secure();


if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: contact.php");
    exit();
}
$message_id = (int)$_GET['id'];

$query  = "
    SELECT *
      FROM messages
     WHERE id = $message_id
     LIMIT 1
";
$result = mysqli_query($connect, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    error_log("View Message Error: message #$message_id not found");
    header("Location: contact.php?error=view_failed");
    exit();
}

$message = mysqli_fetch_assoc($result);
mysqli_free_result($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Message</title>
    <link rel="stylesheet" href="admin‑styles.css">
    <style>
    :root {
      --primary-color:  #6C63FF;
      --text-color:     #333;
      --bg-light:       #f9f9f9;
      --bg-hover:       #f1f1f1;
      --border-color:   #e0e0e0;
      --font-family:    'Poppins', sans-serif;
    }

    .container {
      max-width: 600px;
      margin: 2rem auto;
      padding: 0 1rem;
      font-family: var(--font-family);
      color: var(--text-color);
    }

    .container h1 {
      text-align: center;
      color: var(--primary-color);
      margin-bottom: 1rem;
    }

    .message-details {
      background: #fff;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      padding: 1.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      margin-bottom: 1.5rem;
    }

    .message-details p {
      margin: 0.5rem 0;
      line-height: 1.4;
    }

    .message-details p strong {
      display: inline-block;
      width: 5rem;
      color: #555;
    }

    .message-content {
      margin-top: 1rem;
      padding: 1rem;
      background: var(--bg-light);
      border-radius: 4px;
      line-height: 1.6;
      white-space: pre-wrap;
    }

    .btn {
      display: inline-block;
      background-color: var(--primary-color);
      color: #fff;
      text-decoration: none;
      padding: 0.6rem 1.2rem;
      border-radius: 4px;
      font-weight: 500;
      transition: background-color 0.2s;
    }

    .btn:hover {
      background-color: #5851c4;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Message Details</h1>
        
        <div class="message-details">
            <p><strong>From:</strong>
                <?= htmlspecialchars($message['name'] ?: 'N/A') ?>
            </p>
            <p><strong>Email:</strong>
                <?= htmlspecialchars($message['email'] ?: 'N/A') ?>
            </p>
            <p><strong>Date:</strong>
                <?php if (!empty($message['sent_at'])): ?>
                    <?= date('F j, Y \a\t H:i', strtotime($message['sent_at'])) ?>
                <?php else: ?>
                    Date not available
                <?php endif; ?>
            </p>
            <div class="message-content">
                <?= nl2br(htmlspecialchars($message['message'] ?: 'No message content')) ?>
            </div>
        </div>
        
        <a href="contact.php" class="btn">Back to Messages</a>
    </div>
</body>
</html>
