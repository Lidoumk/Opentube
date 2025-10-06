<?php
// admin/header.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . "/../includes/db.php";

$page_title = $page_title ?? "Admin Panel";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlspecialchars($page_title); ?> | Admin</title>

<link href="<?php echo rtrim($base_url, '/'); ?>/assets/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">

    <a class="navbar-brand" href="<?php echo rtrim($base_url, '/'); ?>/admin/dashboard">Admin Panel</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminNavbar">

      <?php if (isset($_SESSION['admin_logged_in'])): ?>

        <!-- LEFT SIDE LINKS -->
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="dashboard">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="videos">Videos</a></li>
          <li class="nav-item"><a class="nav-link" href="messages">messages</a></li>
        </ul>

        <!-- RIGHT SIDE LOGOUT BUTTON -->
        <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="btn btn-danger" href="logout">Logout</a>
        </li>
        </ul>


      <?php endif; ?>

    </div>

  </div>
</nav>



<div class="container mt-4">
