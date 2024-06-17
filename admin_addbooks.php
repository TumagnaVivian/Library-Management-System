<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CANOY";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define a variable to store any messages for the user
$message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $title = htmlspecialchars($_POST['title']);
    $author = htmlspecialchars($_POST['author']);
    $isbn = htmlspecialchars($_POST['isbn']);
    $quantity = htmlspecialchars($_POST['quantity']);
    $category_id = htmlspecialchars($_POST['category']);

    // Prepare and bind the SQL statement
    $sql = "INSERT INTO books (title, author, isbn, quantity, category_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $author, $isbn, $quantity, $category_id);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        $message = "Book added successfully!";
        // If book added successfully, set JavaScript variable to show pop-up
        echo '<script> var bookAdded = true;</script>';
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Fetch categories from the library table
$categories = [];
$sql = "SELECT category_id, category_name FROM library";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/admin_add_books.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  
    <title>Add Books</title>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('img/library.avif');">
        <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg w-full max-w-md relative">
            <form id="addBookForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <!-- Back button -->
                <div class="text-right mb-4">
                    <a href="admin_front.php" class="btn btn-outline-secondary">Back</a>
                </div>

                <!-- Form fields -->
                <div class="mb-4">
                    <input type="text" name="title" placeholder="Book Title" class="w-full p-3 rounded-lg border border-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <input type="text" name="author" placeholder="Author" class="w-full p-3 rounded-lg border border-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <input type="text" name="isbn" placeholder="ISBN" class="w-full p-3 rounded-lg border border-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <input type="number" name="quantity" placeholder="Quantity" class="w-full p-3 rounded-lg border border-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="category">Select Category:</label>
                    <select id="category" name="category" class="w-full p-3 rounded-lg border border-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-indigo-500 text-white py-3 px-6 rounded-lg shadow-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">ADD BOOKS</button>
                </div>
            </form>
            <!-- Pop-up message -->
            <div id="successPopup" class="popup" style="<?php echo (isset($message) && strpos($message, 'successfully') !== false) ? 'display: block;' : 'display: none;'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Check if the book was added successfully and show pop-up
        if (typeof bookAdded !== 'undefined' && bookAdded) {
            $(document).ready(function() {
                $("#successPopup").fadeIn().delay(2000).fadeOut();
            });
        }
    </script>
</body>
</html>
