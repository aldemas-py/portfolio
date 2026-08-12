<?php

/**
 * Njenga Sam Portfolio - Configuration
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'njengas2_portfolio_db');
define('DB_USER', 'njengas2_njenga');
define('DB_PASS', '4t]3oyUN;Y52lE');
define('DB_CHARSET', 'utf8mb4');

// Site configuration
define('SITE_NAME', 'Njenga Sam');
define('SITE_TAGLINE', 'Software Engineer | Full-Stack Developer | Solutions Architect');

// Auto-detect base URL and HTTPS behind proxies / load balancers.
$isSecureRequest = (
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string)$_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
    || (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower((string)$_SERVER['HTTP_X_FORWARDED_SSL']) === 'on')
    || (!empty($_SERVER['REQUEST_SCHEME']) && strtolower((string)$_SERVER['REQUEST_SCHEME']) === 'https')
);
$protocol = $isSecureRequest ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? '127.0.0.1';
$docRoot = rtrim(str_replace('\\', '/', (string)($_SERVER['DOCUMENT_ROOT'] ?? '')), '/');
$scriptDir = rtrim(str_replace('\\', '/', __DIR__), '/');

if ($docRoot !== '' && strpos($scriptDir . '/', $docRoot . '/') === 0) {
    // Script lives inside the document root -> compute the URL sub-path.
    $relativePath = substr($scriptDir, strlen($docRoot));
    $basePath = rtrim(str_replace('\\', '/', dirname($relativePath)), '/');
} else {
    // DOCUMENT_ROOT unavailable (e.g. CLI) — infer from the htdocs layout.
    $htdocsPos = stripos($scriptDir, '/htdocs/');
    if ($htdocsPos !== false) {
        $afterHtdocs = substr($scriptDir, $htdocsPos + strlen('/htdocs'));
        $basePath = rtrim(str_replace('\\', '/', dirname($afterHtdocs)), '/');
    } else {
        $basePath = '';
    }
}
define('IS_HTTPS_REQUEST', $isSecureRequest);
define('SITE_URL', $protocol . '://' . $host . $basePath);
define('ADMIN_EMAIL', 'leumaskabura@gmail.com');

// Session config
define('SESSION_TIMEOUT', 1800);

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_lifetime', 0);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.gc_maxlifetime', 1800);

/**
 * Get PDO database connection
 */
function getDB()
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    return $pdo;
}

/**
 * Start session if not already started
 */
function startSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        // Unique session name to isolate this project's sessions from other
        // projects on the same server (prevents cross-project session sharing).
        session_name('PORTFOLIO_SESSION');
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'httponly' => true,
            'secure' => IS_HTTPS_REQUEST,
            'samesite' => 'Strict'
        ]);
        session_start();
    }
}