<?php
$servername = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "inventory-system";

$conn = new mysqli('localhost', 'root', '', 'inventory-system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Display a message if the connection failed
};
