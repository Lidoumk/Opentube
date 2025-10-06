<?php 
include "includes/db.php"; // Load DB + config

// Set page title for homepage
$page_title = "Latest Videos";

include "includes/header.php"; // header will use $page_title | $site_name

// Detect current page number from SEO URL or fallback
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = intval($_GET['page']);
} else {
    preg_match('/page\/([0-9]+)/', $_SERVER['REQUEST_URI'], $matches);
    $page = isset($matches[1]) ? intval($matches[1]) : 1;
}

$limit = 12; // Videos per page
$offset = ($page - 1) * $limit;

// Get total number of videos
$total_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM videos");
$total_row = mysqli_fetch_assoc($total_result);
$total_videos = $total_row['total'];
$total_pages = ceil($total_videos / $limit);

// Fetch videos for this page
$result = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC LIMIT $offset, $limit");
?>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
<?php while ($video = mysqli_fetch_assoc($result)) { 
    include "videocard.php"; // reusable video card
} ?>
</div>

<?php
// SEO Pagination base URL for homepage
$base_pagination_url = $base_url . "page/";

// ✅ Only show pagination if videos are more than the limit
if ($total_videos > $limit) {
    include "pagination.php";
}
?>


<?php include "includes/footer.php"; ?>
