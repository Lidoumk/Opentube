<?php
include "includes/db.php"; 
$page_title = "Upload Videos";
include "includes/header.php";

$message = "";

// Function to generate clean slug
function generateSlug($string) {
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $string = strtolower($string);
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    return trim($string, '-');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $conn;

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $playtime = mysqli_real_escape_string($conn, $_POST['playtime']);
    $overview = mysqli_real_escape_string($conn, $_POST['overview']);
    $thumbnail = mysqli_real_escape_string($conn, $_POST['thumbnail']);
    $embed = mysqli_real_escape_string($conn, $_POST['embed']);
    $network = mysqli_real_escape_string($conn, $_POST['network']);
    $stars = mysqli_real_escape_string($conn, $_POST['stars']);
    $tags = mysqli_real_escape_string($conn, $_POST['tags']); // NEW

    if ($title && $playtime && $overview && $thumbnail && $embed && $network && $stars && $tags) {

        // Generate slug
        $slug = generateSlug($title);
        $original_slug = $slug;
        $counter = 1;

        // Check if slug exists
        while (true) {
            $check = mysqli_query($conn, "SELECT id FROM videos WHERE slug = '$slug' LIMIT 1");
            if (mysqli_num_rows($check) == 0) break;
            $slug = $original_slug . '-' . $counter++;
        }

        // Insert into database (include tags)
        $insert = mysqli_query($conn, "
            INSERT INTO videos (title, slug, playtime, overview, thumbnail, embed, network, stars, tags) 
            VALUES ('$title', '$slug', '$playtime', '$overview', '$thumbnail', '$embed', '$network', '$stars', '$tags')
        ");

        $message = $insert 
            ? '<div class="alert alert-success">✅ Video added successfully!</div>' 
            : '<div class="alert alert-danger">❌ Error: ' . mysqli_error($conn) . '</div>';

    } else {
        $message = '<div class="alert alert-warning">⚠ Please fill all fields!</div>';
    }
}
?>

<h2 class="mb-4">Upload A New Video</h2>
<?php echo $message; ?>

<form method="post" class="mb-5">

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Playtime (e.g. 30:20)</label>
        <input type="text" name="playtime" class="form-control" placeholder="00:00" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Overview</label>
        <textarea name="overview" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Thumbnail URL</label>
        <input type="url" name="thumbnail" class="form-control" placeholder="https://example.com/image.jpg" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Embed URL</label>
        <input type="url" name="embed" class="form-control" placeholder="https://www.youtube.com/embed/xxxx" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Network (e.g. Netflix)</label>
        <input type="text" name="network" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Stars (comma separated)</label>
        <input type="text" name="stars" class="form-control" placeholder="Actor 1, Actor 2, Actor 3" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Tags (comma separated)</label>
        <input type="text" name="tags" class="form-control" placeholder="Action, Adventure, Anime" required>
    </div>

    <button type="submit" class="btn btn-primary">Upload Video</button>
</form>

<?php include "includes/footer.php"; ?>
