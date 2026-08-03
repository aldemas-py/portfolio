<?php

/**
 * Njenga Sam Portfolio - Public Compliance Posture Page
 *
 * Policy as Code: demonstrates the site's machine-readable compliance
 * posture to the public. Reads the same policy files used by the
 * admin compliance dashboard.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/compliance.php';

enforceCompliance();

$posture = getCompliancePosture();
$total = count($posture);
$compliant = 0;
foreach ($posture as $info) {
    if ($info['status'] === 'compliant') {
        $compliant++;
    }
}
$score = $total > 0 ? round(($compliant / $total) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Compliance posture for Njenga Sam portfolio — Policy as Code, security headers, privacy, accessibility, deployment, backup and incident response policies.">
    <title>Compliance | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/styless.css">
    <style>
    /* Public compliance page styles (complementary blue + warm amber) */
    .compliance-wrap {
        width: 95%;
        max-width: 1100px;
        margin: 3rem auto;
        text-align: center;
    }

    .compliance-badge {
        display: inline-block;
        padding: 0.4rem 1.2rem;
        border-radius: 50px;
        background: #F59E0B;
        color: #172033;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        margin-bottom: 1rem;
    }

    .compliance-wrap h1 {
        font-size: 2.2rem;
        color: #2839D2;
        margin-bottom: 0.5rem;
    }

    .compliance-sub {
        color: #64748B;
        max-width: 640px;
        margin: 0 auto 2rem;
        line-height: 1.7;
    }

    .score-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 2.5rem;
    }

    .score-card {
        background: #fff;
        border: 1px solid #DCE5F5;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
    }

    .score-value {
        font-size: 2.4rem;
        font-weight: 800;
        color: #2839D2;
    }

    .score-label {
        color: #64748B;
        font-size: 0.85rem;
        margin-top: 0.3rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .policy-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.25rem;
        text-align: left;
    }

    .policy-card {
        background: #fff;
        border: 1px solid #DCE5F5;
        border-radius: 14px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .policy-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.1);
    }

    .policy-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .policy-head h3 {
        color: #172033;
        font-size: 1.05rem;
    }

    .policy-status {
        padding: 0.25rem 0.7rem;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .policy-status.ok {
        background: #dcfce7;
        color: #166534;
    }

    .policy-status.missing {
        background: #fee2e2;
        color: #991b1b;
    }

    .policy-meta {
        color: #64748B;
        font-size: 0.82rem;
        line-height: 1.5;
    }

    .policy-meta code {
        background: #EFF4FF;
        color: #2839D2;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        font-size: 0.75rem;
    }

    .policy-file {
        margin-top: auto;
        font-size: 0.75rem;
        color: #94a3b8;
    }

    @media (max-width: 768px) {
        .score-grid {
            grid-template-columns: 1fr 1fr;
        }

        .compliance-wrap h1 {
            font-size: 1.7rem;
        }
    }

    @media (max-width: 480px) {
        .score-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>
    <div class="compliance-wrap">
        <span class="compliance-badge">&#128737; Policy as Code</span>
        <h1>Compliance &amp; Trust</h1>
        <p class="compliance-sub">
            This site's security, privacy, accessibility, deployment, backup and incident-response controls are
            declared as versioned, machine-readable policies. The controls below are enforced at runtime — not
            aspirational.
        </p>

        <div class="score-grid">
            <div class="score-card">
                <div class="score-value"><?php echo $score; ?>%</div>
                <div class="score-label">Compliance Score</div>
            </div>
            <div class="score-card">
                <div class="score-value"><?php echo $compliant; ?>/<?php echo $total; ?></div>
                <div class="score-label">Policies Active</div>
            </div>
            <div class="score-card">
                <div class="score-value">6</div>
                <div class="score-label">Security Headers</div>
            </div>
        </div>

        <div class="policy-grid">
            <?php
            $labels = [
                'security'          => '&#128274; Security',
                'privacy'           => '&#128100; Privacy',
                'accessibility'     => '&#9855; Accessibility',
                'deployment'        => '&#128640; Deployment',
                'backup'            => '&#128421; Backup &amp; DR',
                'incident-response' => '&#128161; Incident Response',
            ];
            foreach ($posture as $domain => $info):
            ?>
            <div class="policy-card">
                <div class="policy-head">
                    <h3><?php echo $labels[$domain] ?? ucfirst(str_replace('-', ' ', $domain)); ?></h3>
                    <span
                        class="policy-status <?php echo $info['status'] === 'compliant' ? 'ok' : 'missing'; ?>"><?php echo $info['status'] === 'compliant' ? 'Active' : 'Missing'; ?></span>
                </div>
                <div class="policy-meta">
                    <strong>Version:</strong> <code><?php echo h($info['version']); ?></code><br>
                    <strong>Framework:</strong> <?php echo h($info['framework'] ?: 'n/a'); ?><br>
                    <strong>Enforced:</strong> <?php echo $info['enforced'] ? 'Yes' : 'No'; ?> &middot;
                    <strong>Verified:</strong> <?php echo h($info['verified']); ?>
                </div>
                <div class="policy-file">&#128196; <?php echo h($info['file']); ?> &middot;
                    <?php echo $info['controls']; ?>
                    CLI controls</div>
            </div>
            <?php endforeach; ?>
        </div>

        <p style="margin-top:2.5rem;color:#64748B;font-size:0.85rem;">
            Human-readable records: <a href="SECURITY.md" style="color:#2839D2;">SECURITY.md</a> &middot;
            <a href="COMPLIANCE.md" style="color:#2839D2;">COMPLIANCE.md</a>
        </p>
    </div>
</body>

</html>