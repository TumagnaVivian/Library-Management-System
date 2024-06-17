<?php
// delete_book.php

// Assuming you receive data via POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent from the client
    $title = $_POST['title'];

    // Here you would perform the delete operation in your database
    // For example:
    // DELETE FROM books WHERE title='$title';
    
    // After deleting, you can return a success message if needed
    echo json_encode(array("success" => true, "message" => "Book deleted successfully"));
} else {
    // Handle invalid requests
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("success" => false, "message" => "Method not allowed"));
}
?>
