<?php
include("connect/connect.php"); // include your database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get form information
    $current_password = filter_input(INPUT_POST, "current_password", FILTER_SANITIZE_SPECIAL_CHARS);
    $new_password = filter_input(INPUT_POST, "new_password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm_password = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_SPECIAL_CHARS);

    // Ensure new password and confirm password match
    if ($new_password !== $confirm_password) {
        $errormessage = "New password and confirm password do not match.";
    } else {
        $user_id = $_SESSION['user_id'];

        // Query to get the current password from the database
        $query = "SELECT password FROM access WHERE user_id = '$user_id'";
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

                // Update the password in the database
                $update_query = "UPDATE access SET password = '$hashed_new_password' WHERE user_id = '$user_id'";
                if (mysqli_query($conn, $update_query)) {
                    $successmessage = "Password updated successfully.";
                    header("Location: index.php");
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
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="post" id="form-data" action="change_password.php">
        <h2 class="form-title">Change Password</h2>

        <input type="password" name="current_password" placeholder="Current Password" required class="data">
        <input type="password" name="new_password" placeholder="New Password" required class="data">
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required class="data">

        <!-- Display error or success message -->
        <?php if (isset($errormessage)) : ?>
            <p style="color: red; font-size: 14px;"><?= htmlspecialchars($errormessage) ?></p>
        <?php endif; ?>

        <?php if (isset($successmessage)) : ?>
            <p style="color: green; font-size: 14px;"><?= htmlspecialchars($successmessage) ?></p>
        <?php endif; ?>

        <input type="submit" value="Change Password" name="submit">
    </form>
</body>

</html>
