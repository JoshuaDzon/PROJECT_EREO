<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservation for Event Organizer</title>
    <link rel="stylesheet" href="Main.css"> 
    <link rel="stylesheet" href="events.css">
    <link rel="icon" type="image/png" href="images/logo.jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <img src="images/logo.jpeg" alt="" class="logo-img">
        <span>Event Reservation for Event Organizer</span>
    </div>
    <ul class="nav-links">
        <li><a href="Main.php" class="nav-item">Home</a></li>
        <li><a href="events.php" class="nav-item active">Events</a></li>
        <li><a href="contact.php" class="nav-item">Contact</a></li>
        <li><a href="about.php" class="nav-item">About</a></li>
        <li class="account-dropdown">
            <a href="#" class="nav-item">
                <img src="images/pfp.jpg" alt="Account" class="account-icon">
            </a>
            <ul class="dropdown-menu">
                <li><a href="#" onclick="showRegister()">Register</a></li>
                <li><a href="#" onclick="showLogin()">Login</a></li>
            </ul>
        </li>
    </ul>
</nav>

<main class="events-section">
    <div class="events-header">
        <h2>Upcoming Events</h2>
        <p>Browse through our latest events and register today!</p>
    </div>

    <div class="events-grid">
        <div class="event-card">
            <img src="images/event-img1.jpg" alt="Tech Conference 2025" class="event-image">
            <div class="event-details">
                <h3 class="event-title">Tech Conference 2025</h3>
                <p class="event-info"><i class="fas fa-calendar-alt"></i> October 25, 2025</p>
                <p class="event-info"><i class="fas fa-map-marker-alt"></i> SMX Convention Center</p>
                <a href="event_reservation.php" class="event-btn">Register Now</a>
            </div>
        </div>

        <div class="event-card">
            <img src="images/event-img2.jpg" alt="Music Festival" class="event-image">
            <div class="event-details">
                <h3 class="event-title">Manila Music Fest</h3>
                <p class="event-info"><i class="fas fa-calendar-alt"></i> November 10, 2025</p>
                <p class="event-info"><i class="fas fa-map-marker-alt"></i> Rizal Park Open-Air Auditorium</p>
                <a href="event_reservation.php" class="event-btn">Register Now</a>
            </div>
        </div>

        <div class="event-card">
            <img src="images/event-img3.jpg" alt="Food & Wine Expo" class="event-image">
            <div class="event-details">
                <h3 class="event-title">Food & Wine Expo</h3>
                <p class="event-info"><i class="fas fa-calendar-alt"></i> November 28, 2025</p>
                <p class="event-info"><i class="fas fa-map-marker-alt"></i> World Trade Center</p>
                <a href="event_reservation.php" class="event-btn">Register Now</a>
            </div>
        </div>
        
        <div class="event-card">
            <img src="images/event-img4.jpg" alt="Startup Summit" class="event-image">
            <div class="event-details">
                <h3 class="event-title">Startup Summit PH</h3>
                <p class="event-info"><i class="fas fa-calendar-alt"></i> December 5, 2025</p>
                <p class="event-info"><i class="fas fa-map-marker-alt"></i> Makati Business District</p>
                <a href="event_reservation.php" class="event-btn">Register Now</a>
            </div>
        </div>
        
        <div class="event-card">
            <img src="images/event-img5.jpg" alt="Photography Workshop" class="event-image">
            <div class="event-details">
                <h3 class="event-title">Photography Workshop</h3>
                <p class="event-info"><i class="fas fa-calendar-alt"></i> December 15, 2025</p>
                <p class="event-info"><i class="fas fa-map-marker-alt"></i> Quezon City Circle</p>
                <a href="event_reservation.php" class="event-btn">Register Now</a>
            </div>
        </div>
        
        <div class="event-card">
            <img src="images/event-img6.jpg" alt="Health & Wellness Fair" class="event-image">
            <div class="event-details">
                <h3 class="event-title">Health & Wellness Fair</h3>
                <p class="event-info"><i class="fas fa-calendar-alt"></i> January 20, 2026</p>
                <p class="event-info"><i class="fas fa-map-marker-alt"></i> Bonifacio Global City</p>
                <a href="event_reservation.php" class="event-btn">Register Now</a>
            </div>
        </div>

    </div>
</main>

<footer class="site-footer">
    &copy; 2025 Event Management Studio. All rights reserved.
</footer>

<div class="modal-backdrop" id="registerModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('registerModal')">&times;</span>
        <div class="modal-header">
            <h4>Register for a new account</h4>
        </div>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
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
function showRegister() {
    document.getElementById('registerModal').style.display = 'flex';
}

function showLogin() {
    document.getElementById('loginModal').style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

window.onclick = function(event) {
    const registerModal = document.getElementById('registerModal');
    const loginModal = document.getElementById('loginModal');
    if (event.target == registerModal) registerModal.style.display = "none";
    if (event.target == loginModal) loginModal.style.display = "none";
}
</script>

</body>
</html>