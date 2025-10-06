<?php
include "includes/db.php";

$slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, $_GET['slug']) : "";

// Convert slug back to readable text for search
$network_name = str_replace('-', ' ', $slug);

// Set the page title dynamically with "ALL"
$page_title = "ALL " . htmlspecialchars(ucwords($network_name)) . " Videos";

include "includes/header.php";

// ----- Pagination Logic -----
$limit = 6; // Videos per page

// Detect page number from SEO URL like /network/netflix/page/2
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = intval($_GET['page']);
} else {
    preg_match('/page\/([0-9]+)/', $_SERVER['REQUEST_URI'], $matches);
    $page = isset($matches[1]) ? intval($matches[1]) : 1;
}

$offset = ($page - 1) * $limit;

// Count total videos in this network
$total_result = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM videos 
    WHERE LOWER(network) = '" . strtolower($network_name) . "'
");
$total_row = mysqli_fetch_assoc($total_result);
$total_videos = $total_row['total'];
$total_pages = ceil($total_videos / $limit);

// Fetch videos with pagination
$result = mysqli_query($conn, "
    SELECT * FROM videos 
    WHERE LOWER(network) = '" . strtolower($network_name) . "' 
    ORDER BY id DESC 
    LIMIT $offset, $limit
");
?>

<h2 class="mb-4">
    ALL <span class="text-danger"><?php echo htmlspecialchars(ucwords($network_name)); ?></span> Videos
</h2>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
<?php 
if ($result && mysqli_num_rows($result) > 0) {
    while ($video = mysqli_fetch_assoc($result)) { 
        include "videocard.php"; // reusable card
    }
} else {
    echo "<div class='alert alert-warning'>No videos found for this network.</div>";
}
?>
</div>

<?php
// SEO Pagination base URL → /network/netflix/page/
$base_pagination_url = $base_url . "network/" . $slug . "/page/";

// ✅ Only show pagination if more than 6 videos
if ($total_videos > $limit) {
    include "pagination.php";
}
?>


<?php include "includes/footer.php"; ?>
