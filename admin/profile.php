<?php

/**
 * Njenga Sam Portfolio - Admin Profile & Password
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$db = getDB();
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($new && $new !== $confirm) {
        $message = 'New passwords do not match.';
        $messageType = 'error';
    } elseif (strlen($new) > 0 && strlen($new) < 6) {
        $message = 'New password must be at least 6 characters.';
        $messageType = 'error';
    } elseif ($new) {
        $stmt = $db->prepare("SELECT password_hash FROM admin_users WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $hash = $stmt->fetchColumn();

        if ($hash && password_verify($current, $hash)) {
            $newHash = password_hash($new, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
            $stmt->execute([$newHash, $_SESSION['admin_id']]);
            $message = 'Password updated successfully.';
            $messageType = 'success';
        } else {
            $message = 'Current password is incorrect.';
            $messageType = 'error';
        }
    }
}

$activePage = 'profile';
$activeTitle = 'Profile';
include __DIR__ . '/partials/header.php';
?>

<div class="admin-header">
    <h1>Profile Settings</h1>
</div>

<?php if ($message): ?>
<div class="alert alert-<?php echo $messageType; ?>"><?php echo h($message); ?></div>
<?php endif; ?>

<div class="form-container">
    <h3 style="margin-bottom:1rem;">Profile Information</h3>
    <div
        style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;padding:1rem;background:var(--primary-light);border-radius:12px;">
        <img src="<?php echo SITE_URL; ?>/images/me.jpg" alt=""
            style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:2px solid var(--accent);">
        <div>
            <strong><?php echo h($_SESSION['admin_username']); ?></strong>
            <div style="color:var(--muted);font-size:0.85rem;">Administrator</div>
        </div>
    </div>

    <h3 style="margin-bottom:1rem;">Change Password</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required
                autocomplete="current-password">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required minlength="6"
                    autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required
                    minlength="6" autocomplete="new-password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
</content>