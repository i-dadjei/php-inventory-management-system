<?php
include("connect/connect.php");

$bookQuery = "SELECT COUNT(*) as totalBooks FROM inventory";
$bookResult = $conn->query($bookQuery);
$bookData = $bookResult->fetch_assoc();
$totalBooks = $bookData['totalBooks'];

$authorQuery = "SELECT COUNT(DISTINCT author) as totalAuthors FROM inventory";
$authorResult = $conn->query($authorQuery);
$authorData = $authorResult->fetch_assoc();
$totalAuthors = $authorData['totalAuthors'];

$publisherQuery = "SELECT COUNT(DISTINCT publisher) as totalPublishers FROM inventory";
$publisherResult = $conn->query($publisherQuery);
$publisherData = $publisherResult->fetch_assoc();
$totalPublishers = $publisherData['totalPublishers'];

$genreQuery = "SELECT COUNT(DISTINCT genre) as totalGenres FROM inventory";
$genreResult = $conn->query($genreQuery);
$genreData = $genreResult->fetch_assoc();
$totalGenres = $genreData['totalGenres'];
