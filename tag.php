<?php
include "includes/db.php";

// Get tag slug from URL
$tag_slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, $_GET['slug']) : "";

if (!$tag_slug) {
    echo "<div class='alert alert-warning'>No tag specified.</div>";
    include "includes/footer.php";
    exit;
}

// Convert slug to readable tag name
$tag_name = str_replace('-', ' ', $tag_slug);

// Normalize slug for SQL comparison (remove - and spaces, lowercase)
$normalized_slug = strtolower(str_replace(['-', ' '], '', $tag_slug));

// Set dynamic page title
$page_title = "ALL " . htmlspecialchars(ucwords($tag_name)) . " Videos";

include "includes/header.php";

// Pagination Setup
$limit = 12;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Get total tag videos
$total_result = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM videos 
    WHERE CONCAT(',', REPLACE(REPLACE(LOWER(tags), ' ', ''), '-', ''), ',') LIKE '%," . $normalized_slug . ",%'
");
$total_row = mysqli_fetch_assoc($total_result);
$total_videos = $total_row['total'];
$total_pages = ceil($total_videos / $limit);

// Fetch paginated videos
$result = mysqli_query($conn, "
    SELECT * FROM videos 
    WHERE CONCAT(',', REPLACE(REPLACE(LOWER(tags), ' ', ''), '-', ''), ',') LIKE '%," . $normalized_slug . ",%'
    ORDER BY id DESC
    LIMIT $offset, $limit
");
?>

<h2 class="mb-4">
    ALL <span class="text-danger"><?php echo htmlspecialchars(ucwords($tag_name)); ?></span> Videos
</h2>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
<?php 
if ($result && mysqli_num_rows($result) > 0) {
    while ($video = mysqli_fetch_assoc($result)) { 
        include "videocard.php"; // reusable card
    }
} else {
    echo "<div class='alert alert-info'>No videos found with this tag.</div>";
}
?>
</div>

<?php
// ✅ Only show pagination if more than 6 videos
if ($total_videos > $limit) {
    $base_pagination_url = $base_url . "tag/" . $tag_slug . "/page/";
    include "pagination.php";
}
?>

<?php include "includes/footer.php"; ?>
