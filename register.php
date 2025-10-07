<?php
session_start();
$host="localhost"; $user="root"; $password=""; $dbname="event_reservation";
$conn = new mysqli($host, $user, $password, $dbname);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if($password !== $confirm){
        echo "<script>alert('Passwords do not match'); window.history.back();</script>";
        exit;
    }

    $check = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($check);
    if($result->num_rows > 0){
        echo "<script>alert('Username already exists'); window.history.back();</script>";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username,password,role) VALUES ('$username','$hash','user')";
        if($conn->query($sql)===TRUE){
            echo "<script>alert('Registration successful'); window.location='Main.php';</script>";
        } else {
            echo "Error: ".$conn->error;
        }
    }
}
?>
