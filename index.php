<?php

require 'includes/db.php';

$sql = "SELECT e.*, COUNT(r.id) AS registered
        FROM events e
        LEFT JOIN registrations r ON r.event_id = e.id
        GROUP BY e.id
        ORDER BY e.event_date";
$result = mysqli_query($conn, $sql);

$pageTitle = "Events";
include 'includes/header.php';
?>

<section class="hero">
    <h1>Upcoming Student Events</h1>
    <p>Find an event you like and register in less than a minute.</p>
</section>

<!-- Search box (filtering is done by js/script.js) -->
<input type="text" id="searchBox" class="search-box" placeholder="Search events by name or venue...">

<section class="event-grid" id="eventGrid">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <?php $seatsLeft = $row['seats'] - $row['registered']; ?>
        <article class="event-card">
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
            <p class="event-meta">
                <?php echo date("d M Y", strtotime($row['event_date'])); ?>
                &middot; <?php echo htmlspecialchars($row['venue']); ?>
            </p>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <p class="seats"><?php echo $seatsLeft; ?> of <?php echo $row['seats']; ?> seats left</p>

            <?php if ($seatsLeft > 0) { ?>
                <a class="btn" href="register.php?event=<?php echo $row['id']; ?>">Register</a>
            <?php } else { ?>
                <span class="btn btn-disabled">Full</span>
            <?php } ?>
        </article>
    <?php } ?>
</section>

<p id="noResults" class="empty" hidden>No events match your search.</p>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
