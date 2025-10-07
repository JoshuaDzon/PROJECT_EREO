<?php
session_start();

// Database connection
// *** I-ASSUME KO PA RIN ITO ANG GINAGAMIT MO: ***
$host = "localhost";
$user = "root";
$password = "";
$dbname = "event_reservation";

$conn = new mysqli($host, $user, $password, $dbname);
if($conn->connect_error){
    // In a production environment, you should log this error, not display it directly
    die("Connection failed: " . $conn->connect_error);
}

// 1. Kumuha ng lahat ng NAKA-RESERVE nang PETSA
$booked_dates = [];
// **ASSUMPTION:** Ang iyong table para sa reservations ay 'reservations' at ang column ng petsa ay 'event_date'.
$sql = "SELECT event_date FROM reservations"; 
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // I-format ang petsa para sa JavaScript (YYYY-MM-DD)
        $booked_dates[] = date('Y-m-d', strtotime($row['event_date']));
    }
}
$conn->close();

// I-convert ang PHP array sa JSON string para magamit sa JavaScript
$booked_dates_json = json_encode($booked_dates);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservation for Event Organizer</title>
    <link rel="stylesheet" href="assets/CSS/events.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-left">
            <img src="assets/images/ERFEOlogo.jpg" alt="" class="logo-img">
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="nav-item active">HOME</a></li>
            <li><a href="event_reservation.php" class="nav-item">FEEDBACK</a></li>
            <li><a href="About.php" class="nav-item">ABOUT US</a></li>
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

<main class="main-content">
    <aside class="sidebar" id="mySidebar">
    
    <button class="toggle-btn" onclick="toggleSidebar()">
        <span id="toggleIcon">&lt;</span> 
    </button>
    
    <div class="sidebar-item active" data-target="attendees-section" data-order="1">
        <i class="fas fa-calendar-alt"></i>
        <span class="text-name">SET SCHEDULE</span>
    </div>
    <div class="sidebar-item" data-target="event-type-section" data-order="2">
        <i class="fas fa-calendar-day"></i>
        <span class="text-name">EVENT TYPE</span>
    </div>
    <div class="sidebar-item" data-target="guest-count-section" data-order="3">
        <i class="fas fa-users"></i>
        <span class="text-name">ATTENDEES</span>
    </div>
    <div class="sidebar-item" data-target="menu-section" data-order="4">
        <i class="fas fa-utensils"></i>
        <span class="text-name">MENU</span>
    </div>
    <div class="sidebar-item" data-target="decor-section" data-order="5">
        <i class="fas fa-paint-roller"></i>
        <span class="text-name">DECORATIONS</span>
    </div>
    <div class="sidebar-item" data-target="sound-section" data-order="6">
        <i class="fas fa-volume-up"></i>
        <span class="text-name">SOUND SYSTEM & MCs</span>
    </div>
    <div class="sidebar-item" data-target="summary-section" data-order="7">
        <i class="fas fa-file-invoice-dollar"></i>
        <span class="text-name">RECEIPT & PAYMENT</span>
    </div>
</aside>

    <form id="reservationForm" action="submit_final_details.php" method="post" style="flex: 1;">
        
        <div class="content-section active" id="attendees-section">
            <h2>Choose the Date</h2>
            <p>Select the date you want to celebrate.</p>
            
            <div class="form-section" id="datetime-guests-section">
                <div class="input-group">
                    <label><b>Select Event Date:</b></label>
                    <input type="text" name="event_date" id="event_date_picker" placeholder="Select a Date" required>
                </div>
                
                <div class="input-group">
                    <label><b>Select Event Time:</b></label>
                    <input type="time" name="event_time" id="event_time" required>
                </div>
            </div>
             <div class="form-section">
                <label for="reservation_name">Name</label>
                <input type="text" name="reservation_name" id="reservation_name" placeholder="Enter Full Name" required>

                <label for="contact_number">Contact Number</label>
                <input type="text" name="contact_number" id="contact_number" placeholder="Enter Contact Number" required>

                <label for="event_location">Address/Location</label>
                <input type="text" name="event_location" id="event_location" placeholder="Enter Address/Location" required>
            </div>
            
            <button type="button" class="confirm-phase-btn" data-phase-target="event-type-section">Confirm & Proceed</button>
        </div>

        <div class="content-section" id="event-type-section">
            <h2>Choose Your Event Type</h2>
            <p>Select the type of event you're planning.</p>
            <div class="event-grid">
                <div class="event-card" data-event-type="Wedding">
                    <i class="fas fa-ring"></i>
                    <h3>Wedding</h3>
                    <p>Create magical moments</p>
                </div>
                <div class="event-card" data-event-type="Christening">
                    <i class="fas fa-church"></i>
                    <h3>Christening</h3>
                    <p>Rejoicing being child of God</p>
                </div>
                <div class="event-card" data-event-type="Birthday">
                    <i class="fas fa-birthday-cake"></i>
                    <h3>Birthday</h3>
                    <p>Celebrate another year</p>
                </div>
                <div class="event-card" data-event-type="Graduation">
                    <i class="fas fa-user-graduate"></i>
                    <h3>Graduation</h3>
                    <p>Honor achievements</p>
                </div>
                <div class="event-card" data-event-type="Reunion">
                    <i class="fas fa-users"></i>
                    <h3>Reunion</h3>
                    <p>Reconnect with family</p>
                </div>
                <div class="event-card" data-event-type="Corporate">
                    <i class="fas fa-briefcase"></i>
                    <h3>Corporate Event</h3>
                    <p>Professional gathering</p>
                </div>
            </div>
            <input type="hidden" name="event_type" id="event_type_input" required>
            <input type="hidden" name="event_specific_details" id="event_specific_details_input">
             </div>

        <div class="content-section" id="guest-count-section">
            <h2>Manage Attendees</h2>
            <p>Distribute your expected guests (Total: <span id="guest-count-label" style="font-weight:bold;">50</span>) into categories. The total must match!</p>

            <div class="form-section" id="datetime-guests-section">    
                <div class="input-group">
                    <label>Expected Total Guests (Minimum 50):</label>
                    <input type="number" name="attendees" id="total_guests" min="100" value="100" required>
                </div>
            </div>
            <div class="guest-categorization">
                <div class="guest-category" data-category="Family">
                    <h4>Family <span class="guest-count">0</span> guests</h4>
                    <div class="counter">
                        <button type="button" class="decrement">-</button>
                        <span class="value">0</span>
                        <button type="button" class="increment">+</button>
                    </div>
                </div>
                <div class="guest-category" data-category="Friends">
                    <h4>Friends <span class="guest-count">0</span> guests</h4>
                    <div class="counter">
                        <button type="button" class="decrement">-</button>
                        <span class="value">0</span>
                        <button type="button" class="increment">+</button>
                    </div>
                </div>
                <div class="guest-category" data-category="Colleagues">
                    <h4>Colleagues <span class="guest-count">0</span> guests</h4>
                    <div class="counter">
                        <button type="button" class="decrement">-</button>
                        <span class="value">0</span>
                        <button type="button" class="increment">+</button>
                    </div>
                </div>
                <div class="guest-category" data-category="VIP Guests">
                    <h4>VIP Guests <span class="guest-count">0</span> guests</h4>
                    <div class="counter">
                        <button type="button" class="decrement">-</button>
                        <span class="value">0</span>
                        <button type="button" class="increment">+</button>
                    </div>
                </div>
            </div>
            <div class="guest-summary-stats">
                <div class="stat">
                    Total Expected
                    <div class="stat-value" id="total-expected">50</div>
                </div>
                <div class="stat">
                    Categorized
                    <div class="stat-value" id="total-categorized">0</div>
                </div>
                <div class="stat">
                    Pending (Must be 0)
                    <div class="stat-value" id="total-pending">50</div>
                </div>
            </div>
            <input type="hidden" name="attendee_categories" id="attendee_categories_input">

            <button type="button" class="confirm-phase-btn" data-phase-target="menu-section">Confirm Attendees & Proceed</button>
        </div>


        <div class="content-section" id="menu-section">
            <h2>Menu Planning</h2>
            <p>Create the perfect dining experience for your guest</p>
            <div class="tab-menu" id="menu-tabs">
                <div class="tab-item active" data-tab-target="appetizers">Appetizers</div>
                <div class="tab-item" data-tab-target="main-course">Main Course</div>
                <div class="tab-item" data-tab-target="beverages">Beverages</div>
                <div class="tab-item" data-tab-target="desserts">Desserts</div>
            </div>
            <div id="appetizers" class="item-list active">
                <div class="item-card" data-name="Cheese Stuffed Crispy Potato" data-price="18">
                    <div class="item-card-content">
                        <img src="images/pic1.png" alt="Crispy Potato" onerror="this.src='https://via.placeholder.com/80?text=Appetizer+1'">
                        <div>
                            <h4>Cheese Stuffed Crispy Potato</h4>
                            <p>Inspired by Western comfort food. ($18/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Cheese Stuffed Crispy Potato" value="0" min="0" data-price="18" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Tamarind-Glazed Chicken wings" data-price="22">
                    <div class="item-card-content">
                        <img src="images/pic2.png" alt="Chicken Wings" onerror="this.src='https://via.placeholder.com/80?text=Appetizer+2'">
                        <div>
                            <h4>Tamarind-Glazed Chicken wings</h4>
                            <p>Filipino version style of chicken wings. ($22/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Tamarind-Glazed Chicken wings" value="0" min="0" data-price="22" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Kesong Puti Caprese Skewers" data-price="45">
                    <div class="item-card-content">
                        <img src="images/pic3.png" alt="Kesong Puti Skewers" onerror="this.src='https://via.placeholder.com/80?text=Appetizer+3'">
                        <div>
                            <h4>Kesong Puti Caprese Skewers</h4>
                            <p>Filipino and Italian fusion. ($45/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Kesong Puti Caprese Skewers" value="0" min="0" data-price="45" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Prawn Cocktails" data-price="19">
                    <div class="item-card-content">
                        <img src="images/prawn_cocktails.jpg" alt="Prawn Cocktails" onerror="this.src='https://via.placeholder.com/80?text=Appetizer+4'">
                        <div>
                            <h4>Prawn Cocktails</h4>
                            <p>Western cuisine, salty appetizer. ($19/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Prawn Cocktails" value="0" min="0" data-price="19" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Stuffed Mushroom" data-price="19">
                    <div class="item-card-content">
                        <img src="images/prawn_cocktails.jpg" alt="Prawn Cocktails" onerror="this.src='https://via.placeholder.com/80?text=Appetizer+4'">
                        <div>
                            <h4>Stuffed Mushroom</h4>
                            <p>Mushroom caps filled with cheese. ($19/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Prawn Cocktails" value="0" min="0" data-price="19" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="French Onion dip cups" data-price="19">
                    <div class="item-card-content">
                        <img src="images/prawn_cocktails.jpg" alt="Prawn Cocktails" onerror="this.src='https://via.placeholder.com/80?text=Appetizer+4'">
                        <div>
                            <h4>French Onion dip cups</h4>
                            <p>Tasty little cups are packed with warm, creamy and cheesy onion dip. ($19/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Prawn Cocktails" value="0" min="0" data-price="19" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Cheese Broccoli Puffs" data-price="19">
                    <div class="item-card-content">
                        <img src="images/prawn_cocktails.jpg" alt="Prawn Cocktails" onerror="this.src='https://via.placeholder.com/80?text=Appetizer+4'">
                        <div>
                            <h4>Cheese Broccoli Puffs</h4>
                            <p>Puff pastry with broccoli tucked inside, melty mozzarella, creamy ricotta and fragant dill. ($19/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Prawn Cocktails" value="0" min="0" data-price="19" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Spanish Tortilla" data-price="19">
                    <div class="item-card-content">
                        <img src="images/prawn_cocktails.jpg" alt="Prawn Cocktails" onerror="this.src='https://via.placeholder.com/80?text=Appetizer+4'">
                        <div>
                            <h4>Spanish Tortilla</h4>
                            <p>Traditional Spanish tortilla with potatoes, onions, and eggs roasted with piquillo ppepers. ($19/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Prawn Cocktails" value="0" min="0" data-price="19" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Proscuitto-Wrapped Melon" data-price="19">
                    <div class="item-card-content">
                        <img src="images/prawn_cocktails.jpg" alt="Prawn Cocktails" onerror="this.src='https://via.placeholder.com/80?text=Appetizer+4'">
                        <div>
                            <h4>Proscuitto-Wrapped Melon</h4>
                            <p>Classic Italian appetizer combines slices of sweet melon wrapped in thin, salty prosciutto. ($19/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Prawn Cocktails" value="0" min="0" data-price="19" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
            </div>

            <div id="main-course" class="item-list">
                <div class="item-card" data-name="Grilled Salmon" data-price="32">
                    <div class="item-card-content">
                        <img src="images/grilled_salmon.jpg" alt="Grilled Salmon" onerror="this.src='https://via.placeholder.com/80?text=Main+1'">
                        <div>
                            <h4>Grilled Salmon</h4>
                            <p>Atlantic salmon with lemon herb butter ($32/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Grilled Salmon" value="0" min="0" data-price="32" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Beef Tenderloin" data-price="45">
                    <div class="item-card-content">
                        <img src="images/beef_tenderloin.jpg" alt="Beef Tenderloin" onerror="this.src='https://via.placeholder.com/80?text=Main+2'">
                        <div>
                            <h4>Beef Tenderloin</h4>
                            <p>Prime cut with red wine reduction ($45/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Beef Tenderloin" value="0" min="0" data-price="45" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Grilled Salmon" data-price="32">
                    <div class="item-card-content">
                        <img src="images/grilled_salmon.jpg" alt="Spaghetti" onerror="this.src='https://via.placeholder.com/80?text=Main+1'">
                        <div>
                            <h4>Spaghetti</h4>
                            <p>Cylindrical Pasta with tomato-based sauce, ground beef, onion, garlic, basil and parmesan cheese ($32/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Grilled Salmon" value="0" min="0" data-price="32" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Shrimp Calbonara Pasta" data-price="32">
                    <div class="item-card-content">
                        <img src="images/grilled_salmon.jpg" alt="Grilled Salmon" onerror="this.src='https://via.placeholder.com/80?text=Main+1'">
                        <div>
                            <h4>Shrimp Calbonara Pasta</h4>
                            <p>Creamy pasta made with shrimp, bacon, eggs, cheese, and black pepper. ($32/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Grilled Salmon" value="0" min="0" data-price="32" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Honey Glazed Salmon with Rice" data-price="32">
                    <div class="item-card-content">
                        <img src="images/grilled_salmon.jpg" alt="Grilled Salmon" onerror="this.src='https://via.placeholder.com/80?text=Main+1'">
                        <div>
                            <h4>Honey Glazed Salmon with Rice</h4>
                            <p>Sweet-savory dish with tender salmon coated in honey glaze, served over steamed rice with vegetables. ($32/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Grilled Salmon" value="0" min="0" data-price="32" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
              </div>
            <div id="beverages" class="item-list">
                 <div class="item-card" data-name="Premium Bar Package" data-price="35">
                    <div class="item-card-content">
                        <img src="images/premium_bar.jpg" alt="Premium Bar" onerror="this.src='https://via.placeholder.com/80?text=Beverage+1'">
                        <div>
                            <h4>Premium Bar Package</h4>
                            <p>Top-shelf liquors and craft cocktails ($35/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Premium Bar Package" value="0" min="0" data-price="35" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Wine Selection" data-price="30">
                    <div class="item-card-content">
                        <img src="images/wine_selection.jpg" alt="Wine Selection" onerror="this.src='https://via.placeholder.com/80?text=Beverage+2'">
                        <div>
                            <h4>Wine Selection</h4>
                            <p>Curated wine pairings ($30/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Wine Selection" value="0" min="0" data-price="30" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Wine Selection" data-price="30">
                    <div class="item-card-content">
                        <img src="images/wine_selection.jpg" alt="Wine Selection" onerror="this.src='https://via.placeholder.com/80?text=Beverage+2'">
                        <div>
                            <h4>Royal Select</h4>
                            <p>A festive-free juice with a lively sparkle. ($30/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Wine Selection" value="0" min="0" data-price="30" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Jack Daniels" data-price="30">
                    <div class="item-card-content">
                        <img src="images/wine_selection.jpg" alt="Wine Selection" onerror="this.src='https://via.placeholder.com/80?text=Beverage+2'">
                        <div>
                            <h4>Jack Daniels</h4>
                            <p>Hand Selected Tennessee whiskey made from corn, rye, and malted barley, along with water from a spring. ($30/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Wine Selection" value="0" min="0" data-price="30" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Chivas Regal" data-price="30">
                    <div class="item-card-content">
                        <img src="images/wine_selection.jpg" alt="Wine Selection" onerror="this.src='https://via.placeholder.com/80?text=Beverage+2'">
                        <div>
                            <h4>Chivas Regal</h4>
                            <p>A blended scotch whisky produced by the chivas brothers subsidiary of pernod ricard ($30/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Wine Selection" value="0" min="0" data-price="30" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
            </div>
            <div id="desserts" class="item-list">
                <div class="item-card" data-name="Cheese Cake" data-price="5">
                    <div class="item-card-content">
                        <img src="images/cheese_cake.jpg" alt="Cheese Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+1'">
                        <div>
                            <h4>Cheese Cake</h4>
                            <p>Smooth, creamy, cheesy with fresh fruit toppings ($5/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Cheese Cake" value="0" min="0" data-price="5" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Tiramisu" data-price="12">
                    <div class="item-card-content">
                        <img src="images/tiramisu.jpg" alt="Tiramisu" onerror="this.src='https://via.placeholder.com/80?text=Dessert+2'">
                        <div>
                            <h4>Tiramisu</h4>
                            <p>Classic italian layered desert ($12/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Tiramisu" value="0" min="0" data-price="12" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Macaroons" data-price="20">
                    <div class="item-card-content">
                        <img src="images/macaroons.jpg" alt="Macaroons" onerror="this.src='https://via.placeholder.com/80?text=Dessert+3'">
                        <div>
                            <h4>Macaroons</h4>
                            <p>French meringue-based sandwich cookies ($20/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Macaroons" value="0" min="0" data-price="20" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Cup Cake" data-price="9">
                    <div class="item-card-content">
                        <img src="images/cup_cake.jpg" alt="Cup Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+4'">
                        <div>
                            <h4>Cup Cake</h4>
                            <p>Sweet Backed with frosting on top ($9/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Cup Cake" value="0" min="0" data-price="9" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Charcuteri" data-price="9">
                    <div class="item-card-content">
                        <img src="images/cup_cake.jpg" alt="Cup Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+4'">
                        <div>
                            <h4>Charcuteri</h4>
                            <p>Board of sweet treats with chocolate salami ($9/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Cup Cake" value="0" min="0" data-price="9" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Buckeye Bundt Cake" data-price="9">
                    <div class="item-card-content">
                        <img src="images/cup_cake.jpg" alt="Cup Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+4'">
                        <div>
                            <h4>Buckeye Bundt Cake</h4>
                            <p>A creamy peanut butter cheesecake with chocolate cake, and topping of melted semisweet chocolate ($9/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Cup Cake" value="0" min="0" data-price="9" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Cake Pops" data-price="9">
                    <div class="item-card-content">
                        <img src="images/cup_cake.jpg" alt="Cup Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+4'">
                        <div>
                            <h4>Cake Pops</h4>
                            <p>bite-sized balls cake mixed with frosting, coated in icing, and served on sticks with colorful decorations ($9/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Cup Cake" value="0" min="0" data-price="9" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Strawberry Pretzel Salad" data-price="9">
                    <div class="item-card-content">
                        <img src="images/cup_cake.jpg" alt="Cup Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+4'">
                        <div>
                            <h4>Strawberry Pretzel Salad</h4>
                            <p>Layered dessert made with a crunchy pretzel crust, creamy sweet filling, and strawberry gelatin topped with fresh strawberries. ($9/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Cup Cake" value="0" min="0" data-price="9" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Carrot Cake" data-price="9">
                    <div class="item-card-content">
                        <img src="images/cup_cake.jpg" alt="Cup Cake" onerror="this.src='https://via.placeholder.com/80?text=Dessert+4'">
                        <div>
                            <h4>Carrot Cake</h4>
                            <p>Moist spiced cake made with grated carrots, often layered with cream cheese frosting ($9/guest)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="menu-decrement">-</button>
                        <input type="number" name="menu_qty_Cup Cake" value="0" min="0" data-price="9" class="menu-qty-input">
                        <button type="button" class="menu-increment">+</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="menu_selection" id="menu_selection_input">

            <button type="button" class="confirm-phase-btn" data-phase-target="decor-section">Confirm Menu & Proceed</button>
        </div>

        <div class="content-section" id="decor-section">
            <h2>Decorations</h2>
            <p>Transform your venue with beautiful  decorations.</p>
            <div class="item-list active">
                 <div class="item-card" data-name="Floral Centerpieces" data-price="300">
                    <div class="item-card-content">
                        <img src="images/centerpieces.jpg" alt="Centerpieces" onerror="this.src='https://via.placeholder.com/80?text=Decor+1'">
                        <div>
                            <h4>Floral Centerpieces (per table)</h4>
                            <p>Seasonal flowers with custom arrangements ($300 each)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="decor-decrement">-</button>
                        <input type="number" name="decor_qty_Floral Centerpieces" value="0" min="0" data-price="300" class="decor-qty-input">
                        <button type="button" class="decor-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Festival/Party Lights" data-price="250">
                    <div class="item-card-content">
                        <img src="images/party_lights.jpg" alt="Party Lights" onerror="this.src='https://via.placeholder.com/80?text=Decor+2'">
                        <div>
                            <h4>Festival/Party Lights</h4>
                            <p>String lights, uplighting, and stage effects ($250)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="decor-decrement">-</button>
                        <input type="number" name="decor_qty_Festival/Party Lights" value="0" min="0" data-price="250" class="decor-qty-input">
                        <button type="button" class="decor-increment">+</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="decor_selection" id="decor_selection_input">

            <button type="button" class="confirm-phase-btn" data-phase-target="sound-section">Confirm Decorations & Proceed</button>
        </div>

        <div class="content-section" id="sound-section">
            <h2>Sound System & MCs</h2>
            <p>Choose your audio and entertainment services.</p>
            <div class="tab-menu" id="sound-tabs">
                <div class="tab-item active" data-tab-target="sound-packages">Sound Packages</div>
                <div class="tab-item" data-tab-target="mc-options">MC Options</div>
            </div>
            <div id="sound-packages" class="item-list active">
                <div class="item-card" data-name="Basic Sound System" data-price="800">
                    <div class="item-card-content">
                        <i class="fas fa-speaker" style="font-size: 30px; margin-right: 15px; color: var(--primary-color);"></i>
                        <div>
                            <h4>Basic Sound System</h4>
                            <p>Speakers for speeches and background music ($800)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="sound-decrement">-</button>
                        <input type="number" name="sound_qty_Basic Sound System" value="0" min="0" data-price="800" class="sound-qty-input">
                        <button type="button" class="sound-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Professional DJ Package" data-price="1500">
                    <div class="item-card-content">
                        <i class="fas fa-compact-disc" style="font-size: 30px; margin-right: 15px; color: var(--primary-color);"></i>
                        <div>
                            <h4>Professional DJ Package</h4>
                            <p>Full sound setup, DJ, and customizable playlist ($1,500)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="sound-decrement">-</button>
                        <input type="number" name="sound_qty_Professional DJ Package" value="0" min="0" data-price="1500" class="sound-qty-input">
                        <button type="button" class="sound-increment">+</button>
                    </div>
                </div>
            </div>
            <div id="mc-options" class="item-list">
                <div class="item-card" data-name="Basic MC" data-price="300">
                    <div class="item-card-content">
                        <i class="fas fa-microphone-alt" style="font-size: 30px; margin-right: 15px; color: var(--primary-color);"></i>
                        <div>
                            <h4>Basic MC</h4>
                            <p>Professional host for announcements ($300)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="sound-decrement">-</button>
                        <input type="number" name="sound_qty_Basic MC" value="0" min="0" data-price="300" class="sound-qty-input">
                        <button type="button" class="sound-increment">+</button>
                    </div>
                </div>
                <div class="item-card" data-name="Entertaining MC" data-price="500">
                    <div class="item-card-content">
                        <i class="fas fa-theater-masks" style="font-size: 30px; margin-right: 15px; color: var(--primary-color);"></i>
                        <div>
                            <h4>Entertaining MC</h4>
                            <p>Host who engages guests with games and humor ($500)</p>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button type="button" class="sound-decrement">-</button>
                        <input type="number" name="sound_qty_Entertaining MC" value="0" min="0" data-price="500" class="sound-qty-input">
                        <button type="button" class="sound-increment">+</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="sound_selection" id="sound_selection_input">

            <button type="button" class="confirm-phase-btn" data-phase-target="summary-section">Confirm Sound & Proceed to Summary</button>
        </div>

        <div class="content-section" id="summary-section">
            <h2>Receipt & Payment</h2>
            <p>Review your final selections and estimated cost before confirming your booking.</p>
            <div class="summary-card" id="final-summary-card">
                <div id="final-summary-list"></div>
                <div class="summary-item total-summary">
                    <span>GRAND TOTAL ESTIMATED COST</span>
                    <span id="total-cost-display">$0.00</span>
                </div>
            </div>

            <input type="hidden" name="menu_items" id="final_menu_items">
            <input type="hidden" name="decor_items" id="final_decor_items">
            <input type="hidden" name="sound_items" id="final_sound_items">
            <input type="hidden" name="total_cost" id="final_total_cost">
            <input type="hidden" name="attendee_categories" id="final_attendee_categories">
            
            <button type="submit" class="confirm-btn">Confirm Booking</button>
        </div>
    </form>
</main>

<div id="eventDetailsModal" class="modal">
    <div class="modal-content">
        <h3 id="modal-title">Enter Event Details: Wedding</h3>
        <form id="modal-details-form">
            <div id="modal-form-fields">
                </div>
            
            <div class="modal-footer">
                <button type="button" class="close-modal">Cancel</button>
                <button type="submit" class="confirm-details">Confirm Details</button>
            </div>
        </form>
    </div>
</div>

<footer class="site-footer">
        &copy; 2025 Event Reservation for Event Organizer. All rights reserved.
    </footer>

<script>
const bookedDates = <?php echo $booked_dates_json; ?>;
</script>
<script src="assets/JavaScript/event_reservation.js"></script>


</body>
</html>