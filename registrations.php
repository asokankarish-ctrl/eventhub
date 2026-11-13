<?php


require 'includes/db.php';

$sql = "SELECT r.id, r.student_name, r.student_id, r.email, r.phone, r.registered_at,
               e.title AS event_title
        FROM registrations r
        JOIN events e ON r.event_id = e.id
        ORDER BY r.id DESC";
$result = mysqli_query($conn, $sql);
$total  = mysqli_num_rows($result);

$pageTitle = "Registrations";
include 'includes/header.php';
?>

<section>
    <h1>Registered Students</h1>
    <p><?php echo $total; ?> registration(s) so far.</p>

    <?php if (isset($_GET['success'])) { ?>
        <p class="message success">Registration saved successfully.</p>
    <?php } ?>
    <?php if (isset($_GET['deleted'])) { ?>
        <p class="message success">Registration deleted.</p>
    <?php } ?>

    <?php if ($total == 0) { ?>
        <p class="empty">No registrations yet. <a href="register.php">Register for an event</a>.</p>
    <?php } else { ?>
        <div class="table-wrap">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Student ID</th>
                    <th>Event</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td>
                            <!-- Delete form: handled by delete_registration.php (Member 7) -->
                            <form action="delete_registration.php" method="POST" class="delete-form">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php } ?>
</section>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
