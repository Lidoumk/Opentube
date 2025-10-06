<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index");
    exit;
}

include "../includes/db.php";

// Get ID from query string
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Delete message from DB
    $delete = mysqli_query($conn, "DELETE FROM contact_messages WHERE id = $id");

    if ($delete) {
        $_SESSION['message'] = "✅ Message deleted successfully!";
    } else {
        $_SESSION['message'] = "❌ Error deleting message: " . mysqli_error($conn);
    }
} else {
    $_SESSION['message'] = "❌ Invalid message ID.";
}

// Redirect back to contact messages page
header("Location: messages");
exit;
?>
