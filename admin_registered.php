<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/admin_registered.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <title>Registered User</title>

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
    <div class="flex items-center justify-center min-h-screen bg-cover bg-center" style="background-image: url('img/library.avif');">
        <div class="bg-white bg-opacity-80 p-6 rounded-lg shadow-lg">
            <div class="text-center mb-4">
                <span class="bg-white text-black py-2 px-4 rounded-full shadow-md"> <b>REGISTERED USER </b></span>
            </div>
            <table class="min-w-full bg-white bg-opacity-80 rounded-lg shadow-lg">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">STUDENT NAME</th>
                        <th class="py-2 px-4 border-b">STUDENT ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Connect to database
                    $servername = "localhost";
                    $username = "root"; // Replace with your MySQL username
                    $password = ""; // Replace with your MySQL password
                    $dbname = "CANOY"; // Replace with your database name

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch data from users table
                    $sql = "SELECT first_name, last_name, student_id FROM users"; // Adjust table name if necessary
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td class='py-2 px-4 border-b'>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                            echo "<td class='py-2 px-4 border-b'>" . $row["student_id"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
