<?php

/**
 * Njenga Sam Portfolio - Homepage
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$projects = getProjects();
$testimonials = getTestimonials();
$services = getServices();

$pageTitle = 'Home';
include __DIR__ . '/includes/header.php';
?>
<!-- ============================================================
     HERO / INTRO
     ============================================================ -->
<section class="p-hero">
    <div class="p-container">
        <div class="p-hero-inner">
            <div>
                <!-- h1.sec1 kept as is -->
                <h1 class="sec1">Kabura <span class="p-hero-highlight">Njenga</span></h1>
                <div class="p-hero-cta">
                    <p id="sec2">
                        <strong>Software Engineer &amp; Solutions Architect.</strong><br>
                        I build business-focused digital solutions — web apps, Android applications, API
                        integration, and IT systems support — blending technical precision with a
                        business-minded approach to create solutions, not just products.
                    </p>
                    <div class="imgContainer">
                        <img class="myImg" src="<?php echo SITE_URL; ?>/images/me.jpg"
                            alt="Professional portrait of Kabura Njenga">
                    </div>
                </div>
                <div class="p-hero-actions" style="margin-top:1.8rem;">
                    <a href="<?php echo SITE_URL; ?>/projects.php" class="p-btn p-btn-primary">View My Work</a>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="p-btn p-btn-accent">Let's Talk</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     ABOUT BRIEF
     ============================================================ -->
<section class="p-section">
    <div class="p-container">
        <div class="p-section-header">
            <p class="p-subtitle">Who I Am</p>
            <h2>Engineer. Veteran. Problem-Solver.</h2>
        </div>
        <div class="p-about-card">
            <p>
                I'm <strong>Sam</strong>, a Software Engineer and U.S. Army veteran with over seven years of
                experience designing, developing, and maintaining web and mobile applications. From full-stack
                development and Android apps to API integration, cloud technologies, and technical
                troubleshooting, I bring a proven ability to solve complex problems and deliver dependable
                results in both commercial and mission-critical environments.
            </p>
            <p>
                My mission is to <strong>create solutions, not just products</strong> — combining engineering
                discipline with business insight to build tools that genuinely move the needle.
            </p>
            <div style="margin-top:1.5rem;">
                <a href="<?php echo SITE_URL; ?>/about.php" class="p-btn p-btn-outline">More About Me</a>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     SERVICES
     ============================================================ -->
<section class="p-section"
    style="background:var(--panel);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="p-container">
        <div class="p-section-header">
            <p class="p-subtitle">Our Services</p>
            <h2>What I Can Do For You</h2>
            <p>End-to-end digital solutions — from first sketch to deployed, maintainable systems.</p>
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

        <div style="text-align:center;margin-top:2.5rem;">
            <a href="<?php echo SITE_URL; ?>/services.php" class="p-btn p-btn-primary">View All Services</a>
        </div>
    </div>
</section>

<!-- ============================================================
     RECENT WORKS / PROJECT GALLERY (scrollable, 3x2 visible)
     ============================================================ -->
<section class="p-section p-projects-section">
    <div class="p-container">
        <div class="p-section-header">
            <p class="p-subtitle">Project Gallery</p>
            <h2>Recent Works</h2>
            <p>Click any project to preview its details. Scroll inside the gallery to explore more.</p>
        </div>

        <?php if (count($projects) > 0): ?>
        <div class="p-recent-works">
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
            <p>Projects coming soon. Check back shortly!</p>
        </div>
        <?php endif; ?>

        <div style="text-align:center;margin-top:2rem;">
            <a href="<?php echo SITE_URL; ?>/projects.php" class="p-btn p-btn-primary">View Full Gallery</a>
        </div>
    </div>
</section>

<!-- ============================================================
     TESTIMONIALS
     ============================================================ -->
<section class="p-section p-testimonials-section">
    <div class="p-container">
        <div class="p-section-header">
            <p class="p-subtitle">Testimonials</p>
            <h2>What Clients Say</h2>
        </div>

        <?php if (count($testimonials) > 0): ?>
        <div class="p-testimonials-grid">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="p-testimonial-card">
                <div class="p-testimonial-stars">
                    <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>&#9733;<?php endfor; ?>
                </div>
                <div class="p-testimonial-content">"<?php echo h($testimonial['content']); ?>"</div>
                <div class="p-testimonial-author">
                    <?php $tImage = testimonialImage($testimonial['image'] ?? ''); ?>
                    <?php if ($tImage): ?>
                    <div class="p-testimonial-avatar">
                        <img src="<?php echo h($tImage); ?>" alt="<?php echo h($testimonial['client_name']); ?>"
                            style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                    </div>
                    <?php else: ?>
                    <div class="p-testimonial-avatar">
                        <?php echo strtoupper(substr($testimonial['client_name'], 0, 1)); ?>
                    </div>
                    <?php endif; ?>
                    <div>
                        <h4><?php echo h($testimonial['client_name']); ?></h4>
                        <span><?php echo h($testimonial['client_role'] ?? 'Client'); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <p style="text-align:center;color:var(--text-muted);">Testimonials coming soon.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================================
     CTA: CONTACT
     ============================================================ -->
<section class="p-section p-contact-section">
    <div class="p-container">
        <div style="text-align:center;max-width:620px;margin:0 auto;">
            <h2 style="font-size:2rem;margin-bottom:1rem;">Open to Collaboration</h2>
            <p style="color:var(--text-muted);font-size:1.1rem;margin-bottom:2rem;">
                Whether you have a project in mind, a system that needs fixing, or an idea that needs to be
                built — let's talk.
            </p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo SITE_URL; ?>/contact.php" class="p-btn p-btn-primary">Get in Touch</a>
                <a href="mailto:leumaskabura@gmail.com" class="p-btn p-btn-accent">Email Me Directly</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>