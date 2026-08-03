<?php

/**
 * Njenga Sam Portfolio - Configuration
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Site configuration
define('SITE_NAME', 'Njenga Sam');
define('SITE_TAGLINE', 'Software Engineer | Full-Stack Developer | Solutions Architect');

// Auto-detect base URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? '127.0.0.1';
$docRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$scriptDir = str_replace('\\', '/', __DIR__);
$relativePath = str_replace($docRoot, '', $scriptDir);
$basePath = dirname($relativePath);
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
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'httponly' => true,
            'secure' => false,
            'samesite' => 'Strict'
        ]);
        session_start();
    }
}