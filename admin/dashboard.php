<?php

/**
 * Njenga Sam Portfolio - Admin Dashboard
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$stats = getDashboardStats();
$db = getDB();
$recentProjects = $db->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 5")->fetchAll();
$recentMessages = $db->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5")->fetchAll();

$activePage = 'dashboard';
$activeTitle = 'Dashboard';
include __DIR__ . '/partials/header.php';
?>

<div class="admin-header">
    <h1>Dashboard</h1>
    <span style="color:var(--muted);font-size:0.9rem;">Welcome, <?php echo h($_SESSION['admin_username']); ?></span>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">&#128187;</div>
        <div class="stat-value"><?php echo $stats['total_projects']; ?></div>
        <div class="stat-label">Published Projects</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">&#9733;</div>
        <div class="stat-value"><?php echo $stats['total_testimonials']; ?></div>
        <div class="stat-label">Approved Testimonials</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">&#9993;</div>
        <div class="stat-value"><?php echo $stats['total_messages']; ?></div>
        <div class="stat-label">Contact Messages</div>
    </div>
</div>

<div class="form-container">
    <h3>Recent Projects</h3>
    <?php if (count($recentProjects) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentProjects as $p): ?>
            <tr>
                <td>
                    <?php if ($p['image']): ?>
                    <img src="<?php echo SITE_URL; ?>/uploads/<?php echo h($p['image']); ?>" class="preview-img" alt="">
                    <?php else: ?>
                    <span style="color:var(--muted);">No img</span>
                    <?php endif; ?>
                </td>
                <td><strong><?php echo h($p['title']); ?></strong></td>
                <td><?php echo h($p['category']); ?></td>
                <td><?php echo $p['is_published'] ? '<span style="color:var(--success);">Published</span>' : '<span style="color:var(--muted);">Draft</span>'; ?>
                </td>
                <td><small><?php echo formatDate($p['created_at']); ?></small></td>
                <td>
                    <a href="manage_projects.php?edit=<?php echo $p['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p style="color:var(--muted);text-align:center;padding:2rem;">No projects yet.</p>
    <?php endif; ?>
</div>

<div class="table-container">
    <h3>Recent Messages</h3>
    <?php if (count($recentMessages) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recentMessages as $m): ?>
            <tr>
                <td><strong><?php echo h($m['name']); ?></strong></td>
                <td><?php echo h($m['email']); ?></td>
                <td><?php echo h($m['subject']); ?></td>
                <td><small><?php echo formatDate($m['created_at']); ?></small></td>
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