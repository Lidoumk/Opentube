<?php
session_start();
include "../includes/db.php";
include "../includes/header.php"; // Main header
$page_title = "Contact Us";

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if ($name && $email && $message) {
        $insert = mysqli_query($conn, "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')");
        if ($insert) {
            $success_msg = "Your message has been sent successfully!";
        } else {
            $error_msg = "Error: " . mysqli_error($conn);
        }
    } else {
        $error_msg = "⚠ Please fill all fields!";
    }
}
?>

<main class="flex-grow-1">
    <div class="container py-5">
        <h1 class="mb-4">Contact Us</h1>

        <?php if ($success_msg) echo "<div class='alert alert-success'>$success_msg</div>"; ?>
        <?php if ($error_msg) echo "<div class='alert alert-danger'>$error_msg</div>"; ?>

        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label" for="name">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your message here..." required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>
</main>

<?php include "../includes/footer.php"; ?>
