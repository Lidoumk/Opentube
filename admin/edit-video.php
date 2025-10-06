<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index");
    exit;
}

include "header.php";
include "../includes/db.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid video ID.</div>";
    include "footer.php";
    exit;
}

$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM videos WHERE id = $id LIMIT 1");

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<div class='alert alert-danger'>Video not found.</div>";
    include "footer.php";
    exit;
}

$video = mysqli_fetch_assoc($result);
$message = "";

// Handle Edit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $playtime = mysqli_real_escape_string($conn, $_POST['playtime']);
    $overview = mysqli_real_escape_string($conn, $_POST['overview']);
    $thumbnail = mysqli_real_escape_string($conn, $_POST['thumbnail']);
    $embed = mysqli_real_escape_string($conn, $_POST['embed']);
    $network = mysqli_real_escape_string($conn, $_POST['network']);
    $stars = mysqli_real_escape_string($conn, $_POST['stars']);
    $tags = mysqli_real_escape_string($conn, $_POST['tags']);

    $update = mysqli_query($conn, "
        UPDATE videos SET 
            title='$title',
            playtime='$playtime',
            overview='$overview',
            thumbnail='$thumbnail',
            embed='$embed',
            network='$network',
            stars='$stars',
            tags='$tags'
        WHERE id=$id
    ");

    $message = $update 
        ? '<div class="alert alert-success">✅ Video updated successfully!</div>'
        : '<div class="alert alert-danger">❌ Error: ' . mysqli_error($conn) . '</div>';
}
?>

<h2 class="mb-4">Edit Video: <?php echo htmlspecialchars($video['title']); ?></h2>
<?php echo $message; ?>

<form method="post" class="mb-5">

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($video['title']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Playtime</label>
        <input type="text" name="playtime" class="form-control" value="<?php echo htmlspecialchars($video['playtime']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Overview</label>
        <textarea name="overview" class="form-control" rows="4" required><?php echo htmlspecialchars($video['overview']); ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Thumbnail URL</label>
        <input type="url" name="thumbnail" class="form-control" value="<?php echo htmlspecialchars($video['thumbnail']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Embed URL</label>
        <input type="url" name="embed" class="form-control" value="<?php echo htmlspecialchars($video['embed']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Network</label>
        <input type="text" name="network" class="form-control" value="<?php echo htmlspecialchars($video['network']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Stars</label>
        <input type="text" name="stars" class="form-control" value="<?php echo htmlspecialchars($video['stars']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Tags</label>
        <input type="text" name="tags" class="form-control" value="<?php echo htmlspecialchars($video['tags']); ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="videos" class="btn btn-secondary">Back</a>

</form>

<?php include "footer.php"; ?>
