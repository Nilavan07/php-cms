<?php
session_start();
require __DIR__ . '/includes/database.php';  
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        
        $required = ['name','email','message'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields");
            }
        }

        
        $name    = trim($_POST['name']);
        $email   = trim($_POST['email']);
        $message = trim($_POST['message']);

        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address format");
        }

        
        $nameEsc    = mysqli_real_escape_string($connect, htmlspecialchars($name));
        $emailEsc   = mysqli_real_escape_string($connect, htmlspecialchars($email));
        $messageEsc = mysqli_real_escape_string($connect, htmlspecialchars($message));

        
        $query = "
            INSERT INTO messages (name, email, message)
            VALUES (
                '{$nameEsc}',
                '{$emailEsc}',
                '{$messageEsc}'
            )
        ";
        if (! mysqli_query($connect, $query)) {
            throw new Exception("Database error: " . mysqli_error($connect));
        }

        
        $_SESSION['form_message'] = [
            'type' => 'success',
            'text' => 'Message sent successfully!'
        ];
    } catch (Exception $e) {
        
        $_SESSION['form_message'] = [
            'type' => 'error',
            'text' => $e->getMessage()
        ];
    }

    
    header("Location: ../index.php#contact");
    exit();
}


header("Location: ../index.php");
exit();
