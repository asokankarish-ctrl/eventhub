<?php


require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM registrations WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
header("Location: registrations.php?deleted=1");
exit;
?>
