<?php
/*
 * save_registration.php - Checks the form data and saves it (CREATE)
 * Member 5: [Name] - Form processing and validation
 * This file shows no page. It saves, then redirects.
 */

require 'includes/db.php';

// Only accept data sent by the form (POST)
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: register.php");
    exit;
}

// 1. Read the form values
$eventId   = (int)($_POST['event_id'] ?? 0);
$name      = trim($_POST['student_name'] ?? "");
$studentId = trim($_POST['student_id'] ?? "");
$email     = trim($_POST['email'] ?? "");
$phone     = trim($_POST['phone'] ?? "");

// 2. Validate (never trust the browser)
$error = "";

if ($eventId <= 0) {
    $error = "Please choose an event.";
} elseif (empty($name)) {
    $error = "Name is required.";
} elseif (empty($studentId)) {
    $error = "Student ID is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Please enter a valid email address.";
} elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
    $error = "Phone number must be exactly 10 digits.";
}

// 3. Check the event still has seats, and the student is not already registered
if ($error == "") {
    $stmt = mysqli_prepare($conn,
        "SELECT e.seats, COUNT(r.id) AS registered,
                SUM(r.student_id = ?) AS already
         FROM events e
         LEFT JOIN registrations r ON r.event_id = e.id
         WHERE e.id = ?
         GROUP BY e.id");
    mysqli_stmt_bind_param($stmt, "si", $studentId, $eventId);
    mysqli_stmt_execute($stmt);
    $event = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    if (!$event) {
        $error = "That event does not exist.";
    } elseif ($event['already'] > 0) {
        $error = "This student ID is already registered for that event.";
    } elseif ($event['registered'] >= $event['seats']) {
        $error = "Sorry, this event is full.";
    }
}

// 4. If anything is wrong, go back to the form with the message
if ($error != "") {
    header("Location: register.php?event=" . $eventId . "&error=" . urlencode($error));
    exit;
}

// 5. Save with a prepared statement (prevents SQL injection)
$stmt = mysqli_prepare($conn,
    "INSERT INTO registrations (event_id, student_name, student_id, email, phone)
     VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "issss", $eventId, $name, $studentId, $email, $phone);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);

// 6. Go to the registrations list with a success message
header("Location: registrations.php?success=1");
exit;
?>
