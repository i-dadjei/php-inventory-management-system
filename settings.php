<?php
session_start();
include("connect/connect.php"); // include your database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get form information and sanitize inputs
    $current_password = filter_input(INPUT_POST, "current_password", FILTER_SANITIZE_SPECIAL_CHARS);
    $new_password = filter_input(INPUT_POST, "new_password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm_password = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_SPECIAL_CHARS);

    // Ensure new password and confirm password match
    if ($new_password !== $confirm_password) {
        $errormessage = "New password and confirm password do not match.";
    } else {
        // Use the logged-in user's username
        $username = $_SESSION['username'];

        // Sanitize the user inputs to prevent SQL injection
        $current_password = mysqli_real_escape_string($conn, $current_password);
        $new_password = mysqli_real_escape_string($conn, $new_password);
        $confirm_password = mysqli_real_escape_string($conn, $confirm_password);

        // Query to get the current password from the database using username
        $query = "SELECT password FROM access WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Fetch the stored password
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];

            // Check if the current password matches the stored password
            if (!password_verify($current_password, $stored_password)) {
                $errormessage = "Current password is incorrect.";
            } else {
                // Hash the new password securely
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database using the correct username
                $update_query = "UPDATE access SET password = '$hashed_new_password' WHERE username = '$username'";
                if (mysqli_query($conn, $update_query)) {
                    $successmessage = "Password updated successfully. You will be redirected to the login page.";
                    
                    // Redirect to login page after a short delay
                    header("Refresh: 3; url=index.php"); // This will redirect after 3 seconds
                    exit();
                } else {
                    $errormessage = "Error updating password.";
                }
            }
        } else {
            $errormessage = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/settings.css">
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
        <div class="mode-container">
            <h4>Toggle Dark/Light Mode</h4>
            <button id="toggle-button">
                <i class="fas fa-sun" id="mode-icon"></i>
            </button>
        </div>

        <div class="security">
            <h4>Security</h4>

            <!-- Form for password change -->
            <form action="settings.php" method="post">
                <div>
                    <label for="current_password">Current Password:</label>
                    <input type="password" name="current_password" id="current_password" required>
                </div>
                <div>
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" id="new_password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>
                <button type="submit" name="submit">Change Password</button>
            </form>

            <!-- Display success or error messages -->
            <?php if (isset($errormessage)) : ?>
                <p style="color: red; font-size: 14px;"><?= htmlspecialchars($errormessage) ?></p>
            <?php endif; ?>

            <?php if (isset($successmessage)) : ?>
                <p style="color: green; font-size: 14px;"><?= htmlspecialchars($successmessage) ?></p>
            <?php endif; ?>
        </div>
    </main>

    <script src="js/main-settings.js"></script>
</body>

</html>
