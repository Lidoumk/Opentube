<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($conn, "DELETE FROM videos WHERE id = $id");
}

header("Location: videos"); // or wherever your list page is
exit;
?>
