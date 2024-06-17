<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/admin_bookused.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- CSS style for the back button -->
    <style>
        .btn-back {
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

    <title>Book Used</title>
</head>
<body>
    <div class="min-h-screen bg-cover bg-center flex flex-col items-center justify-center p-4" style="background-image: url('img/library.avif');">
        <!-- Back button -->
        <div class="text-right mb-4">
            <a href="admin_inventory.php" class="btn btn-outline-secondary btn-sm btn-back">Back</a>
        </div>
        
        <input type="text" placeholder="Search Books" class="mb-4 p-2 w-64 rounded-lg shadow-md bg-white text-zinc-700" />
        <a href="bio_admin.php" class="mb-2 p-2 w-40 rounded-lg shadow-md bg-white text-zinc-700"><center>BIOLOGY</center></a>
        <a href="ethics_admin.php" class="mb-2 p-2 w-40 rounded-lg shadow-md bg-white text-zinc-700"><center>ETHICS</center></a>
        <a href="history_admin.php" class="mb-2 p-2 w-40 rounded-lg shadow-md bg-white text-zinc-700"><center>HISTORY</center></a>
        <a href="IT_admin.php" class="mb-2 p-2 w-40 rounded-lg shadow-md bg-white text-zinc-700"><center>IT</center></a>
        <a href="lit_admin.php" class="mb-2 p-2 w-40 rounded-lg shadow-md bg-white text-zinc-700"><center>LITERATURE</center></a>

        <?php
        // Database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "CANOY";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to fetch data from the Users table
        $sql = "SELECT * FROM Users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                // Output row data here if needed
            }
        } else {
            echo "0 results";
        }

        // Close connection
        $conn->close();
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
