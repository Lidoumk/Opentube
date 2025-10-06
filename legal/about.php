<?php
session_start();
include "../includes/header.php";
$page_title = "About Us";
?>

<main class="flex-grow-1">
<div class="container py-5">
    <h1 class="mb-4">About <?php echo $site_name; ?></h1>

    <p>
        Welcome to <strong><?php echo $site_name; ?></strong>! Our platform is dedicated to providing 
        you with the latest and greatest videos, movies, and shows in one convenient place. 
        We strive to deliver high-quality content and an enjoyable streaming experience for all users.
    </p>

    <p>
        Our website is constantly updated with new releases and trending videos. 
        You can browse by genres, networks, or even search for your favorite stars. 
        We also provide an admin panel to manage videos, making it easy to keep our library fresh.
    </p>

    <p>
        Thank you for visiting <strong><?php echo $site_name; ?></strong>. 
        We hope you enjoy your stay and find the content you love!
    </p>

    <h4 class="mt-5">Contact Us</h4>
    <p>
        For any inquiries or support, you can reach us at: 
        <a href="mailto:contact@example.com">contact@example.com</a>
    </p>
</div>
</main>

<?php include "../includes/footer.php"; ?>
