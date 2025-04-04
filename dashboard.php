<?php
include("connect/connect.php");
include("actions/activity.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/database.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo"></div>
        <h2>Admin Portal</h2>
        <ul>
            <li><a href="dashboard.php"><span class="material-symbols-outlined">dashboard</span>Dashboard</a></li>
            <li><a href="inventory.php"><span class="material-symbols-outlined">inventory_2</span>Inventory</a></li>
            <li><a href="reports.php"><span class="material-symbols-outlined">inventory</span>Reports</a></li>
            <li><a href="settings.php"><span class="material-symbols-outlined">settings</span>Settings</a></li>
            <li><a href="index.php"><span class="material-symbols-outlined">logout</span>Log out</a></li>
        </ul>
    </div>
    <main class="main-content">
        <div class="main-container">
            <div class="label">
                <h4>Inventory Management System</h4>
            </div>
            <div class="card-container">
                <div class="card">
                    <img src="assets/book.png" alt="png" class="png">
                    <h4>Total Books </h4>
                    <p><?php echo $totalBooks; ?></p>
                </div>
                <div class="card">
                    <img src="assets/writer.png" alt="png" class="png">
                    <h4>Authors</h4>
                    <p><?php echo $totalAuthors; ?></p>
                </div>
                <div class="card">
                    <img src="assets/publishing.png" alt="png" class="png">
                    <h4>Publishers</h4>
                    <p><?php echo $totalPublishers; ?></p>
                </div>
                <div class="card">
                    <img src="assets/genre.png" alt="png" class="png">
                    <h4>Genres</h4>
                    <p><?php echo $totalGenres; ?></p>
                </div>
            </div>
        </div>
    </main>
</body>

</html>