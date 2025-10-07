<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">                     
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservation for Event Organizer</title>
    <link rel="stylesheet" href="assets/CSS/index.css">
    <link rel="icon" type="image/png" href="images/logo.jpg">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-left">
            <img src="assets/images/ERFEOlogo.jpg" alt="Logo" class="logo-img">
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="nav-item active">HOME</a></li>
            <li><a href="#" onclick="showLogin()" class="nav-item">LOG IN</a></li>
            <li><a href="About.php" class="nav-item">ABOUT US</a></li>
            <li class="account-dropdown">
                <a href="#" class="nav-item">
                    <img src="assets/images/pfp.jpg" alt="Account" class="account-icon">
                </a>
                <ul class="dropdown-menu">
                    <li><a href="logout.php">LOG OUT</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <main class="hero-section">
        <div class="hero-content">
            <h1>WELCOME TO ERFEO</h1>
            <p>Making Every Event Memorable</p>
            <p>Plan, reserve, and celebrate your events with ease.</p>
        </div>
    </main>

    <!-- Scrollable Wrapper -->
<section class="events-feedback-wrapper">
    
    <!-- Featured Events -->
    <section class="featured-events-wrapper">
        <?php if (isset($_SESSION['username'])): ?>
                <a href="event_reservation.php" class="book-btn">BOOK RESERVATION</a>
            <?php endif; ?>
        <h3 class="section-title">Featured Events</h3>
        <div class="featured-events-container">
            <div class="event-card">
                <img src="assets/images/event1.png" alt="Pink Event Setup">
            </div>
            <div class="event-card">
                <img src="assets/images/event2.png" alt="White Wedding Setup">
            </div>
            <div class="event-card">
                <img src="assets/images/event3.png" alt="Outdoor Picnic Setup">
            </div>
            <div class="event-card">
                <img src="assets/images/event4.png" alt="Graduation Setup">
            </div>
        </div>
    </section>

    <!-- Share Your Thoughts -->
    <section class="thoughts-section">
        <div class="thoughts-box">
            <h4>Share Your Thoughts</h4>
            <form action="submit_thought.php" method="post" class="thoughts-form">
                <input type="text" id="comment_name" name="name" placeholder="Your Name" required>
                <div class="message-group">
                    <textarea id="comment_message" name="message" placeholder="Write your message..." required></textarea>
                    <button type="submit" aria-label="Send Message" class="send-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </section>

</section>


    <!-- Register Modal -->
    <div class="modal-backdrop" id="registerModal" style="display: none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('registerModal')">&times;</span>
            <div class="modal-header">
                <h4>Create a New Account</h4>
            </div>
            <form action="register.php" method="post">
                <h7>Username</h7>
                <input type="text" name="username" placeholder="Enter Username" required>
                <h7>Password</h7>
                <input type="password" name="password" placeholder="Enter Password" required>
                <h7>Confirm Password</h7>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit" class="modal-btn">Register</button>
            </form>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal-backdrop" id="loginModal" style="display: none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
            <div class="modal-header">
                <h4>Log In to Your Account</h4>
            </div>
            <form action="login.php" method="post">
                <h7>Username</h7>
                <input type="text" name="username" placeholder="Enter Username" required>
                <h7>Password</h7>
                <input type="password" name="password" placeholder="Enter Password" required>
                <button type="submit" class="modal-btn">Log In</button>
                <button type="button" class="modal-btn" onclick="showRegister()">Create Account</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="site-footer">
        &copy; 2025 Event Reservation for Event Organizer. All rights reserved.
    </footer>

    <!-- JS Functions -->
    <script>
        function showLogin() {
            document.getElementById('loginModal').style.display = 'flex';
            document.getElementById('registerModal').style.display = 'none';
        }

        function showRegister() {
            document.getElementById('registerModal').style.display = 'flex';
            document.getElementById('loginModal').style.display = 'none';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>

</body>
</html>
