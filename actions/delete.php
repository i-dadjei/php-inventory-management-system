<?php
include("../connect/connect.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_GET["deleteid"])) {
    $id = $_GET['deleteid'];

    // Delete query
    $sql = "DELETE FROM inventory WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        // Error handling if deletion fails
        die("Failed to delete" . mysqli_error($conn));
    } else {
        // Redirect to inventory page if successful
        header("Location: ../inventory.php");
        exit(); // Always call exit after a header redirect
    }
}
