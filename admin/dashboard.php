<?php
include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();
include('includes/header.php');
?>

<!-- Dashboard Styles -->
<style>
:root {
  --primary-color: #6C63FF;
  --text-color:    #333333;
  --bg:            #f0f2f5;
  --shadow-md:     0 4px 6px rgba(0,0,0,0.1);
  --shadow-lg:     0 8px 20px rgba(0,0,0,0.15);
  --font:          'Poppins', sans-serif;
}

body {
  background-color: var(--bg);
  font-family: var(--font);
  color: var(--text-color);
}

.dashboard-container {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 0 1rem;
}

.quick-links h2 {
  font-size: 1.8rem;
  margin-bottom: 1rem;
  text-align: center;
}

.management-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
}

.management-card {
  background: #fff;
  padding: 2rem 1rem;
  border-radius: 8px;
  text-align: center;
  box-shadow: var(--shadow-md);
  text-decoration: none;
  color: var(--text-color);
  transition: transform 0.3s, box-shadow 0.3s, background 0.3s, color 0.3s;
}

.management-card i {
  font-size: 2.5rem;
  margin-bottom: 0.75rem;
  display: block;
  color: var(--primary-color);
  transition: color 0.3s;
}

.management-card h3 {
  margin: 0.5rem 0;
  font-size: 1.2rem;
}

.management-card p {
  font-size: 0.9rem;
  opacity: 0.8;
}

.management-card:hover {
  transform: translateY(-6px);
  box-shadow: var(--shadow-lg);
  background: var(--primary-color);
  color: #fff;
}

.management-card:hover i {
  color: #fff;
}

@media (max-width: 480px) {
  .management-grid {
    grid-template-columns: 1fr;
  }
}
</style>

<div class="dashboard-container">
  <h2>Quick Management</h2>
  <div class="management-grid">
    <a href="projects.php" class="management-card">
      <i class="fas fa-project-diagram"></i>
      <h3>Manage Projects</h3>
      <p>View, add, edit, or delete your projects</p>
    </a>
    <a href="skills.php" class="management-card">
      <i class="fas fa-code"></i>
      <h3>Manage Skills</h3>
      <p>View, add, edit, or delete technical skills</p>
    </a>
    <a href="certificates.php" class="management-card">
      <i class="fas fa-certificate"></i>
      <h3>Manage Certificates</h3>
      <p>View, add, edit, or delete certifications</p>
    </a>
    <a href="contact.php" class="management-card">
      <i class="fas fa-envelope"></i>
      <h3>View Messages</h3>
      <p>Read and delete user messages</p>
    </a>
    <a href="users.php" class="management-card">
      <i class="fas fa-user-cog"></i>
      <h3>Manage Users</h3>
      <p>View, add, edit, or delete admin users</p>
    </a>
  </div>
</div>

<?php
include('includes/footer.php');
?>
