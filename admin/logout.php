<?php
session_start();
session_destroy();
require_once "../includes/db.php"; // if $base_url is defined there
header("Location: " . rtrim($base_url, '/') . "/admin");
exit;
