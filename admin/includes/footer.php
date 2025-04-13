<?php
?>
    </div> 
    <footer class="admin-footer">
      <div class="footer-content">
        <p>&copy; <?php echo date('Y'); ?> Your Portfolio Admin. All rights reserved.</p>
        <div class="footer-links">
          <a href="#"><i class="fab fa-github"></i></a>
          <a href="#"><i class="fab fa-linkedin"></i></a>
          <a href="#"><i class="fas fa-envelope"></i></a>
        </div>
      </div>
    </footer>
    
    <style>
      .admin-footer {
        background-color: var(--dark-color);
        color: white;
        padding: 1.5rem 2rem;
        text-align: center;
        margin-top: 18rem;
      }
      
      .footer-content {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      
      .footer-links {
        display: flex;
        gap: 1rem;
      }
      
      .footer-links a {
        color: white;
        font-size: 1.2rem;
        transition: color 0.3s ease;
      }
      
      .footer-links a:hover {
        color: var(--accent-color);
      }
    </style>
  </body>
</html>