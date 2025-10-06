<?php
session_start();

// If already logged in, redirect to /admin/dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard");
    exit;
}

include __DIR__ . "/../includes/db.php"; // Load DB

$message = "";

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admins WHERE username = '$username' LIMIT 1");
    if ($query && mysqli_num_rows($query) > 0) {
        $admin = mysqli_fetch_assoc($query);

        if (password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];

            header("Location: dashboard"); // ✅ No .php
            exit;
        } else {
            $message = "❌ Incorrect password!";
        }
    } else {
        $message = "❌ User not found!";
    }
}
?>

<?php 
$page_title = "Login";
include "header.php"; 
?>

<div class="d-flex align-items-center justify-content-center vh-100">
    <div style="width: 350px;">

        <h3 class="text-center mb-4">Admin Login</h3>

        <?php if ($message): ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

    </div>
</div>


<?php include "footer.php"; ?>
