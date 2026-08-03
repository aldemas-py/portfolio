<?php

/**
 * Njenga Sam Portfolio - Public Site Header
 * Visible navbar + Policy-as-Code enforcement
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/compliance.php';

// Policy as Code: enforce security headers & session hardening
enforceCompliance();

// Get current page for active nav highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="<?php echo SITE_NAME; ?> — Software Engineer & Solutions Architect. Web apps, Android, APIs, IT systems support, and business-focused digital solutions.">
    <meta name="keywords"
        content="Samuel Kabura, Njenga Sam, software engineer, full-stack developer, Android developer, web developer, Nairobi, Kenya">
    <meta name="author" content="<?php echo SITE_NAME; ?>">
    <title>
        <?php echo isset($pageTitle) ? h($pageTitle) . ' | ' . SITE_NAME : SITE_NAME . ' | Software Engineer & Solutions Architect'; ?>
    </title>

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/portfolio.css">
    <link rel="icon" href="<?php echo SITE_URL; ?>/images/me.jpg">
</head>

<body>

    <!-- ============================================================
         NAVBAR
         ============================================================ -->
    <nav class="p-navbar">
        <div class="p-container">
            <a href="<?php echo SITE_URL; ?>/index.php" class="p-brand">
                <img src="<?php echo SITE_URL; ?>/images/me.jpg" alt="<?php echo SITE_NAME; ?> logo">
                <span>Njenga<span class="p-brand-accent">Sam</span></span>
            </a>

            <button class="p-nav-toggle" aria-label="Toggle navigation menu">
                <span></span><span></span><span></span>
            </button>

            <div class="p-nav-links">
                <a href="<?php echo SITE_URL; ?>/index.php"
                    class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a>
                <a href="<?php echo SITE_URL; ?>/about.php"
                    class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a>
                <a href="<?php echo SITE_URL; ?>/services.php"
                    class="<?php echo $current_page == 'services.php' ? 'active' : ''; ?>">Our Services</a>
                <a href="<?php echo SITE_URL; ?>/projects.php"
                    class="<?php echo $current_page == 'projects.php' || $current_page == 'project.php' ? 'active' : ''; ?>">Project
                    Gallery</a>
                <a href="<?php echo SITE_URL; ?>/contact.php"
                    class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact Us</a>
                <a href="<?php echo SITE_URL; ?>/compliance.php"
                    class="<?php echo $current_page == 'compliance.php' ? 'active' : ''; ?>">Compliance</a>
            </div>
        </div>
    </nav>