<?php

/**
 * Njenga Sam Portfolio - Project Detail Page
 * Loaded inside the iframe modal from the gallery.
 * Shows full description + "Visit this webpage" link.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$project = $slug ? getProjectBySlug($slug) : null;

if (!$project || !$project['is_published']) {
    $pageTitle = 'Project Not Found';
    include __DIR__ . '/includes/header.php';
?>
<section class="p-section">
    <div class="p-container">
        <div style="text-align:center;padding:3rem 1rem;color:var(--text-muted);">
            <div style="font-size:3rem;margin-bottom:1rem;">&#128269;</div>
            <h2 style="color:var(--primary);margin-bottom:1rem;">Project not found</h2>
            <p>This project may have been unpublished or removed.</p>
            <a href="<?php echo SITE_URL; ?>/projects.php" class="p-btn p-btn-primary" style="margin-top:1.5rem;">Back
                to Gallery</a>
        </div>
    </div>
</section>
<?php
    include __DIR__ . '/includes/footer.php';
    exit;
}

$pageTitle = $project['title'] . ' — Project';
include __DIR__ . '/includes/header.php';
?>
<!-- ============================================================
     PROJECT DETAIL
     ============================================================ -->
<section class="p-detail">
    <div class="p-container">
        <div class="p-detail-image">
            <?php if ($project['image']): ?>
            <img src="<?php echo SITE_URL; ?>/uploads/<?php echo h($project['image']); ?>"
                alt="<?php echo h($project['title']); ?>">
            <?php else: ?>
            &#128187;
            <?php endif; ?>
        </div>

        <div class="p-detail-category"><?php echo h($project['category']); ?></div>
        <h1><?php echo h($project['title']); ?></h1>

        <div class="p-detail-desc">
            <?php echo $project['full_desc']; ?>
        </div>

        <div class="p-detail-actions">
            <?php if (!empty($project['url'])): ?>
            <a href="<?php echo h($project['url']); ?>" target="_blank" rel="noopener noreferrer"
                class="p-btn p-btn-accent">&#128279; Click here to visit this webpage &rarr;</a>
            <?php else: ?>
            <span class="p-coming-soon">&#9203; Coming Soon — Live URL not yet available</span>
            <?php endif; ?>
            <a href="javascript:void(0)" onclick="window.closeProjectModal();return false;"
                class="p-btn p-btn-outline">Close</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>