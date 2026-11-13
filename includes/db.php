<?php
/*
 * db.php - Database connection
 * Member 1: [Name] - Database
 * Every page that needs the database starts with: require 'includes/db.php';
 */

$host = "localhost";
$user = "root";
$pass = "";              // XAMPP default password is empty
$db   = "eventhub_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>
