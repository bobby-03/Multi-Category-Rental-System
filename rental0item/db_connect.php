<?php 
// Connection parameters
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'rental_item';

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>