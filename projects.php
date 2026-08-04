<?php

/**
 * Njenga Sam Portfolio - Project Gallery Page
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$projects = getProjects();
$pageTitle = 'Project Gallery';
include __DIR__ . '/includes/header.php';
?>
<!-- ============================================================
     PAGE BANNER
     ============================================================ -->
<section class="p-page-banner">
    <div class="p-container">
        <h1>Project <span class="p-banner-accent">Gallery</span></h1>
        <p>Browse my recent work. Click any project to preview its details — then visit the live site.</p>
    </div>
</section>

<!-- ============================================================
     PROJECTS GRID (same iframe-modal behavior as homepage)
     ============================================================ -->
<section class="p-section">
    <div class="p-container">
        <?php if (count($projects) > 0): ?>
        <div class="p-recent-works" style="max-width:100%;max-height:none;">
            <?php foreach ($projects as $project): ?>
            <div class="p-project-card"
                data-project-url="<?php echo SITE_URL; ?>/project.php?slug=<?php echo h($project['slug']); ?>">
                <div class="p-project-thumb">
                    <?php $imgSrc = projectImage($project['image']); ?>
                    <?php if ($imgSrc): ?>
                    <img src="<?php echo h($imgSrc); ?>" alt="<?php echo h($project['title']); ?>" loading="lazy">
                    <?php else: ?>
                    &#128187;
                    <?php endif; ?>
                </div>
                <div class="p-project-body">
                    <div class="p-project-category"><?php echo h($project['category']); ?></div>
                    <h3><?php echo h($project['title']); ?></h3>
                    <p><?php echo h(truncateText($project['short_desc'] ?? $project['full_desc'], 110)); ?></p>
                    <span class="p-project-hint">&#128270; Click to preview &rarr;</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div style="text-align:center;color:var(--text-muted);padding:2rem;">
            <p>No projects yet. Check back soon!</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>