<!-- Optimized CSS -->
<style>
    .img-wrapper {
        position: relative;
        background: #f8f9fa;
        min-height: 200px;
        overflow: hidden;
    }
    
    .card-img-top {
        opacity: 0;
        transition: opacity 0.2s ease-in;
        display: block;
        width: 100%;
        height: auto;
    }
    
    .card-img-top.loaded {
        opacity: 1;
    }
</style>

<!-- Optimized Video Card -->
<div class="col">
    <a href="<?php echo $base_url; ?>watch/<?php echo $video['slug']; ?>" class="text-decoration-none text-dark">
        <div class="card h-100 border shadow-sm">

            <!-- Thumbnail Wrapper -->
            <div class="position-relative img-wrapper">
                
                <!-- Optimized Image -->
                <img src="<?php echo $video['thumbnail']; ?>" 
                     class="card-img-top" 
                     alt="<?php echo $video['title']; ?>"
                     loading="lazy"
                     decoding="async"
                     onload="this.classList.add('loaded')">

                <!-- Playtime Overlay -->
                <span class="position-absolute bottom-0 end-0 m-2 px-2 py-1 bg-dark bg-opacity-75 text-white small" style="z-index: 3;">
                    <?php echo $video['playtime']; ?>
                </span>
            </div>

            <div class="card-body">
                <h5 class="card-title mb-1"><?php echo $video['title']; ?></h5>

                <!-- Network Link -->
                <p class="mb-1"><strong>Network:</strong> 
                    <a href="<?php echo $base_url; ?>network/<?php echo slugify($video['network']); ?>" class="text-decoration-none">
                        <?php echo htmlspecialchars($video['network']); ?>
                    </a>
                </p>

                <!-- Stars Links (optimized) -->
                <p class="mb-1"><strong>Stars:</strong> 
                    <?php
                    $stars = array_map('trim', explode(',', $video['stars']));
                    $star_links = array_map(function($star) use ($base_url) {
                        return '<a href="' . $base_url . 'star/' . slugify($star) . '" class="text-decoration-none">' . htmlspecialchars($star) . '</a>';
                    }, $stars);
                    echo implode(', ', $star_links);
                    ?>
                </p>

            </div>

        </div>
    </a>
</div>