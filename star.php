<?php
include "includes/db.php";

$slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, $_GET['slug']) : "";

// Convert slug to readable name
$star_name = str_replace('-', ' ', $slug);

// Set dynamic page title
$page_title = "ALL " . htmlspecialchars(ucwords($star_name)) . " Videos";

include "includes/header.php";

// ✅ Pagination Setup
$limit = 12;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// ✅ Get total videos for this star
$total_result = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM videos 
    WHERE LOWER(stars) LIKE '%" . strtolower($star_name) . "%'
");
$total_row = mysqli_fetch_assoc($total_result);
$total_videos = $total_row['total'];
$total_pages = ceil($total_videos / $limit);

// ✅ Fetch paginated videos
$result = mysqli_query($conn, "
    SELECT * FROM videos 
    WHERE LOWER(stars) LIKE '%" . strtolower($star_name) . "%'
    ORDER BY id DESC
    LIMIT $offset, $limit
");
?>

<h2 class="mb-4">
    ALL <span class="text-danger"><?php echo htmlspecialchars(ucwords($star_name)); ?></span> Videos
</h2>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
<?php 
if ($result && mysqli_num_rows($result) > 0) {
    while ($video = mysqli_fetch_assoc($result)) { 
        include "videocard.php"; // reusable card
    }
} else {
    echo "<div class='alert alert-warning'>No videos found for this star.</div>";
}
?>
</div>

<?php
// ✅ Only show pagination if needed
if ($total_videos > $limit) {
    $base_pagination_url = $base_url . "star/" . $slug . "/page/";
    include "pagination.php";
}
?>

<?php include "includes/footer.php"; ?>
