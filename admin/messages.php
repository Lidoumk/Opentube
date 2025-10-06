<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index");
    exit;
}

include "header.php";
include "../includes/db.php";
?>

<div class="container py-4">
    <h2>Contact Messages</h2>

    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Received</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $messages = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY created_at DESC");
            if ($messages && mysqli_num_rows($messages) > 0):
                while ($row = mysqli_fetch_assoc($messages)):
                    // Short preview (first 10 words)
                    $words = explode(' ', $row['message']);
                    $short_msg = implode(' ', array_slice($words, 0, 10)) . (count($words) > 10 ? '...' : '');
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#msgModal<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars($short_msg); ?>
                        </a>

                        <!-- Modal -->
                        <div class="modal fade" id="msgModal<?php echo $row['id']; ?>" tabindex="-1">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Message from <?php echo htmlspecialchars($row['name']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </td>
                    <td><?php echo date('M d, Y H:i', strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="delete-message?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
                           onclick="return confirm('Delete this message?')">Delete</a>
                    </td>
                </tr>
            <?php
                endwhile;
            else:
                echo "<tr><td colspan='6' class='text-center'>No messages found.</td></tr>";
            endif;
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php include "footer.php"; ?>
