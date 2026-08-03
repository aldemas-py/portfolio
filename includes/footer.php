    <!-- ============================================================
         FOOTER
         ============================================================ -->
    <footer class="p-footer">
        <div class="p-container">
            <div class="p-footer-grid">
                <div class="p-footer-about">
                    <h3><span>Njenga</span>Sam</h3>
                    <p>Software Engineer & Solutions Architect. I build business-focused digital solutions — from
                        responsive web apps and Android applications to API integration and IT systems support.</p>
                    <div class="p-socials">
                        <a href="https://github.com/aldemas-py" target="_blank" rel="noopener noreferrer"
                            aria-label="GitHub">GH</a>
                        <a href="https://linkedin.com/in/leumaskabura" target="_blank" rel="noopener noreferrer"
                            aria-label="LinkedIn">IN</a>
                        <a href="mailto:leumaskabura@gmail.com" aria-label="Email">@</a>
                    </div>
                </div>

                <div>
                    <h4>Quick Links</h4>
                    <ul class="p-footer-links">
                        <li><a href="<?php echo SITE_URL; ?>/index.php">Home</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/about.php">About</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php">Our Services</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/projects.php">Project Gallery</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contact.php">Contact Us</a></li>
                    </ul>
                </div>

                <div>
                    <h4>Services</h4>
                    <ul class="p-footer-links">
                        <li><a href="<?php echo SITE_URL; ?>/services.php">Web & Mobile Development</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php">API Integration & Backend</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php">IT & Systems Support</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/services.php">System Architecture</a></li>
                    </ul>
                </div>

                <div>
                    <h4>Contact</h4>
                    <ul class="p-footer-contact">
                        <li><span class="p-icon">@</span> leumaskabura@gmail.com</li>
                        <li><span class="p-icon">&#127760;</span> njengasam.com</li>
                        <li><span class="p-icon">&#9962;</span> Nairobi, Kenya · Remote worldwide</li>
                    </ul>
                </div>
            </div>

            <div class="p-footer-bottom">
                <span>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Open to collaboration.</span>
                <span>
                    <a href="<?php echo SITE_URL; ?>/compliance.php" class="p-compliance-link">&#128737; Compliance
                        &amp; Trust</a>
                </span>
            </div>
        </div>
    </footer>

    <div class="p-modal" id="projectModal" aria-hidden="true">
        <div class="p-modal-backdrop" data-modal-close></div>
        <div class="p-modal-content">
            <button class="p-modal-close" data-modal-close aria-label="Close modal">&times;</button>
            <iframe id="projectModalFrame" src="about:blank" title="Project details"></iframe>
        </div>
    </div>

    <script src="<?php echo SITE_URL; ?>/js/main.js"></script>
    </body>

    </html>