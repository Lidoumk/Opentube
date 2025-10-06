<?php
// Expected Variables Before Including:
// $page (current page number)
// $total_pages (total number of pages)
// $base_pagination_url (base URL for pagination, e.g., "$base_url . 'page/'")

if (!isset($page) || !isset($total_pages) || !isset($base_pagination_url)) {
    return; // Do nothing if required variables are missing
}
?>

<nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $base_pagination_url . ($page - 1); ?>">« Prev</a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="<?php echo $base_pagination_url . $i; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $base_pagination_url . ($page + 1); ?>">Next »</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
