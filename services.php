<?php

/**
 * Njenga Sam Portfolio - Services Page
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$services = getServices();
$pageTitle = 'Our Services';
include __DIR__ . '/includes/header.php';
?>
<!-- ============================================================
     PAGE BANNER
     ============================================================ -->
<section class="p-page-banner">
    <div class="p-container">
        <h1>Our <span class="p-banner-accent">Services</span></h1>
        <p>End-to-end digital solutions built with engineering discipline and a business-first mindset.</p>
    </div>
</section>

<!-- ============================================================
     SERVICES GRID
     ============================================================ -->
<section class="p-section">
    <div class="p-container">
        <div class="p-section-header">
            <p class="p-subtitle">What I Offer</p>
            <h2>Solutions Designed to Move the Needle</h2>
            <p>From concept to deployment — I build tools that solve real business problems, not just pretty
                interfaces.</p>
        </div>

        <div class="p-services-grid">
            <?php foreach ($services as $service): ?>
            <div class="p-service-card">
                <div class="p-service-icon" style="color:<?php echo $service['color']; ?>;">
                    <?php echo $service['icon']; ?></div>
                <h3><?php echo h($service['title']); ?></h3>
                <p><?php echo h($service['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     HOW I WORK / PROCESS
     ============================================================ -->
<section class="p-section"
    style="background:var(--panel);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="p-container">
        <div class="p-section-header">
            <p class="p-subtitle">Process</p>
            <h2>How I Deliver</h2>
        </div>

        <div class="p-services-grid">
            <div class="p-service-card">
                <div class="p-service-icon" style="color:var(--primary);">1</div>
                <h3>Discover</h3>
                <p>We discuss your goals, requirements, and the business problem you're solving. I ask the right
                    questions before writing any code.</p>
            </div>
            <div class="p-service-card">
                <div class="p-service-icon" style="color:var(--primary);">2</div>
                <h3>Architect</h3>
                <p>System architecture thinking — I design the right structure for scalable delivery, choosing the
                    right tech stack for the job.</p>
            </div>
            <div class="p-service-card">
                <div class="p-service-icon" style="color:var(--primary);">3</div>
                <h3>Build</h3>
                <p>Clean, maintainable code with regular check-ins. Git-based workflows, documentation, and clear
                    communication throughout.</p>
            </div>
            <div class="p-service-card">
                <div class="p-service-icon" style="color:var(--primary);">4</div>
                <h3>Deploy</h3>
                <p>Structured deployment with policy-gated pipelines, security headers, and compliance checks baked in
                    at every release.</p>
            </div>
            <div class="p-service-card">
                <div class="p-service-icon" style="color:var(--primary);">5</div>
                <h3>Support</h3>
                <p>Production support, technical troubleshooting, and ongoing improvements to keep your systems
                    reliable and your business moving.</p>
            </div>
            <div class="p-service-card">
                <div class="p-service-icon" style="color:var(--primary);">6</div>
                <h3>Optimize</h3>
                <p>Analytics, dashboards, and data-driven iteration to continuously improve performance, usability,
                    and business outcomes.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     CTA
     ============================================================ -->
<section class="p-section">
    <div class="p-container">
        <div style="text-align:center;max-width:600px;margin:0 auto;">
            <h2 style="font-size:1.9rem;margin-bottom:1rem;">Ready to Build Something?</h2>
            <p style="color:var(--text-muted);margin-bottom:2rem;">Let's turn your idea into a solution that works for
                your business.</p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo SITE_URL; ?>/contact.php" class="p-btn p-btn-primary">Start a Project</a>
                <a href="<?php echo SITE_URL; ?>/projects.php" class="p-btn p-btn-outline">See My Work</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>