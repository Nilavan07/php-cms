<?php
include('admin/includes/database.php');
include('admin/includes/config.php');
include('admin/includes/functions.php');

// Get projects
$projects_query  = 'SELECT * FROM projects ORDER BY date DESC';
$projects_result = mysqli_query($connect, $projects_query);

// Get skills
$skills_query    = 'SELECT * FROM skills ORDER BY skill_level DESC';
$skills_result   = mysqli_query($connect, $skills_query);

// Get certificates
$certs_query     = 'SELECT * FROM certificates ORDER BY date DESC';
$certs_result    = mysqli_query($connect, $certs_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>My Portfolio | Creative Developer</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
  <header class="hero">
    <div class="container">
      <h1>Hello, I'm <span>John Doe</span></h1>
      <p class="tagline">Web Developer</p>
      <nav class="main-nav">
        <a href="#projects">Projects</a>
        <a href="#skills">Skills</a>
        <a href="#certificates">Certificates</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
      </nav>
    </div>
  </header>

  <main class="container">
    <!-- Projects Section -->
    <section id="projects" class="projects-section">
      <h2>My Projects</h2>
      <p class="section-subtitle"><?php echo mysqli_num_rows($projects_result); ?> featured works</p>
      
      <div class="projects-grid">
        <?php while ($project = mysqli_fetch_assoc($projects_result)): ?>
          <article class="project-card">
            <?php if ($project['photo']): ?>
              <div class="project-image">
                <img
                  src="admin/image.php?type=project&id=<?php echo $project['id']; ?>&width=800&height=500"
                  alt="<?php echo htmlspecialchars($project['title']); ?>"
                >
                <span class="project-type"><?php echo htmlspecialchars($project['type'] ?: 'Project'); ?></span>
              </div>
            <?php endif; ?>
            
            <div class="project-content">
              <h3><?php echo htmlspecialchars($project['title']); ?></h3>
              <?php if ($project['date']): ?>
                <p class="project-date"><?php echo date('F Y', strtotime($project['date'])); ?></p>
              <?php endif; ?>
              <div class="project-description">
                <?php echo $project['content']; ?>
              </div>
              <?php if ($project['url']): ?>
                <a href="<?php echo htmlspecialchars($project['url']); ?>" class="btn" target="_blank">View Project</a>
              <?php endif; ?>
            </div>
          </article>
        <?php endwhile; ?>
      </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="skills-section">
      <h2>My Skills</h2>
      <p class="section-subtitle">Technologies I work with</p>
      
      <div class="skills-grid">
        <?php while ($skill = mysqli_fetch_assoc($skills_result)): ?>
          <div class="skill-item">
            <h3><?php echo htmlspecialchars($skill['skill_name']); ?></h3>
            <div class="skill-level">
              <div class="skill-progress" style="width: <?php echo (int)$skill['skill_level']; ?>%">
                <span><?php echo (int)$skill['skill_level']; ?>%</span>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </section>

    <!-- Certificates Section -->
    <section id="certificates" class="certificates-section">
      <h2>My Certificates</h2>
      <p class="section-subtitle"><?php echo mysqli_num_rows($certs_result); ?> earned certificates</p>

      <div class="certificates-grid">
        <?php while ($cert = mysqli_fetch_assoc($certs_result)): ?>
          <div class="certificate-card">
            <h3><?php echo htmlspecialchars($cert['name']); ?></h3>
            <p class="certificate-issuer">Issued by <?php echo htmlspecialchars($cert['issuer']); ?></p>
            <?php if (!empty($cert['date'])): ?>
              <p class="certificate-date"><?php echo date('F j, Y', strtotime($cert['date'])); ?></p>
            <?php endif; ?>
            <?php if (!empty($cert['description'])): ?>
              <div class="certificate-description"><?php echo nl2br(htmlspecialchars($cert['description'])); ?></div>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
      <div class="about-content">
        <h2>About Me</h2>
        <p>Creative and detail-oriented Web Developer with a passion for building responsive, user-friendly websites and web applications. Skilled in front-end and back-end development with a strong foundation in HTML, CSS, JavaScript, and modern frameworks. Experienced in creating dynamic user experiences, working with APIs, and deploying full-stack applications. Dedicated to continuous learning and solving real-world problems through clean, efficient code and thoughtful design.</p>
      </div>
      <div class="about-image">
        <img src="assets/profile.jpeg" alt="Profile Image">
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
      <h2>Get In Touch</h2>
      <p class="section-subtitle">Have a project in mind? Let's talk!</p>

      <?php if (isset($_SESSION['form_message'])): ?>
        <div class="message-alert <?php echo $_SESSION['form_message']['type']; ?>">
          <?php echo $_SESSION['form_message']['text']; ?>
        </div>
        <?php unset($_SESSION['form_message']); ?>
      <?php endif; ?>

      <form action="admin/process_contact.php" method="post" class="contact-form">
        <div class="form-group">
          <input type="text" name="name" placeholder="Your Name" required>
        </div>
        <div class="form-group">
          <input type="email" name="email" placeholder="Your Email" required>
        </div>
        <div class="form-group">
          <textarea name="message" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit" class="btn">Send Message</button>
      </form>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container">
      <p>&copy; <?php echo date('Y'); ?> My Portfolio. All rights reserved.</p>
      <div class="social-links">
        <a href="#"><i class="fab fa-github"></i></a>
        <a href="#"><i class="fab fa-linkedin"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
  </footer>
</body>
</html>
