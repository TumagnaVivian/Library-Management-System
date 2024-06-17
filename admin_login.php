<?php
// Variable to store the message
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
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

    // Process form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform database query to check username and password
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Set the message
        $message = "Login successful";

        // Redirect to the other index
        header("Location: admin_front.php");
        exit(); // Ensure that script execution stops after redirection
    } else {
        $message = "Invalid username or password";
    }

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/admin_login.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <title>Admin Login</title>
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
    <div class="min-h-screen flex flex-col items-center justify-center bg-cover bg-center" style="background-image: url('img/library.avif');">
        <h1 class="text-white text-3xl font-semibold mb-8">LOG IN</h1>
        <div class="bg-black bg-opacity-50 p-8 rounded-lg shadow-lg max-w-md w-full">
            <!-- Start of the login form -->
            <form class="space-y-4" method="POST">
                <!-- Username input field -->
                <input type="text" name="username" placeholder="Username" class="w-full p-3 rounded-lg border border-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" require/>
                <!-- Password input field -->
                <input type="password" name="password" placeholder="Password" class="w-full p-3 rounded-lg border border-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" require/>
                <!-- Login button -->
                <button type="submit" class="w-full bg-red-600 text-white p-3 rounded-lg block text-center hover:bg-red-700">LOG IN</button>
            </form>
            <!-- Display the login message -->
            <p style="color: white;"><?php echo $message; ?></p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
