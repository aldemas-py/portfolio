<?php

/**
 * Njenga Sam Portfolio - Admin root
 * Redirects to the login page if not authenticated, otherwise to the dashboard.
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();

$redirect = null;
if (isset($_SESSION['admin_id'])) {
    $redirect = '/admin/dashboard.php';
} else {
    $redirect = '/admin/login.php';
}

// Try header redirect first
if (!headers_sent()) {
    header('Location: ' . $redirect);
    exit;
}

// Fallback: use JavaScript + meta refresh if headers already sent
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0;url=<?php echo htmlspecialchars($redirect); ?>">
    <title>Redirecting...</title>
</head>
<body>
    <p>Redirecting...</p>
    <script>
        window.location.href = <?php echo json_encode($redirect); ?>;
    </script>
</body>
</html>
<?php
exit;