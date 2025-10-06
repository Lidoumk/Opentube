<?php
include "includes/db.php"; // or "../includes/db.php" if inside /admin

// Set your new admin credentials here
$username = "mekadz"; 
$password = "com1996a"; // Change this before using in production!

// Hash the password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$query = "INSERT INTO admins (username, password) VALUES ('$username', '$hashed_password')";

if (mysqli_query($conn, $query)) {
    echo "✅ Admin user created successfully!<br>";
    echo "Username: <b>$username</b><br>";
    echo "Password: <b>$password</b><br>";
    echo "<hr>⚠️ <b>Now delete this file (create_admin.php) for security!</b>";
} else {
    echo "❌ Error: " . mysqli_error($conn);
}
?>
