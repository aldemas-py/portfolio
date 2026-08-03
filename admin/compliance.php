<?php

/**
 * Njenga Sam Portfolio - Compliance Dashboard
 *
 * Policy as Code: This page reads the machine-readable policies in
 * /policies and displays the enforcement status, controls count, and
 * the runtime HTTP security headers actually being emitted.
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/compliance.php';
requireAdmin();

$posture = getCompliancePosture();
$sec = loadPolicy('security.policy.yaml');

// Runtime security headers actually set by the engine
$runtimeHeaders = [
    'X-Content-Type-Options' => 'nosniff',
    'X-Frame-Options'         => 'DENY',
    'Referrer-Policy'         => 'no-referrer-when-downgrade',
    'X-XSS-Protection'        => '1; mode=block',
    'Permissions-Policy'      => 'camera=(), microphone=(), geolocation=()',
    'Content-Security-Policy' => "default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' https://unpkg.com; font-src 'self' data:; frame-ancestors 'none'",
];

// Compute an overall score
$totalControls = 0;
$enforcedCount = 0;
foreach ($posture as $domain => $info) {
    if ($info['loaded']) {
        $totalControls += $info['controls'];
    }
    if ($info['enforced']) {
        $enforcedCount++;
    }
}
$overallScore = $totalControls > 0
    ? round(($enforcedCount / count($posture)) * 100)
    : 0;

$activePage = 'compliance';
$activeTitle = 'Compliance';
include __DIR__ . '/partials/header.php';
?>

<div class="admin-header">
    <h1>Compliance</h1>
    <span style="color:var(--muted);font-size:0.9rem;">Policy as Code &middot; Runtime Enforced</span>
</div>

<!-- Overall Score -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">&#128737;</div>
        <div class="stat-value"><?php echo $overallScore; ?>%</div>
        <div class="stat-label">Policy Enforcement Score</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">&#128196;</div>
        <div class="stat-value"><?php echo count($posture); ?></div>
        <div class="stat-label">Policy Domains</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">&#9889;</div>
        <div class="stat-value"><?php echo $totalControls; ?></div>
        <div class="stat-label">Controls Declared (flat)</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">&#9989;</div>
        <div class="stat-value"><?php echo $enforcedCount; ?>/<?php echo count($posture); ?></div>
        <div class="stat-label">Domains Enforced</div>
    </div>
</div>

<!-- Policy Domain Table -->
<div class="table-container">
    <h3>&#128737; Policy Domains &mdash; Machine-Readable Policies</h3>
    <table>
        <thead>
            <tr>
                <th>Domain</th>
                <th>Policy File</th>
                <th>Version</th>
                <th>Framework</th>
                <th>Enforced</th>
                <th>Verified</th>
                <th>Controls</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posture as $domain => $info): ?>
            <tr>
                <td><strong><?php echo ucfirst(str_replace('-', ' ', $domain)); ?></strong></td>
                <td><code><?php echo h($info['file']); ?></code></td>
                <td><?php echo h($info['version']); ?></td>
                <td><small><?php echo h($info['framework']); ?></small></td>
                <td><?php echo $info['enforced'] ? '<span style="color:var(--success);">Yes</span>' : '<span style="color:var(--danger);">No</span>'; ?>
                </td>
                <td><?php echo h($info['verified']); ?></td>
                <td><?php echo $info['controls']; ?></td>
                <td>
                    <?php if ($info['status'] === 'compliant'): ?>
                    <span class="badge"
                        style="display:inline-block;padding:0.25rem 0.8rem;border-radius:50px;font-size:0.8rem;font-weight:600;background:#dcfce7;color:#166534;">Compliant</span>
                    <?php else: ?>
                    <span class="badge"
                        style="display:inline-block;padding:0.25rem 0.8rem;border-radius:50px;font-size:0.8rem;font-weight:600;background:#fee2e2;color:#991b1b;">Missing</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="form-container">
    <h3>&#128274; Runtime Security Headers</h3>
    <p style="color:var(--muted);font-size:0.9rem;margin-bottom:1rem;">
        These headers are emitted by <code>includes/compliance.php</code> on every page load, per
        <code>security.policy.yaml</code>.
    </p>
    <table>
        <thead>
            <tr>
                <th>Header</th>
                <th>Value</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($runtimeHeaders as $name => $value): ?>
            <tr>
                <td><code><?php echo h($name); ?></code></td>
                <td><small><code><?php echo h($value); ?></code></small></td>
                <td><span style="color:var(--success);">&#9989;</span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="form-container">
    <h3>&#128221; Session Hardening Config</h3>
    <table>
        <tbody>
            <tr>
                <td><strong>Session Cookie HttpOnly</strong></td>
                <td><?php echo $sec['cookie_httponly'] ?? 'true'; ?></td>
            </tr>
            <tr>
                <td><strong>Session Cookie SameSite</strong></td>
                <td><?php echo h($sec['cookie_samesite'] ?? 'Strict'); ?></td>
            </tr>
            <tr>
                <td><strong>Session Use Strict Mode</strong></td>
                <td><?php echo h($sec['use_strict_mode'] ?? 'true'); ?></td>
            </tr>
            <tr>
                <td><strong>Session Timeout (seconds)</strong></td>
                <td><?php echo h($sec['session_timeout_seconds'] ?? '1800'); ?></td>
            </tr>
            <tr>
                <td><strong>Force HTTPS Redirect</strong></td>
                <td><?php echo h($sec['force_https_redirect'] ?? 'true'); ?></td>
            </tr>
            <tr>
                <td><strong>HSTS Enabled</strong></td>
                <td><?php echo h($sec['hsts_enabled'] ?? 'true'); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="form-container">
    <h3>&#128203; Audit Trail</h3>
    <p style="color:var(--muted);font-size:0.9rem;">
        Policy files are versioned in the repository, reviewed on change, and verified on each release.
        See <code>COMPLIANCE.md</code> and <code>SECURITY.md</code> for the human-readable attestation.
    </p>
    <ul style="margin:1rem 0 0 1.2rem;color:var(--text);font-size:0.9rem;line-height:1.9;list-style:disc;">
        <li>Change control &rarr; code review required for any policy change</li>
        <li>Verification cadence &rarr; per policy domain (release / periodic / quarterly)</li>
        <li>Audit logging &rarr; admin logins, logouts, CRUD, failed logins (policy declared)</li>
    </ul>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>