<?php
include("connect/connect.php");

//Get input data from search bar
if (isset($_GET['search'])) {
    $search = $_GET['search'];

    //sql query to get data by search
    $searchsql = "SELECT * FROM inventory WHERE `title` LIKE '%$search%'";
    $searchresult = mysqli_query($conn, $searchsql);
}
