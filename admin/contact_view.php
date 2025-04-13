<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (session_status() === PHP_SESSION_NONE) session_start();
require __DIR__.'/includes/database.php';
require __DIR__.'/includes/functions.php';
secure();


if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: contact.php");
    exit();
}

$message_id = (int)$_GET['id'];

try {
    
    $stmt = $connect->prepare("SELECT * FROM messages WHERE id = ?");
    $stmt->bind_param('i', $message_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Message not found");
    }

    $message = $result->fetch_assoc();

} catch(Exception $e) {
    
    error_log("View Message Error: " . $e->getMessage());
    header("Location: contact.php?error=view_failed");
    exit();
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>View Message</title>
    <link rel="stylesheet" href="admin-styles.css">
</head>
<body>
    <div class="container">
        <h1>Message Details</h1>
        
        <?php if(isset($message)): ?>
            <div class="message-details">
                <p><strong>From:</strong> <?= htmlspecialchars($message['name'] ?? 'N/A') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($message['email'] ?? 'N/A') ?></p>
                <p><strong>Date:</strong> 
                    <?php if(!empty($message['sent_at'])): ?>
                        <?= date('F j, Y \a\t H:i', strtotime($message['sent_at'])) ?>
                    <?php else: ?>
                        Date not available
                    <?php endif; ?>
                </p>
                <div class="message-content">
                    <?= nl2br(htmlspecialchars($message['message'] ?? 'No message content')) ?>
                </div>
            </div>
        <?php else: ?>
            <p class="error">Message not found</p>
        <?php endif; ?>
        
        <a href="contact.php" class="btn">Back to Messages</a>
    </div>
</body>
</html>