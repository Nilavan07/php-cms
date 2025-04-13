<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portfolio Admin | <?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></title>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <link href="styles.css" type="text/css" rel="stylesheet">
  <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
  
  <style>
    :root {
      --primary-color:rgb(90, 157, 196);
      --secondary-color: #3f37c9;
      --accent-color:rgb(54, 170, 205);
      --light-color: #f8f9fa;
      --dark-color: #212529;
      --success-color: #4bb543;
      --warning-color: #f0ad4e;
      --danger-color: #d9534f;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f5f7fa;
      color: var(--dark-color);
    }
    
    .admin-header {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      padding: 1rem 2rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .admin-header h1 {
      margin: 0;
      font-size: 1.5rem;
      font-weight: 600;
    }
    
    .admin-nav {
      display: flex;
      gap: 1.5rem;
    }
    
    .admin-nav a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .admin-nav a:hover {
      color: var(--accent-color);
    }
    
    .main-container {
      max-width: 1400px;
      margin: 2rem auto;
      padding: 0 2rem;
    }
    
    .notification {
      padding: 1rem;
      margin: 1rem 0;
      border-radius: 4px;
      text-align: center;
    }
    
    .notification.success {
      background-color: rgba(75, 181, 67, 0.2);
      color: var(--success-color);
      border: 1px solid var(--success-color);
    }
  </style>
</head>
<body>
  
  <header class="admin-header">
    <h1><i class="fas fa-user-shield"></i> Portfolio Admin Panel</h1>
    
    <?php if(isset($_SESSION['id'])): ?>
      <nav class="admin-nav">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="skills.php"><i class="fas fa-code"></i> Skills</a>
        <a href="projects.php"><i class="fas fa-project-diagram"></i> Projects</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </nav>
    <?php endif; ?>
  </header>
  
  <div class="main-container">
    <?php 
      $message = get_message();
      if($message): 
    ?>
      <div class="notification success"><?php echo $message; ?></div>
    <?php endif; ?>