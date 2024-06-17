<?php
// Connect to the database
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

// Get the selected category from the AJAX request
$category = $_GET['category'] ?? 'all';

// Fetch data from the database based on the selected category
$sql = "SELECT title, author, isbn, quantity, category FROM books";
if ($category !== 'all') {
    $sql .= " WHERE category = '$category'";
}
$result = $conn->query($sql);

$books = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the fetched data as JSON
echo json_encode($books);
?>
