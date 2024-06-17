<?php
// PHP code goes here if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/admin_dashboard.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <title>Dashboard</title>

    <style>
        /* Add this style to position the back button */
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
    <div class="relative h-screen bg-cover bg-center" style="background-image: url('img/library.avif');">
        <div class="absolute inset-0 flex justify-center items-center space-x-4">
            <!-- Added the white back button at the upper right corner -->
            <a href="admin_front.php" class="back-button">Back</a>
            <a href="admin_registered.php" class="button">
                REGISTERED USER
            </a>
            <a href="borrowhistory.php" class="button">
                BORROW HISTORY
            </a>
            <a href="admin_inventory.php" class="button">
                BOOK INVENTORY
            </a>
            <a href="admin_addbooks.php" class="button">
                ADD BOOKS
            </a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
