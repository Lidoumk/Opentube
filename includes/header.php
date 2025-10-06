<?php 
include __DIR__ . "/db.php";

// If $page_title is not set, use site name
$page_title = $page_title ?? $site_name;

// Combine page title with site name
$full_title = $page_title . " | " . $site_name;

// If not set, provide defaults for SEO
$meta_description = $meta_description ?? "Welcome to $site_name – the best place for streaming videos, movies, and shows.";
$meta_keywords = $meta_keywords ?? "videos, movies, streaming, entertainment";

// For Open Graph / Social Sharing
$og_title = htmlspecialchars($full_title);
$og_description = htmlspecialchars($meta_description);
$og_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// Use video thumbnail if $video['thumbnail'] exists, otherwise default image
$og_image = isset($video['thumbnail']) && $video['thumbnail'] ? $video['thumbnail'] : ($base_url . 'assets/default-thumbnail.jpg');

// Helper: Convert playtime "MM:SS" or "HH:MM:SS" to ISO 8601 duration PT#H#M#S
function iso8601_duration($time) {
    $parts = explode(':', $time);
    $duration = 'PT';
    if(count($parts) == 3) { // HH:MM:SS
        $duration .= intval($parts[0]) . 'H' . intval($parts[1]) . 'M' . intval($parts[2]) . 'S';
    } elseif(count($parts) == 2) { // MM:SS
        $duration .= intval($parts[0]) . 'M' . intval($parts[1]) . 'S';
    } else { // SS only
        $duration .= intval($parts[0]) . 'S';
    }
    return $duration;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <title><?php echo htmlspecialchars($full_title); ?></title>
    <meta name="description" content="<?php echo $og_description; ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="<?php echo $og_title; ?>">
    <meta property="og:description" content="<?php echo $og_description; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $og_url; ?>">
    <meta property="og:image" content="<?php echo $og_image; ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $og_title; ?>">
    <meta name="twitter:description" content="<?php echo $og_description; ?>">
    <meta name="twitter:image" content="<?php echo $og_image; ?>">

    <!-- JSON-LD Structured Data -->
    <?php if (isset($video['title'])): ?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "VideoObject",
      "name": "<?php echo addslashes($video['title']); ?>",
      "description": "<?php echo addslashes(substr($video['overview'], 0, 200)); ?>",
      "thumbnailUrl": "<?php echo $video['thumbnail']; ?>",
      "uploadDate": "<?php echo date('Y-m-d', strtotime($video['created_at'])); ?>",
      "duration": "<?php echo iso8601_duration($video['playtime']); ?>",
      "contentUrl": "<?php echo $base_url . 'watch/' . $video['slug']; ?>",
      "embedUrl": "<?php echo $video['embed']; ?>",
      "publisher": {
        "@type": "Organization",
        "name": "<?php echo addslashes($site_name); ?>",
        "logo": {
          "@type": "ImageObject",
          "url": "<?php echo $base_url; ?>assets/logo.png"
        }
      }
    }
    </script>
    <?php endif; ?>

    <!-- Stylesheet -->
    <link href="<?php echo $base_url; ?>assets/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">





<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo $base_url; ?>">
            <img src="<?php echo $base_url; ?>assets/logo.png" alt="Logo" height="30" class="me-2">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>trending">Trending</a></li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Genres
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/action">Action</a></li>
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/adventure">Adventure</a></li>
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/animation">Animation</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/crime">Crime</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/documentary">Documentary</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/drama">Drama</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/erotic">Erotic</a></li>                     
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/family">Family</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/fantasy">Fantasy</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/history">History</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/horror">Horror</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/music">Music</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/mystery">Mystery</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/romance">Romance</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/science-fiction">Science Fiction</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/thriller">Thriller</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/war">War</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>tag/western">Western</a></li>       
                </ul>
            </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    Networks
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>network/netflix">Netflix</a></li>
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>network/######">Amazon Prime</a></li>
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>network/apple-tv">Apple Tv</a></li> 
                    <li><a class="dropdown-item" href="<?php echo $base_url; ?>network/######">Paramount Plus</a></li> 
                </ul>
            </li>

                <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>upload">Upload</a></li>
            </ul>

           <form class="d-flex" action="" method="get" onsubmit="return redirectSearch(this);">
            <input type="text" name="q" class="form-control me-2" placeholder="Search..." required>
            <button class="btn btn-danger" type="submit">Search</button>
        </form>

        <script>
        function redirectSearch(form) {
            let query = form.q.value.trim();
            if(!query) return false;
            // Slugify in JS (basic)
            let slug = query.toLowerCase()
                            .replace(/[:;,.!?]/g,'')  // remove punctuation
                            .replace(/[^a-z0-9]+/g,'-') // replace spaces/non-alphanum with -
                            .replace(/-+/g,'-')       // collapse multiple -
                            .replace(/^-|-$/g,'');    // trim - from start/end
            window.location.href = "<?php echo $base_url; ?>search/" + slug;
            return false; // prevent normal submit
        }
        </script>

        </div>
    </div>
</nav>

<div class="container mt-4">
