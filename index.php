<?php
session_start();
include("connect/connect.php");

// Check form method
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Check for submit method
    if (isset($_POST['submit'])) {

        // Get form information
        $user = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $pass = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        // SQL to query the database
        $querylogin = "SELECT * FROM access WHERE username='$user'";
        $resultlogin = mysqli_query($conn, $querylogin);

        // If the user is found in the database
        if (mysqli_num_rows($resultlogin) == 1) {
            $row = mysqli_fetch_assoc($resultlogin);

            // Check if the entered password matches the hashed password in the database
            if (password_verify($pass, $row['password'])) {
                // Start a session for the user
                $_SESSION['user_id'] = $row['user_id']; // assuming the column user_id exists
                $_SESSION['username'] = $user;

                // Redirect to dashboard after successful login
                header("Refresh: 2; url=dashboard.php");
                exit;
            } else {
                // Set the error message if password is incorrect
                $errormessage = "Invalid Username or Password";
            }
        } else {
            // Set the error message if username doesn't exist
            $errormessage = "Invalid Username or Password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <form method="post" id="form-data" action="index.php">
        <h2 class="form-title">Admin</h2>
        <input type="text" name="username" placeholder="Username" required autocomplete="on" class="data">
        <input type="password" name="password" placeholder="Password" required autocomplete="off" class="data">

        <!-- Display the error message only if login fails -->
        <?php if (isset($errormessage)) : ?>
            <p style="color: red; font-size: 14px;"><?= htmlspecialchars($errormessage) ?></p>
        <?php endif; ?>

        <input type="submit" value="Login" name="submit">
    </form>
</body>

</html>
