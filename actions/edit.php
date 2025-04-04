<?php
include('../connect/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Sanitize and validate the id from the URL
$id = isset($_GET['editid']) ? (int)$_GET['editid'] : 0;

// Fetch the old details
$sql = "SELECT * FROM inventory WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));  // Check if there's an issue with the query
}

$row = mysqli_fetch_assoc($result);
$title = $row['title'];
$author = $row['author'];
$publisher = $row['publisher'];
$genre = $row['genre'];

// Handle form submission for updating
if (isset($_POST['submit'])) {
    // Get and sanitize form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $publisher = mysqli_real_escape_string($conn, $_POST['publisher']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);

    // SQL query to update the database
    $sql = "UPDATE inventory SET title='$title', author='$author', publisher='$publisher', genre='$genre' WHERE id=$id";

    // Execute the update query
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: ../inventory.php");
        exit();  // Make sure no further code is executed
    } else {
        die("Error updating data: " . mysqli_error($conn));  // Display error message if query fails
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <link rel="stylesheet" href="../css/add-update.css">
    <link rel="stylesheet" href="../css/header.css">
</head>

<body>
    <div class="form-container">
        <form method="post">
            <h2>Update Details</h2>
            <div class="input-data">
                <label for="title">Title: </label>
                <input type="text" name="title" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($title); ?>">
            </div>
            <div class="input-data">
                <label for="author">Author: </label>
                <input type="text" name="author" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($author); ?>">
            </div>
            <div class="input-data">
                <label for="publisher">Publisher: </label>
                <input type="text" name="publisher" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($publisher); ?>">
            </div>
            <div class="input-data">
                <label for="genre">Genre: </label>
                <input type="text" name="genre" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($genre); ?>">
            </div>
            <div class="input-submit">
                <button class="submit" name="submit">Update</button>
            </div>
        </form>
    </div>
</body>

</html>