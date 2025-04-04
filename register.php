<?php
include("connect/connect.php"); // Include your database connection
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get form information
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirm_password = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_SPECIAL_CHARS);

    // Check if passwords match
    if ($password !== $confirm_password) {
        $errormessage = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $query = "INSERT INTO access (username, password) VALUES ('$username', '$hashed_password')";
        
        if (mysqli_query($conn, $query)) {
            $successmessage = "User registered successfully!";
            // Optionally, log in the user and redirect to the login page
            header('Location: index.php'); // Redirect to login page
            exit();
        } else {
            $errormessage = "Error registering user: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <form method="post" action="register.php" id="form-data">
        <h2 class="form-title">Register</h2>
        
        <!-- Input for Username -->
        <input type="text" name="username" placeholder="Username" required class="data">

        <!-- Input for Password -->
        <input type="password" name="password" placeholder="Password" required class="data">

        <!-- Input for Confirm Password -->
        <input type="password" name="confirm_password" placeholder="Confirm Password" required class="data">

        <!-- Display error or success message -->
        <?php if (isset($errormessage)) : ?>
            <p style="color: red; font-size: 14px;"><?= htmlspecialchars($errormessage) ?></p>
        <?php endif; ?>

        <?php if (isset($successmessage)) : ?>
            <p style="color: green; font-size: 14px;"><?= htmlspecialchars($successmessage) ?></p>
        <?php endif; ?>

        <!-- Submit Button -->
        <input type="submit" value="Register" name="submit">

        <!-- Go to Login Button (as a link styled like a button) -->
        <a href="index.php" class="login-button">Go to Login</a>
    </form>
</body>

</html>
