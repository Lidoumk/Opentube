<?php
// Ensure db.php/config is loaded (optional but safe to check)
if (!isset($base_url)) {
    include "includes/db.php";
}
?>

</div> <!-- container end -->

<!-- FOOTER -->
<footer class="bg-dark text-white py-3 mt-auto">
    <div class="container text-center">
        <p class="mb-1">&copy; <?php echo date('Y'); ?> <?php echo $site_name; ?>. All Rights Reserved.</p>
        <small>
            <a href="<?php echo $base_url; ?>legal/about" class="text-decoration-none text-white-50">ABOUT</a> |
            <a href="<?php echo $base_url; ?>legal/privacy" class="text-decoration-none text-white-50">PRIVACY POLICY</a> |
            <a href="<?php echo $base_url; ?>legal/contact" class="text-decoration-none text-white-50">CONTACT</a>
        </small>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
