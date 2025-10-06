<?php 
include "includes/db.php"; // Load DB + config

// Dynamic SEO
$page_title = "Trending Videos";
$meta_description = "Watch the most trending videos from the last 30 days.";
$meta_keywords = "trending videos, popular, new releases, top videos";

include "includes/header.php";

// Pagination Setup
$limit = 12; // Show 12 per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Get total trending videos
$total_result = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM videos
    WHERE created_at >= NOW() - INTERVAL 30 DAY
");
$total_row = mysqli_fetch_assoc($total_result);
$total_videos = $total_row['total'];
$total_pages = ceil($total_videos / $limit);

// Fetch trending videos
$result = mysqli_query($conn, "
    SELECT * FROM videos 
    WHERE created_at >= NOW() - INTERVAL 30 DAY
    ORDER BY views DESC 
    LIMIT $offset, $limit
");
?>

<h2 class="mb-4">Trending Videos (Last 30 Days)</h2>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
<?php 
if ($result && mysqli_num_rows($result) > 0) {
    while ($video = mysqli_fetch_assoc($result)) { 
        include "videocard.php"; // reusable card
    }
} else {
    echo "<div class='alert alert-info'>No trending videos found.</div>";
}
?>
</div>

<?php
// ✅ Only show pagination if more than one page
if ($total_videos > $limit) {
    $base_pagination_url = $base_url . "trending/page/";
    include "pagination.php";
}
?>

<?php include "includes/footer.php"; ?>
