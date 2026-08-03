<?php

/**
 * Njenga Sam Portfolio - Contact Page
 * Saves contact messages to the `messages` table for the admin inbox.
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message) {
        if (saveContactMessage($name, $email, $phone, $subject, $message)) {
            $success = 'Thank you! Your message has been sent. I\'ll get back to you shortly.';
        } else {
            $error = 'Sorry, something went wrong. Please try again.';
        }
    } else {
        $error = 'Please fill in your name, email, and a message.';
    }
}

$pageTitle = 'Contact';
include __DIR__ . '/includes/header.php';
?>
<!-- ============================================================
     PAGE BANNER
     ============================================================ -->
<section class="p-page-banner">
    <div class="p-container">
        <h1>Get in <span class="p-banner-accent">Touch</span></h1>
        <p>Have a project in mind or need help with a system? Let's build something great together.</p>
    </div>
</section>

<!-- ============================================================
     CONTACT
     ============================================================ -->
<section class="p-section">
    <div class="p-container">
        <div class="p-contact-grid">
            <!-- Contact info -->
            <div class="p-contact-info">
                <h2 style="color:var(--primary);font-size:1.6rem;margin-bottom:1rem;">Contact Information</h2>
                <p style="color:var(--text-muted);margin-bottom:2rem;">
                    I'm available for freelance projects, collaboration, and consulting. Reach out through any of the
                    channels below, or use the form.
                </p>

                <div class="p-contact-item">
                    <span class="p-contact-icon">&#9993;</span>
                    <div>
                        <h4>Email</h4>
                        <p><a href="mailto:leumaskabura@gmail.com"
                                style="color:var(--primary);">leumaskabura@gmail.com</a></p>
                    </div>
                </div>

                <div class="p-contact-item">
                    <span class="p-contact-icon">&#9742;</span>
                    <div>
                        <h4>Phone / WhatsApp</h4>
                        <p><a href="tel:+254700000000" style="color:var(--primary);">+254 700 000 000</a></p>
                    </div>
                </div>

                <div class="p-contact-item">
                    <span class="p-contact-icon">&#9906;</span>
                    <div>
                        <h4>Location</h4>
                        <p>Nairobi, Kenya (Remote-friendly)</p>
                    </div>
                </div>

                <div class="p-contact-item">
                    <span class="p-contact-icon">&#128232;</span>
                    <div>
                        <h4>Working Hours</h4>
                        <p>Mon – Sat: 8:00 AM – 6:00 PM (EAT)</p>
                    </div>
                </div>
            </div>

            <!-- Contact form -->
            <div class="p-contact-form">
                <?php if ($success): ?>
                <div class="p-alert p-alert-success"><?php echo h($success); ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                <div class="p-alert p-alert-error"><?php echo h($error); ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="p-form-row">
                        <div class="p-form-group">
                            <label for="name">Your Name *</label>
                            <input type="text" id="name" name="name" class="p-form-control" required
                                value="<?php echo h($_POST['name'] ?? ''); ?>">
                        </div>
                        <div class="p-form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" class="p-form-control" required
                                value="<?php echo h($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="p-form-row">
                        <div class="p-form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" class="p-form-control"
                                value="<?php echo h($_POST['phone'] ?? ''); ?>">
                        </div>
                        <div class="p-form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" class="p-form-control"
                                value="<?php echo h($_POST['subject'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="p-form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" class="p-form-control" rows="6"
                            required><?php echo h($_POST['message'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="p-btn p-btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>