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

$error_message = ""; // Initialize error message variable

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

    // Update book information in the database
    $update_sql = "UPDATE books SET title=?, author=?, isbn=?, quantity=?, category=? WHERE id=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssi", $title, $author, $isbn, $quantity, $category, $book_id);
    
    if ($update_stmt->execute()) {
        // Update successful
        header("Location: admin_inventory.php"); // Redirect to inventory page
        exit;
    } else {
        // Update failed
        $error_message = "Error updating book information: " . $conn->error;
    }
} else {
    // Retrieve book information based on book_id
    if (isset($_GET['id'])) {
        $book_id = $_GET['id'];
        $sql = "SELECT * FROM books WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $title = $row['title'];
            $author = $row['author'];
            $isbn = $row['isbn'];
            $quantity = $row['quantity'];
            $category = $row['category'];
        } else {
            // Book not found
            $error_message = "Book not found";
        }
    } else {
        // Book ID not provided
        $error_message = "Book ID not provided";
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
    <title>Edit Book</title>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('img/library.avif');">
        <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg w-full max-w-4xl">
            <h1 class="text-2xl font-bold mb-6 text-center">Edit Book</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="hidden" name="book_id" value="<?= $book_id ?>">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                    <input type="text" id="title" name="title" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?= $title ?>" required>
                </div>
                <div class="mb-4">
                    <label for="author" class="block text-gray-700 font-bold mb-2">Author</label>
                    <input type="text" id="author" name="author" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?= $author ?>" required>
                </div>
                <div class="mb-4">
                    <label for="isbn" class="block text-gray-700 font-bold mb-2">ISBN</label>
                    <input type="text" id="isbn" name="isbn" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?= $isbn ?>" required>
                </div>
                <div class="mb-4">
                    <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?= $quantity ?>" required>
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                    <input type="text" id="category" name="category" class="border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?= $category ?>" required>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
                </div>
                <?php if(isset($error_message)): ?>
                <p class="text-red-500"><?= $error_message ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
