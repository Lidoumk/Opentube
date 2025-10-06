<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index");
    exit;
}

include "header.php";
include "../includes/db.php"; // Ensure database is connected

// Fetch statistics
$total_videos = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM videos"))['total'];

$total_views = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(views) AS total FROM videos"))['total'] ?? 0;

// Count unique tags
$tags_result = mysqli_query($conn, "SELECT tags FROM videos");
$all_tags = [];
while ($row = mysqli_fetch_assoc($tags_result)) {
    $tags = array_map('trim', explode(',', $row['tags']));
    $all_tags = array_merge($all_tags, $tags);
}
$total_tags = count(array_unique(array_filter($all_tags)));

// Count unique stars
$stars_result = mysqli_query($conn, "SELECT stars FROM videos");
$all_stars = [];
while ($row = mysqli_fetch_assoc($stars_result)) {
    $stars = array_map('trim', explode(',', $row['stars']));
    $all_stars = array_merge($all_stars, $stars);
}
$total_stars = count(array_unique(array_filter($all_stars)));
?>

    <h2 class="mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h2>

    <div class="row g-3">

        <div class="col-md-6">
            <a href="#" class="text-decoration-none">
                <div class="card bg-primary text-light text-center d-flex align-items-center justify-content-center" style="height: 200px;">
                    <div>
                        <h1 class="fw-bold mb-1"><?php echo $total_videos; ?></h1>
                        <p class="mb-0">Total Videos</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="#" class="text-decoration-none">
                <div class="card bg-primary text-light text-center d-flex align-items-center justify-content-center" style="height: 200px;">
                    <div>
                        <h1 class="fw-bold mb-1"><?php echo $total_views; ?></h1>
                        <p class="mb-0">Total Views</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="#" class="text-decoration-none">
                <div class="card bg-primary text-light text-center d-flex align-items-center justify-content-center" style="height: 200px;">
                    <div>
                        <h1 class="fw-bold mb-1"><?php echo $total_tags; ?></h1>
                        <p class="mb-0">Unique Tags</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="#" class="text-decoration-none">
                <div class="card bg-primary text-light text-center d-flex align-items-center justify-content-center" style="height: 200px;">
                    <div>
                        <h1 class="fw-bold mb-1"><?php echo $total_stars; ?></h1>
                        <p class="mb-0">Unique Stars</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>



<?php include "footer.php"; ?>
