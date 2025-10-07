<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'owner') {
    header("Location: Main.php");
    exit;
}

$host = "localhost";
$user = "root";
$password = "";
$dbname = "event_reservation";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mark reservation as finished
if (isset($_GET['done_id'])) {
    $id = $conn->real_escape_string($_GET['done_id']);
    $conn->query("UPDATE reservations SET status='Finished' WHERE id='$id'");
    header("Location: owner_dashboard.php");
    exit;
}

// Fetch counts for summary cards from the correct table
$total_events_query = $conn->query("SELECT COUNT(*) AS total FROM reservations");
$total_events = $total_events_query->fetch_assoc()['total'];

$upcoming_events_query = $conn->query("SELECT COUNT(*) AS total FROM reservations WHERE status='Pending' OR status='Ongoing'");
$upcoming_events = $upcoming_events_query->fetch_assoc()['total'];

$ongoing_events_query = $conn->query("SELECT COUNT(*) AS total FROM reservations WHERE status='Ongoing'");
$ongoing_events = $ongoing_events_query->fetch_assoc()['total'];

$finished_events_query = $conn->query("SELECT COUNT(*) AS total FROM reservations WHERE status='Finished'");
$finished_events = $finished_events_query->fetch_assoc()['total'];

// Fetch all reservations and join with users table to get the username
$sql = "SELECT r.*, u.username FROM reservations r JOIN users u ON r.user_id = u.id ORDER BY r.event_date ASC";
$reservations = $conn->query($sql);

function categorize($status) {
    if ($status == 'Pending') return 'upcoming';
    elseif ($status == 'Ongoing') return 'ongoing';
    else return 'finished';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservation for Event Organizer</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            padding: 2rem;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .header-left h1 {
            font-size: 2rem;
            color: #5d42e6;
            margin: 0;
            display: inline-block;
            margin-left: 1rem;
        }
        .header-left i {
            font-size: 2rem;
            color: #5d42e6;
        }
        .logout-btn {
            background: #d9534f;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background: #c9302c;
        }
        .container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .summary-cards {
            display: flex;
            justify-content: space-between;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        .card-icon {
            font-size: 2rem;
            color: #5d42e6;
            margin-right: 1.5rem;
        }
        .card h3 {
            font-size: 2.5rem;
            margin: 0;
            color: #333;
        }
        .card span {
            font-size: 0.9rem;
            color: #666;
            text-transform: uppercase;
        }
        .tabs {
            margin-bottom: 1.5rem;
        }
        .tabs button {
            background-color: #eee;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 5px;
            margin-right: 10px;
        }
        .tabs button.active {
            background-color: #5d42e6;
            color: #fff;
        }
        .event-table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }
        thead {
            background-color: #f8f9fa;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        .status-finished { color: green; }
        .status-pending { color: orange; }
        .status-ongoing { color: blue; }
        .mark-btn {
            background: #5d42e6;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .mark-btn:hover {
            background: #4a34b8;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="header-left">
        <i class="fas fa-tachometer-alt"></i>
        <h1>Dashboard</h1>
    </div>
    <div class="header-right">
        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container">
    <div class="summary-cards">
        <div class="card total">
            <i class="fas fa-chart-line card-icon"></i>
            <div class="card-content">
                <span>Total Events</span>
                <h3><?php echo $total_events; ?></h3>
            </div>
        </div>
        <div class="card upcoming">
            <i class="fas fa-hourglass-start card-icon"></i>
            <div class="card-content">
                <span>Upcoming Events</span>
                <h3><?php echo $upcoming_events; ?></h3>
            </div>
        </div>
        <div class="card ongoing">
            <i class="fas fa-sync-alt card-icon"></i>
            <div class="card-content">
                <span>Ongoing Events</span>
                <h3><?php echo $ongoing_events; ?></h3>
            </div>
        </div>
        <div class="card finished">
            <i class="fas fa-check-circle card-icon"></i>
            <div class="card-content">
                <span>Finished Events</span>
                <h3><?php echo $finished_events; ?></h3>
            </div>
        </div>
    </div>

    <div class="tabs">
        <button id="upcomingBtn" class="active" onclick="showTab('upcoming')">Upcoming</button>
        <button id="ongoingBtn" onclick="showTab('ongoing')">Ongoing</button>
        <button id="finishedBtn" onclick="showTab('finished')">Finished</button>
    </div>

    <div class="event-table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Event</th>
                    <th>Venue</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $reservations->fetch_assoc()): 
                    $status_class = 'status-' . strtolower(str_replace(' ', '', $row['status']));
                    $tab = categorize($row['status']);
                ?>
                <tr data-status="<?php echo $tab; ?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['event_date']; ?></td>
                    <td><?php echo $row['event_time']; ?></td>
                    <td><?php echo $row['event_type']; ?></td>
                    <td><?php echo $row['event_address']; ?></td>
                    <td class="<?php echo $status_class; ?>"><?php echo $row['status']; ?></td>
                    <td>
                        <?php if($row['status'] != 'Finished'){ ?>
                            <a href="owner_dashboard.php?done_id=<?php echo $row['id']; ?>"><button class="mark-btn">Mark Done</button></a>
                        <?php } else { echo "-"; } ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function showTab(tab) {
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        if(row.dataset.status === tab) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
    
    document.querySelectorAll('.tabs button').forEach(btn => btn.classList.remove('active'));
    document.getElementById(tab + 'Btn').classList.add('active');
}

window.onload = function() {
    showTab('upcoming');
};
</script>

</body>
</html>