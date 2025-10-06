<?php
// Database Connection Settings
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "url";

// Create Connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4"); // Handle accents & emojis

if (!function_exists('slugify')) {
    function slugify($string) {
        // Remove trailing punctuation
        $string = rtrim($string, ':;,.!?');

        // Convert to ASCII
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

        // Lowercase
        $string = strtolower($string);

        // Replace any non-alphanumeric character with a hyphen
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);

        // Remove multiple hyphens
        $string = preg_replace('/-+/', '-', $string);

        // Trim hyphens from start and end
        return trim($string, '-');
    }
}


// Site Config
$base_url = "http://localhost/url/"; 
$site_name = "Series TV";
?>
