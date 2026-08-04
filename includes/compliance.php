<?php

/**
 * ============================================================
 * Policy as Code - Compliance Engine
 * Njenga Sam Portfolio
 * ============================================================
 *
 * This engine is the single source of truth for compliance.
 * It reads the machine-readable policy files in /policies and
 * enforces the runtime controls they declare (e.g. security
 * headers, session hardening, CSP).
 *
 * Usage (at top of every entry point, AFTER config.php):
 *   require_once __DIR__ . '/compliance.php';
 *   enforceCompliance();           // sends headers
 *   $posture = getCompliancePosture(); // for dashboards
 *
 * Policy files are YAML. A lightweight parser reads the flat
 * key/value pairs needed at runtime; the full YAML is retained
 * for review/audit. No external YAML library is required.
 * ============================================================
 */

require_once __DIR__ . '/config.php';

/**
 * Load a policy file and return the parsed flat controls.
 * Falls back to a bundled default if the file is missing.
 */
function loadPolicy(string $file): array
{
    $path = dirname(__DIR__) . '/policies/' . $file;
    $parsed = [];
    if (is_file($path)) {
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            // Skip comments, blank lines, YAML structure markers
            if ($line === '' || str_starts_with($line, '#') || str_starts_with($line, '---')) {
                continue;
            }
            // Capture flat key: value pairs (skip nested lists/objects)
            if (preg_match('/^([a-zA-Z0-9_]+):\s*(.*)$/', $line, $m)) {
                $key = $m[1];
                $value = trim($m[2], "\"'");
                if ($value !== '' && !str_starts_with($value, '-') && !str_starts_with($value, '[')) {
                    $parsed[$key] = $value;
                }
            }
        }
    }
    return $parsed;
}

/**
 * Enforce the security controls declared in the security policy.
 * Sends security headers, sets CSP, and applies session hardening.
 */
function enforceCompliance(): void
{
    $sec = loadPolicy('security.policy.yaml');

    // --- Security response headers ---
    $headers = [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options'         => 'SAMEORIGIN',
        'Referrer-Policy'         => 'no-referrer-when-downgrade',
        'X-XSS-Protection'        => '1; mode=block',
        'Permissions-Policy'      => 'camera=(), microphone=(), geolocation=()',
        'Content-Security-Policy' => "default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' https://unpkg.com; font-src 'self' data:; frame-ancestors 'self'",
    ];

    if (($sec['hsts_enabled'] ?? 'false') === 'true') {
        $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains';
    }

    foreach ($headers as $name => $value) {
        if (!headers_sent()) {
            header($name . ': ' . $value, true);
        }
    }

    // --- Session hardening (mirrors config.php) ---
    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'httponly' => true,
            'secure'   => (($sec['cookie_secure'] ?? 'false') === 'true'),
            'samesite' => 'Strict',
        ]);
        session_start();
    }
}

/**
 * Return the compliance posture across all policy domains.
 * Produces a normalized array suitable for a compliance dashboard.
 */
function getCompliancePosture(): array
{
    $domains = [
        'security'          => 'security.policy.yaml',
        'privacy'           => 'privacy.policy.yaml',
        'accessibility'     => 'accessibility.policy.yaml',
        'deployment'        => 'deployment.policy.yaml',
        'backup'            => 'backup.policy.yaml',
        'incident-response' => 'incident-response.policy.yaml',
    ];

    $posture = [];
    foreach ($domains as $domain => $file) {
        $policy = loadPolicy($file);
        $posture[$domain] = [
            'file'       => $file,
            'loaded'     => !empty($policy),
            'version'    => $policy['version'] ?? 'unknown',
            'framework'  => $policy['complianceFrameworks'] ?? '',
            'enforced'   => ($policy['enforced'] ?? 'false') === 'true',
            'verified'   => $policy['verified'] ?? 'unknown',
            'controls'   => count($policy),
            'status'     => !empty($policy) ? 'compliant' : 'missing',
        ];
    }

    return $posture;
}

/**
 * Enforce redirect to HTTPS when the transport policy requires it.
 * Call before any output when running in production.
 */
function enforceHttpsRedirect(): void
{
    $sec = loadPolicy('security.policy.yaml');
    if (($sec['force_https_redirect'] ?? 'false') === 'true' && empty($_SERVER['HTTPS'])) {
        $redirect = 'https://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ($_SERVER['REQUEST_URI'] ?? '/');
        header('Location: ' . $redirect, true, 301);
        exit;
    }
}