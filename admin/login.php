<?php

/**
 * Njenga Sam Portfolio - Admin Login
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/compliance.php';

// Policy as Code: enforce security headers + HSTS/CSP per security.policy.yaml
enforceCompliance();

startSession();

$error = '';
$notice = '';

if (isset($_GET['expired']) && $_GET['expired'] == 1) {
    $notice = 'Your session has expired due to inactivity. Please log in again.';
} elseif (isset($_SESSION['logout_message'])) {
    $notice = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']);
}

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: ' . SITE_URL . '/admin/dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Reset rate-limit counters on success
            unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);

            session_regenerate_id(true);
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['last_activity'] = time();

            header('Location: ' . SITE_URL . '/admin/dashboard.php');
            exit;
        } else {
            // Policy as Code: increment failed-attempt counter (rateLimiting: 5 / 300s)
            $_SESSION['login_attempts'] = (int)($_SESSION['login_attempts'] ?? 0) + 1;
            if ($_SESSION['login_attempts'] >= 5) {
                $_SESSION['login_locked_until'] = time() + 300;
                $error = 'Too many failed attempts. Account locked for 5 minutes.';
            } else {
                $remaining = 5 - $_SESSION['login_attempts'];
                $error = 'Invalid username or password. ' . $remaining . ' attempt(s) remaining before lockout.';
            }
        }
    } else {
        $error = 'Please enter username and password.';
    }
}

// Policy as Code: enforce lockout before processing further attempts
if (isset($_SESSION['login_locked_until']) && $_SESSION['login_locked_until'] > time()) {
    $error = 'Too many failed attempts. Try again in ' . ceil(($_SESSION['login_locked_until'] - time()) / 60) . ' min.';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/admin.css">
</head>

<body class="login-body">
    <div class="login-container">
        <div class="login-logo">
            <img src="<?php echo SITE_URL; ?>/images/me.jpg" alt="Logo">
            <h1>Njenga Sam</h1>
            <p>Portfolio Admin Panel</p>
        </div>

        <?php if ($notice): ?>
        <div class="alert alert-warning"><?php echo h($notice); ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
        <div class="alert alert-error"><?php echo h($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required
                    autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </form>

        <a href="<?php echo SITE_URL; ?>/index.php" class="back-link">&larr; Back to Website</a>
    </div>
</body>

</html>
</content>