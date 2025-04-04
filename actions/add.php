<?php
include("../connect/connect.php");

if (isset($_POST['submit'])) {
    // Get the form data
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $genre = $_POST['genre'];

    // Check if the form data is empty
    if (!empty($title) && !empty($author) && !empty($publisher) && !empty($genre)) {
        // Prepare SQL query
        $sql = "INSERT INTO inventory (title, author, publisher, genre) 
                VALUES ('$title', '$author', '$publisher', '$genre')";

        // Execute the query
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect to display.php after successful insertion
            header("Location: ../inventory.php");
            exit(); // Always call exit after a header redirect
        } else {
            // Output any SQL errors
            die("Error inserting data: " . $conn->error);
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add-Book</title>
    <link rel="stylesheet" href="../css/add-update.css">
    <link rel="stylesheet" href="../css/header.css">
</head>

<body>
    <div class="form-container">
        <form method="post">
            <h2>add new book details</h2>
            <div class="input-data">
                <label for="title">Title: </label>
                <input type="text" name="title" placeholder="Enter the Book Title" autocomplete="off" pattern="^[A-Za-z\s]+$" title="Only letters are allowed" required>
            </div>
            <div class="input-data">
                <label for="author">Author: </label>
                <input type="text" name="author" placeholder="Enter the Author's Name" autocomplete="off" pattern="^[A-Za-z\s]+$" title="Only letters are allowed" required>
            </div>
            <div class="input-data">
                <label for="publisher">Publisher: </label>
                <input type="text" name="publisher" placeholder="Enter the Publisher" autocomplete="off" pattern="^[A-Za-z\s]+$" title="Only letters are allowed" required>
            </div>
            <div class="input-data">
                <label for="genre">Genre: </label>
                <input type="text" name="genre" placeholder="Enter the Book Genre" autocomplete="off" pattern="^[A-Za-z\s]+$" title="Only letters are allowed" required>
            </div>
            <div class="input-submit">
                <button class="submit" name="submit">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>