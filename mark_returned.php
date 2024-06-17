<?php
// Connect to your database (replace with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CANOY";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get borrow ID from the AJAX request
$borrowId = $_POST['id'];

// Update the date_returned column in the database
$dateReturned = date("Y-m-d");
$sql = "UPDATE borrows SET date_returned = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $dateReturned, $borrowId);

if ($stmt->execute()) {
    echo "Success"; // Return success response
} else {
    echo "Error"; // Return error response
}

$stmt->close();
$conn->close();
?>
