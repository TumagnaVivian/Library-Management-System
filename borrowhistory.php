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

// Handle the return button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['return'])) {
    // Get the current date
    $date_returned = date("Y-m-d");
    // Get the book ID from the POST request
    $book_id = $_POST['book_id'];
    // Update the 'date_returned' column in the database
    $update_sql = "UPDATE borrows SET date_returned = ? WHERE book_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $date_returned, $book_id);
    if ($stmt->execute()) {
        // Redirect to the same page to reflect the changes
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Handle the delete button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    // Get the book ID from the POST request
    $book_id = $_POST['book_id'];
    // Delete the corresponding entry from the database
    $delete_sql = "DELETE FROM borrows WHERE book_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $book_id);
    if ($stmt->execute()) {
        // Redirect to the same page to reflect the changes
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch data from the database
$sql = "SELECT books.title, books.author, borrows.book_id, borrows.user_id, borrows.date_borrowed, borrows.date_returned, users.first_name, users.last_name
        FROM borrows
        INNER JOIN books ON borrows.book_id = books.id
        INNER JOIN users ON borrows.user_id = users.user_id"; // Joining with the 'users' table
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/borrowhistory.css">

    <title>Borrow History</title>

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
<body style="background-image: url('img/library.avif'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
    <a href="admin_front.php" class="back-button">Back</a>
    <div class="borrow-history">
        <h2 class="borrow-history-title">Borrow History</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>Book Title</th>
                    <th>Author</th>
                    <th>Student ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Date Borrowed</th>
                    <th>Date Returned</th>
                    <th>Actions</th>
                </tr>
                <?php
                // Populate the HTML table with data from the database
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row["title"]."</td>";
                        echo "<td>".$row["author"]."</td>";
                        echo "<td>".$row["user_id"]."</td>";
                        echo "<td>".$row["first_name"]."</td>";
                        echo "<td>".$row["last_name"]."</td>";
                        echo "<td>".$row["date_borrowed"]."</td>";
                        echo "<td>".$row["date_returned"]."</td>";
                        // Add a form with hidden input fields for book_id and submit buttons for returning and deleting the entry
                        echo "<td>";
                        echo "<form method='POST'>";
                        echo "<input type='hidden' name='book_id' value='".$row["book_id"]."'>";
                        echo "<button type='submit' name='return'>Returned</button>";
                        echo "</form>";
                        echo "<form method='POST'>";
                        echo "<input type='hidden' name='book_id' value='".$row["book_id"]."'>";
                        echo "<button type='submit' name='delete'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found</td></tr>"; // Fixed colspan to match number of columns
                }
                ?>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
