<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index");
    exit;
}

include "header.php";
include "../includes/db.php"; // Database connection
?>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Views</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $videos = mysqli_query($conn, "SELECT id, title, slug, views, created_at FROM videos ORDER BY id DESC");
            if ($videos && mysqli_num_rows($videos) > 0) {
                while ($row = mysqli_fetch_assoc($videos)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['views']}</td>
                        <td>" . date('M d, Y', strtotime($row['created_at'])) . "</td>
                        <td>
                            <a href='{$base_url}watch/{$row['slug']}' class='btn btn-sm btn-primary' target='_blank'>View</a>
                            <a href='edit-video?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                            <a href='delete-video?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete this video?\")'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No videos found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "footer.php"; ?>
