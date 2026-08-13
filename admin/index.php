<?php

/**
 * Njenga Sam Portfolio - Admin root
 * Redirects to the login page if not authenticated, otherwise to the dashboard.
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();

if (isset($_SESSION['admin_id'])) {
    header('Location: /admin/dashboard.php');
    exit;
}

header('Location: /admin/login.php');
exit;