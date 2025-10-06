<?php
include "includes/db.php"; // Load DB + config

// Get search query from slug
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';

if (!$slug) {
    echo "<div class='alert alert-warning'>Please enter a search term.</div>";
    include "includes/footer.php";
    exit;
}

// Convert slug to readable search term
$search = str_replace('-', ' ', $slug);
$search = mysqli_real_escape_string($conn, $search);

// Set dynamic page title
$page_title = "Search Results for \"" . htmlspecialchars($search) . "\"";

include "includes/header.php";

// ✅ Pagination Setup
$limit = 12;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// ✅ Get total matching results
$total_result = mysqli_query($conn, "
    SELECT COUNT(*) AS total FROM videos 
    WHERE 
        title LIKE '%$search%' OR 
        stars LIKE '%$search%' OR 
        network LIKE '%$search%' OR 
        tags LIKE '%$search%' OR 
        overview LIKE '%$search%'
");
$total_row = mysqli_fetch_assoc($total_result);
$total_videos = $total_row['total'];
$total_pages = ceil($total_videos / $limit);

// ✅ Fetch paginated results
$sql = "
    SELECT * FROM videos 
    WHERE 
        title LIKE '%$search%' OR 
        stars LIKE '%$search%' OR 
        network LIKE '%$search%' OR 
        tags LIKE '%$search%' OR 
        overview LIKE '%$search%'
    ORDER BY id DESC
    LIMIT $offset, $limit
";
$result = mysqli_query($conn, $sql);
?>

<h2 class="mb-4">
    Search Results for: <span class="text-danger"><?php echo htmlspecialchars($search); ?></span>
</h2>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">
<?php 
if ($result && mysqli_num_rows($result) > 0) {
    while ($video = mysqli_fetch_assoc($result)) { 
        include "videocard.php"; // reusable card
    }
} else {
    // No results message
    ?>
    <div class="alert alert-dismissible alert-secondary d-flex flex-column align-items-center text-center p-4 w-100">
        <h4 class="mb-2">😕 No videos found</h4>
        <p class="mb-3">We couldn’t find any results matching "<strong><?php echo htmlspecialchars($search); ?></strong>".</p>
        <p class="mb-3">Try using different keywords or check out some popular videos:</p>
        <a href="<?php echo $base_url; ?>" class="btn btn-primary mb-2">Go to Homepage</a>
        <div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
            <?php 
            $suggestions = mysqli_query($conn, "SELECT * FROM videos ORDER BY RAND() LIMIT 4");
            while ($video = mysqli_fetch_assoc($suggestions)) {
                echo '<a href="'.$base_url.'watch/'.$video['slug'].'" class="btn btn-outline-dark btn-sm">'.$video['title'].'</a>';
            }
            ?>
        </div>
    </div>
<?php
}
?>
</div>

<?php
// ✅ Only show pagination if more than limit results
if ($total_videos > $limit) {
    $base_pagination_url = $base_url . "search/" . $slug . "/page/";
    include "pagination.php";
}
?>

<?php include "includes/footer.php"; ?>
