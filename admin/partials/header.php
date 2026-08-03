<?php

/**
 * Admin Shared Header - outputs the sidebar layout open plus sidebar nav
 * Expects: $activePage (string), $activeTitle (string)
 */
require_once __DIR__ . '/../../includes/compliance.php';

// Policy as Code: enforce security headers on every admin page
enforceCompliance();

$activePage = $activePage ?? '';
$activeTitle = $activeTitle ?? 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($activeTitle); ?> - Admin | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/admin.css">
</head>

<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <h3>Admin Panel</h3>
            <a href="<?php echo SITE_URL; ?>/admin/dashboard.php"
                class="<?php echo $activePage === 'dashboard' ? 'active' : ''; ?>">&#9632; Dashboard</a>
            <a href="<?php echo SITE_URL; ?>/admin/manage_projects.php"
                class="<?php echo $activePage === 'projects' ? 'active' : ''; ?>">&#128187; Projects</a>
            <a href="<?php echo SITE_URL; ?>/admin/manage_testimonials.php"
                class="<?php echo $activePage === 'testimonials' ? 'active' : ''; ?>">&#9733; Testimonials</a>
            <a href="<?php echo SITE_URL; ?>/admin/messages.php"
                class="<?php echo $activePage === 'messages' ? 'active' : ''; ?>">&#9993; Messages</a>
            <a href="<?php echo SITE_URL; ?>/admin/profile.php"
                class="<?php echo $activePage === 'profile' ? 'active' : ''; ?>">&#128100; Profile</a>
            <a href="<?php echo SITE_URL; ?>/admin/compliance.php"
                class="<?php echo $activePage === 'compliance' ? 'active' : ''; ?>">&#128737; Compliance</a>
            <hr style="border-color:rgba(255,255,255,0.12);margin:1.5rem 0;">
            <a href="<?php echo SITE_URL; ?>/index.php">&#8592; View Site</a>
            <a href="<?php echo SITE_URL; ?>/admin/logout.php">&#128682; Logout</a>
        </aside>
        <main class="admin-content">
            </content>