<?php

/**
 * Njenga Sam Portfolio - About Page
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'About';
include __DIR__ . '/includes/header.php';
?>
<!-- ============================================================
     PAGE BANNER
     ============================================================ -->
<section class="p-page-banner">
    <div class="p-container">
        <h1>About <span class="p-banner-accent">Me</span></h1>
        <p>Engineer with a business background and a talent for creating solutions — not just products.</p>
    </div>
</section>

<!-- ============================================================
     PROFILE
     ============================================================ -->
<section class="p-section">
    <div class="p-container">
        <div class="p-about-card">
            <div class="imgContainer" style="margin-bottom:1.5rem;">
                <img class="myImg" src="<?php echo SITE_URL; ?>/images/me.jpg"
                    alt="Professional portrait of Kabura Njenga">
            </div>
            <h2 style="color:var(--primary);font-size:1.8rem;margin-bottom:1rem;">Kabura Njenga</h2>
            <p style="color:var(--accent-dark);font-weight:700;margin-bottom:1.5rem;">Software Engineer & Solutions
                Architect</p>
            <p>
                I'm a software developer and U.S. Army Health Care Specialist with experience supporting business
                and technical operations, troubleshooting systems, and developing web and mobile applications in
                high-pressure environments. I'm skilled in <strong>Python, JavaScript, React.js, PHP, Android
                    development, REST APIs, and system troubleshooting</strong> — combining engineering discipline with
                strong operational awareness.
            </p>
            <p>
                I work independently with autonomy, resolve technical issues, support users, and improve workflows
                in mission-critical and customer-facing environments. My strong interest in <strong>IT
                    infrastructure, network administration, system architecture, and business software</strong> drives
                architectural decision-making for scalable delivery.
            </p>
            <p>
                My professional journey spans freelance software development, Android development at Dimite
                Technologies, and a software maintenance internship — all grounded in a commitment to building
                reliable, maintainable solutions that support real business operations.
            </p>
        </div>
    </div>
</section>

<!-- ============================================================
     VALUES / SKILLS
     ============================================================ -->
<section class="p-section"
    style="background:var(--panel);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="p-container">
        <div class="p-section-header">
            <p class="p-subtitle">Core Strengths</p>
            <h2>What I Bring to the Table</h2>
        </div>

        <div class="p-services-grid">
            <div class="p-service-card">
                <div class="p-service-icon">&#128295;</div>
                <h3>Operational Excellence</h3>
                <p>Structured troubleshooting, incident-response practices, and rapid decision-making refined in
                    high-pressure clinical and technical environments.</p>
            </div>
            <div class="p-service-card">
                <div class="p-service-icon">&#128736;</div>
                <h3>Systems Thinking</h3>
                <p>System architecture thinking that aligns troubleshooting, documentation, and escalation paths for
                    clean, reliable outcomes.</p>
            </div>
            <div class="p-service-card">
                <div class="p-service-icon">&#128200;</div>
                <h3>Business-Minded</h3>
                <p>Data-driven reporting, workflow improvement, and analytics that strengthen business continuity and
                    operational decision-making.</p>
            </div>
            <div class="p-service-card">
                <div class="p-service-icon">&#129309;</div>
                <h3>Cross-Functional Communication</h3>
                <p>Clear communication between technical teams, leadership, and clients — turning requirements into
                    maintainable features.</p>
            </div>
            <div class="p-service-card">
                <div class="p-service-icon">&#128187;</div>
                <h3>Full-Stack Delivery</h3>
                <p>Responsive UI design, API integration, debugging, and clean code review practices for stable
                    business product growth.</p>
            </div>
            <div class="p-service-card">
                <div class="p-service-icon">&#128476;</div>
                <h3>Security & Compliance</h3>
                <p>Policy-as-Code mindset: versioned security controls, runtime enforcement, and privacy-first
                    engineering baked into every build.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     EXPERIENCE TIMELINE
     ============================================================ -->
<section class="p-section">
    <div class="p-container">
        <div class="p-section-header">
            <p class="p-subtitle">Experience</p>
            <h2>Professional Journey</h2>
        </div>

        <div class="p-about-card" style="text-align:left;">
            <h3 style="color:var(--primary);margin-bottom:0.5rem;">Health Care Specialist / Operational Systems Support
            </h3>
            <p style="color:var(--accent-dark);font-weight:600;margin-bottom:1rem;">U.S. Army · San Antonio, TX · May
                2024 – May 2026</p>
            <p>&#8226; Provide operational and technical support in high-pressure clinical and training environments.
            </p>
            <p>&#8226; Resolve real-time operational issues using structured troubleshooting and incident-response
                practices.</p>
            <p>&#8226; Support accountability and readiness of equipment and systems valued at $50K+.</p>
            <p>&#8226; Document workflows and operational processes to improve standardization and communication.</p>
        </div>

        <div class="p-about-card" style="text-align:left;margin-top:1.5rem;">
            <h3 style="color:var(--primary);margin-bottom:0.5rem;">Freelance Software Developer</h3>
            <p style="color:var(--accent-dark);font-weight:600;margin-bottom:1rem;">Independent Clients · Remote · Jan
                2017 – Present</p>
            <p>&#8226; Develop and maintain web and mobile applications using responsive UI design and API integration.
            </p>
            <p>&#8226; Troubleshoot technical and performance issues across software projects.</p>
            <p>&#8226; Manage concurrent projects with Git-based workflows and clear communication.</p>
            <p>&#8226; Implement analytics and operational visibility using metabase dashboards.</p>
        </div>

        <div class="p-about-card" style="text-align:left;margin-top:1.5rem;">
            <h3 style="color:var(--primary);margin-bottom:0.5rem;">Android Developer</h3>
            <p style="color:var(--accent-dark);font-weight:600;margin-bottom:1rem;">Dimite Technologies LTD · Westlands,
                Nairobi · Jan 2019 – Nov 2021</p>
            <p>&#8226; Designed and developed Android apps using Java and Android frameworks.</p>
            <p>&#8226; Integrated REST APIs and external data sources for stable system communication.</p>
            <p>&#8226; Conducted unit testing, debugging, and issue resolution to improve UX.</p>
        </div>

        <div class="p-about-card" style="text-align:left;margin-top:1.5rem;">
            <h3 style="color:var(--primary);margin-bottom:0.5rem;">Software Maintenance Intern</h3>
            <p style="color:var(--accent-dark);font-weight:600;margin-bottom:1rem;">Software for Schools Kenya · Remote
                / Nairobi · Jun 2020 – Dec 2023</p>
            <p>&#8226; Provided development, testing, and technical support for web-based applications.</p>
            <p>&#8226; Troubleshot 50+ technical issues and improved system stability.</p>
            <p>&#8226; Cooperated with developers and stakeholders on ongoing enhancements.</p>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>