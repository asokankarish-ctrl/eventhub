<?php
/*
 * header.php - Top of every page (head + navigation bar)
 * Member 2: [Name] - Layout and navigation
 * Each page sets $pageTitle before including this file.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | EventHub</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>

<header class="navbar">
    <a href="index.php" class="logo">EventHub</a>
    <nav>
        <a href="index.php">Events</a>
        <a href="register.php">Register</a>
        <a href="registrations.php">Registrations</a>
    </nav>
</header>

<main class="container">
