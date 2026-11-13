<?php
/*
 * edit_registration.php - Change an existing registration (UPDATE)
 * Member 10: [Name] - Edit feature, README and GitHub
 *
 * This one file does two jobs:
 *   GET  edit_registration.php?id=5  -> show the form filled with registration 5
 *   POST (form submitted)            -> check the new values and UPDATE the row
 */

require 'includes/db.php';

$error = "";

/* ---------- 1. Form submitted: check and save (POST) ---------- */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id        = (int)($_POST['id'] ?? 0);
    $eventId   = (int)($_POST['event_id'] ?? 0);
    $name      = trim($_POST['student_name'] ?? "");
    $studentId = trim($_POST['student_id'] ?? "");
    $email     = trim($_POST['email'] ?? "");
    $phone     = trim($_POST['phone'] ?? "");

    // Same rules as a new registration
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

    // The same student cannot be in the same event twice
    // (id <> ? skips this registration itself)
    if ($error == "") {
        $stmt = mysqli_prepare($conn,
            "SELECT COUNT(*) AS total FROM registrations
             WHERE event_id = ? AND student_id = ? AND id <> ?");
        mysqli_stmt_bind_param($stmt, "isi", $eventId, $studentId, $id);
        mysqli_stmt_execute($stmt);
        $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);

        if ($row['total'] > 0) {
            $error = "This student ID is already registered for that event.";
        }
    }

    // Save the changes with a prepared UPDATE
    if ($error == "") {
        $stmt = mysqli_prepare($conn,
            "UPDATE registrations
             SET event_id = ?, student_name = ?, student_id = ?, email = ?, phone = ?
             WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "issssi", $eventId, $name, $studentId, $email, $phone, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        header("Location: registrations.php?updated=1");
        exit;
    }

    // If there was an error, keep what the user typed so the form shows it again
    $registration = [
        "id" => $id, "event_id" => $eventId, "student_name" => $name,
        "student_id" => $studentId, "email" => $email, "phone" => $phone
    ];

/* ---------- 2. Page opened from the Edit link: load the row (GET) ---------- */
} else {
    $id = (int)($_GET['id'] ?? 0);

    $stmt = mysqli_prepare($conn, "SELECT * FROM registrations WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $registration = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);

    // No such registration: go back to the list
    if (!$registration) {
        header("Location: registrations.php");
        exit;
    }
}

/* ---------- 3. Events for the dropdown ---------- */
$events = mysqli_query($conn, "SELECT id, title FROM events ORDER BY event_date");

$pageTitle = "Edit Registration";
include 'includes/header.php';
?>

<section class="form-section">
    <h1>Edit Registration #<?php echo $registration['id']; ?></h1>
    <p>Change the details and click Save Changes.</p>

    <?php if ($error != "") { ?>
        <p class="message error"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <!-- Same field ids as register.php, so js/script.js checks this form too -->
    <form id="registerForm" action="edit_registration.php" method="POST" novalidate>

        <input type="hidden" name="id" value="<?php echo $registration['id']; ?>">

        <label for="event_id">Event</label>
        <select id="event_id" name="event_id">
            <?php while ($event = mysqli_fetch_assoc($events)) { ?>
                <option value="<?php echo $event['id']; ?>" <?php if ($event['id'] == $registration['event_id']) echo "selected"; ?>>
                    <?php echo htmlspecialchars($event['title']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="student_name">Full Name</label>
        <input type="text" id="student_name" name="student_name" maxlength="100"
               value="<?php echo htmlspecialchars($registration['student_name']); ?>">

        <label for="student_id">Student ID</label>
        <input type="text" id="student_id" name="student_id" maxlength="20"
               value="<?php echo htmlspecialchars($registration['student_id']); ?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" maxlength="100"
               value="<?php echo htmlspecialchars($registration['email']); ?>">

        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" maxlength="10"
               value="<?php echo htmlspecialchars($registration['phone']); ?>">

        <p id="formError" class="message error" hidden></p>

        <div class="form-actions">
            <button type="submit" class="btn">Save Changes</button>
            <a href="registrations.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</section>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
