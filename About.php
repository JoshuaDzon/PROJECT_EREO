<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservation for Event Organizer - About Us</title>
    <link rel="stylesheet" href="assets/CSS/About.css">

    <link rel="icon" type="image/png" href="images/logo.jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <img src="assets/images/ERFEOlogo.jpg" alt="" class="logo-img">
    </div>
    <ul class="nav-links">
        <li><a href="index.php" class="nav-item">HOME</a></li>
        <li><a href="" class="nav-item">FEEDBACK</a></li>
        <li><a href="About.php" class="nav-item active">ABOUT US</a></li>
        <li class="account-dropdown">
            <a href="#" class="nav-item">
                <img src="assets/images/pfp.jpg" alt="Account" class="account-icon">
            </a>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="showRegister()">Register</a></li>
                <li><a href="#" onclick="showLogin()">Login</a></li>
            </ul>
        </li>
    </ul>
</nav>

<div class="text">
    <p class="title-label">About Page</p>
    <h1>Welcome to Event Reservation for Event Organization</h1>
    <p class="description-text">This website allows organizers to schedule events, accept reservations from clients or attendees, monitor availability, and coordinate logistics, making the overall planning process more efficient and organized.</p>
</div>

<div class="main-content-wrapper">
    
    <div class="about-content two-columns">
        <div class="card purpose-card">
            <h2>Purpose</h2>
            <div class="card-content-scroll">
                <p>It helps the customer to easily book an event at any time instead of calling a person. Automates tasks like booking 
                schedules, confirming reservations, and sending reminders, saving time and reducing manual errors.</p>
            </div>
        </div>

        <div class="card what-youll-find-card">
            <h2>What You’ll Find Here</h2>
            <div class="card-content-scroll">
                <ul>
                    <li>Homepage or overview of the organizer's services.</li>
                    <li>Details of different types of events.</li>
                    <li>Can input the attendees.</li>
                    <li>You can select menus and dishes and pick an event.</li>
                    <li>You can also pick any type of decorations on your event.</li>
                    <li>It displays your receipt.</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="about-content single-card-row">
        <div class="card who-made-it-card">
            <h2>Who Made This Website</h2>
            <div class="card-content-scroll">
                <ul class="team-list">
                    <li>Reallyne Allexa Bautista <span>Project Manager</span></li>
                    <li>Angelica Chereese Ramirez <span>UI/UX Designer</span></li>
                    <li>Ryn Aldrich Capinpin <span>Database Administrator</span></li>
                    <li>Joshua Dizon <span>Programmer</span></li>
                    <li>Kyla Buenavista <span>Documentation</span></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="about-content single-card-row">
        <div class="card contact-display-card">
            <h2>CONTACTS</h2>
            <div class="contact-info">
                <p><b>Address:</b> 28WV+R229, Arellano St, Downtown District, Dagupan City, 2400 Pangasinan</p>
                <p><b>Email:</b> EventResFEO@gmail.com</p>
                <p><b>Phone Number:</b> +63 912 345 6789</p>
            </div>
        </div>
    </div>
    
</div> <footer class="footers">
    &copy; 2025 Event Reservation for Event Organizer. All rights reserved.
</footer>

<div class="modal-backdrop" id="registerModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('registerModal')">&times;</span>
        <div class="modal-header">
            <h4>Register for a new account</h4>
        </div>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Confirm Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" class="modal-btn">Register</button>
        </form>
    </div>
</div>

<div class="modal-backdrop" id="loginModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
        <div class="modal-header">
            <h4>Log In to your account</h4>
        </div>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit" class="modal-btn">Log In</button>
        </form>
    </div>
</div>

<script>
// --- Modal Functions ---
function showRegister() {
    document.getElementById('registerModal').style.display = 'flex';
}

function showLogin() {
    document.getElementById('loginModal').style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const registerModal = document.getElementById('registerModal');
    const loginModal = document.getElementById('loginModal');
    if (event.target == registerModal) registerModal.style.display = "none";
    if (event.target == loginModal) loginModal.style.display = "none";
}
</script>

</body>
</html>