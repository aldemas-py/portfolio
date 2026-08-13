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
    <meta http-equiv="refresh" content="2;url=<?php echo htmlspecialchars($redirect); ?>">
    <title>Redirecting...</title>
    <style>
        body { font-family: Arial; margin: 2rem; }
        .debug { background: #f0f0f0; padding: 1rem; margin-top: 1rem; white-space: pre-wrap; font-family: monospace; font-size: 0.9rem; }
    </style>
</head>
<body>
    <h2>Redirecting to <?php echo htmlspecialchars($redirect); ?></h2>
    <p>If not redirected in 2 seconds, <a href="<?php echo htmlspecialchars($redirect); ?>">click here</a>.</p>
    <div class="debug">
        Debug Info:
        - headers_sent(): <?php echo headers_sent() ? 'YES' : 'NO'; ?>
        - Redirect target: <?php echo htmlspecialchars($redirect); ?>
        - Session admin_id: <?php echo isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 'NOT SET'; ?>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = <?php echo json_encode($redirect); ?>;
        }, 500);
    </script>
</body>
</html>
<?php
exit;