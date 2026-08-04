</main>
</div>

<!-- ============================================================
             ADMIN SESSION IDLE AUTO-LOGOUT
             Logs the admin out after 5 minutes of inactivity (per
             security.policy.yaml session_timeout_seconds = 1800).
             Browser-close sessions are enforced server-side via
             cookie_lifetime = 0 (see includes/config.php).
             ============================================================ -->
<script>
(function() {
    var SESSION_TIMEOUT =
        <?php echo defined('SESSION_TIMEOUT') ? (SESSION_TIMEOUT * 1000) : 1800000; ?>; // matches PHP SESSION_TIMEOUT
    var logoutUrl = '<?php echo SITE_URL; ?>/admin/logout.php?expired=1';
    var idleTimer = null;

    function resetIdleTimer() {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(function() {
            window.location.href = logoutUrl;
        }, SESSION_TIMEOUT);
    }

    // Reset timer on any user activity
    var events = ['click', 'mousemove', 'keydown', 'scroll', 'touchstart', 'mousedown'];
    for (var i = 0; i < events.length; i++) {
        document.addEventListener(events[i], resetIdleTimer);
    }

    // Start the idle timer on page load
    resetIdleTimer();
})();
</script>
</body>

</html>