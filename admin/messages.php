<?php

/**
 * Njenga Sam Portfolio - Admin Messages
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$db = getDB();
$message = '';
$messageType = '';

// Mark as read
if (isset($_GET['read'])) {
    $stmt = $db->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
    $stmt->execute([(int)$_GET['read']]);
    $message = 'Message marked as read.';
    $messageType = 'success';
}

// Delete
if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([(int)$_GET['delete']]);
    $message = 'Message deleted.';
    $messageType = 'success';
}

$messages = $db->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();

$activePage = 'messages';
$activeTitle = 'Messages';
include __DIR__ . '/partials/header.php';
?>

<div class="admin-header">
    <h1>Contact Messages</h1>
</div>

<?php if ($message): ?>
<div class="alert alert-<?php echo $messageType; ?>"><?php echo h($message); ?></div>
<?php endif; ?>

<div class="table-container">
    <h3>Inbox</h3>
    <?php if (count($messages) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $m): ?>
            <tr style="<?php echo $m['is_read'] ? '' : 'background:var(--primary-light);font-weight:600;'; ?>">
                <td><strong><?php echo h($m['name']); ?></strong></td>
                <td><a href="mailto:<?php echo h($m['email']); ?>"><?php echo h($m['email']); ?></a></td>
                <td><?php echo h($m['subject'] ?? 'General'); ?></td>
                <td style="max-width:300px;"><?php echo h(truncateText($m['message'], 100)); ?></td>
                <td><?php echo $m['is_read'] ? '<span style="color:var(--muted);">Read</span>' : '<span style="color:var(--accent);">New</span>'; ?>
                </td>
                <td><small><?php echo formatDate($m['created_at']); ?></small></td>
                <td>
                    <?php if (!$m['is_read']): ?>
                    <a href="?read=<?php echo $m['id']; ?>" class="btn btn-sm btn-primary">Mark Read</a>
                    <?php endif; ?>
                    <a href="?delete=<?php echo $m['id']; ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this message?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p style="color:var(--muted);text-align:center;padding:2rem;">No messages yet.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
</content>