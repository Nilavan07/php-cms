<?php
session_start();
require __DIR__.'/includes/database.php';
require __DIR__.'/includes/config.php';
require __DIR__.'/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        
        $required = ['name', 'email', 'message'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields");
            }
        }

        
        $name = htmlspecialchars($_POST['name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars($_POST['message']);

        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address format");
        }

        
        $stmt = $connect->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        
        if (!$stmt->execute()) {
            throw new Exception("Database error: " . $stmt->error);
        }

        
        $_SESSION['form_message'] = [
            'type' => 'success',
            'text' => 'Message sent successfully!'
        ];
        header("Location: ../index.php#contact");
        exit();

    } catch (Exception $e) {
        
        $_SESSION['form_message'] = [
            'type' => 'error',
            'text' => $e->getMessage()
        ];
        header("Location: ../index.php#contact");
        exit();
    }
}


header("Location: ../index.php");
exit();
?>