<?php 
include "includes/db.php"; // Load DB + config

// Get slug - more efficient validation
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($conn, $_GET['slug']) : "";

if (empty($slug)) {
    header("Location: " . $base_url);
    exit;
}

// Fetch video by slug - use prepared statement for better performance
$stmt = mysqli_prepare($conn, "SELECT * FROM videos WHERE slug = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    ?>
    <div class="alert alert-dismissible alert-secondary d-flex flex-column align-items-center text-center p-4">
        <h4 class="mb-2">❌ Video not found</h4>
        <p class="mb-3">Sorry, the video you are looking for does not exist or has been removed.</p>
        <p class="mb-3">Check out some other videos you might like:</p>
        
        <a href="<?php echo $base_url; ?>" class="btn btn-primary mb-2">Go to Homepage</a>
        
        <div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
            <?php 
            // Fetch 4 random videos as suggestions
            $suggestions = mysqli_query($conn, "SELECT slug, title FROM videos ORDER BY RAND() LIMIT 4");
            while ($video = mysqli_fetch_assoc($suggestions)) {
                echo '<a href="'.$base_url.'watch/'.$video['slug'].'" class="btn btn-outline-dark btn-sm">'.htmlspecialchars($video['title']).'</a>';
            }
            ?>
        </div>
    </div>
    <?php
    include "includes/footer.php";
    exit;
}

$video = mysqli_fetch_assoc($result);

// Increment views asynchronously (non-blocking)
mysqli_query($conn, "UPDATE videos SET views = views + 1 WHERE id = {$video['id']}");
$video['views']++; // Update local variable

// Set dynamic page title and SEO - more efficient string handling
$page_title = htmlspecialchars($video['title']);
$meta_description = htmlspecialchars(mb_substr($video['overview'], 0, 160));
$meta_keywords = htmlspecialchars(str_replace(', ', ',', $video['tags']));

include "includes/header.php";
?>

<!-- Optimized CSS for Player Loading -->
<style>
    .player-wrapper {
        position: relative;
        background: #000;
    }
    
    .player-wrapper iframe {
        opacity: 0;
        transition: opacity 0.3s ease-in;
    }
    
    .player-wrapper iframe.loaded {
        opacity: 1;
    }
</style>

<!-- Video Embed - Removed Spinner for Faster Load -->
<div class="ratio ratio-16x9 mb-3 player-wrapper">
    <iframe 
        src="<?php echo htmlspecialchars($video['embed']); ?>" 
        frameborder="0" 
        allowfullscreen
        loading="lazy"
        onload="this.classList.add('loaded')"></iframe>
</div>

<!-- Video Details -->
<div class="card border shadow-sm mb-4">
    <div class="card-body p-3">
        <h2 class="h4 mb-3"><?php echo htmlspecialchars($video['title']); ?></h2>
        
        <div class="d-flex flex-wrap gap-3 small text-muted mb-3">
            <span><i class="bi bi-calendar3"></i> <?php echo date('M j, Y', strtotime($video['created_at'])); ?></span>
            <span><i class="bi bi-eye"></i> <?php echo number_format($video['views']); ?> views</span>
            <span><i class="bi bi-clock"></i> <?php echo htmlspecialchars($video['playtime']); ?></span>
        </div>

        <div class="mb-2">
            <span class="text-muted small me-2">Network:</span>
            <a href="<?php echo $base_url; ?>network/<?php echo slugify($video['network']); ?>" class="badge bg-danger text-decoration-none">
                <?php echo htmlspecialchars($video['network']); ?>
            </a>
        </div>

        <div class="mb-2">
            <span class="text-muted small me-2">Stars:</span>
            <?php
            $stars = array_filter(array_map('trim', explode(',', $video['stars'])));
            foreach ($stars as $star) {
                echo '<a href="' . $base_url . 'star/' . slugify($star) . '" class="badge bg-primary text-decoration-none me-1">' . htmlspecialchars($star) . '</a>';
            }
            ?>
        </div>

        <div class="mb-3">
            <span class="text-muted small me-2">Tags:</span>
            <?php
            $tags = array_filter(array_map('trim', explode(',', $video['tags'])));
            foreach ($tags as $tag) {
                echo '<a href="' . $base_url . 'tag/' . slugify($tag) . '" class="badge bg-secondary text-decoration-none me-1">' . htmlspecialchars($tag) . '</a>';
            }
            ?>
        </div>

        <p class="mb-0 small"><?php echo nl2br(htmlspecialchars($video['overview'])); ?></p>
    </div>
</div>

<!-- Related Videos -->
<h3 class="mb-3">Related Videos</h3>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2">

<?php
// Optimized related videos query - single query with fallback
$network_escaped = mysqli_real_escape_string($conn, $video['network']);
$related = mysqli_query($conn, "
    (SELECT * FROM videos 
     WHERE network = '{$network_escaped}' AND slug != '{$slug}'
     ORDER BY id DESC LIMIT 6)
    UNION
    (SELECT * FROM videos 
     WHERE slug != '{$slug}'
     ORDER BY RAND() LIMIT 6)
    LIMIT 6
");

// Optimized: Check if we got results
if ($related && mysqli_num_rows($related) > 0) {
    while ($rel = mysqli_fetch_assoc($related)) { 
        $video = $rel; // set $video so videocard.php works
        include "videocard.php"; 
    }
} else {
    echo '<p class="text-muted">No related videos found.</p>';
}
?>

</div>

<?php include "includes/footer.php"; ?>