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

// Handle item deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_item'])) {
    $item_id = $_POST['delete_item'];
    $delete_sql = "DELETE FROM books WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $item_id);
    if ($delete_stmt->execute()) {
        // Deletion successful
        echo "success";
        exit;
    } else {
        // Deletion failed
        echo "error";
        exit;
    }
}

// Fetch data from the database
$sql = "SELECT id, title, author, isbn, quantity, category FROM books";
$result = $conn->query($sql);

$books = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/admin_inventory.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <title>Inventory</title>

    <style>
        /* Style for the back button */
        .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: white;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <a href="admin_front.php" class="back-button">Back</a>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('img/library.avif');">
        <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg w-full max-w-4xl">
            <h1 class="text-2xl font-bold mb-6 text-center">Book Inventory</h1>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse mx-auto">
                    <thead>
                        <tr>
                            <th class="border p-3 text-left bg-gray-200">Book Title</th>
                            <th class="border p-3 text-left bg-gray-200">Author</th>
                            <th class="border p-3 text-left bg-gray-200">ISBN</th>
                            <th class="border p-3 text-left bg-gray-200">Quantity</th>
                            <th class="border p-3 text-left bg-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td class="border p-3"><?= $book['title'] ?></td>
                                <td class="border p-3"><?= $book['author'] ?></td>
                                <td class="border p-3"><?= $book['isbn'] ?></td>
                                <td class="border p-3"><?= $book['quantity'] ?></td>
                                <td class="border p-3">
                                    <button onclick="editBook(<?= $book['id'] ?>)">Edit</button>
                                    <button onclick="deleteBook(<?= $book['id'] ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function editBook(id) {
            // Redirect to the edit book page with the id as a parameter
            window.location.href = 'editbook.php?id=' + id;
        }

        function deleteBook(id) {
            if (confirm(`Are you sure you want to delete this book?`)) {
                // Send an AJAX request to delete the book
                fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'delete_item=' + id, // Send book ID as POST data
                })
                .then(response => response.text())
                .then(data => {
                    // Check if deletion was successful
                    if (data === 'success') {
                        // Reload the page after successful deletion
                        location.reload();
                    } else {
                        // Handle deletion error
                        console.error('Error deleting book');
                    }
                })
                .catch(error => console.error('Error deleting book:', error));
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
