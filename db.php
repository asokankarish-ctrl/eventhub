<?php


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
