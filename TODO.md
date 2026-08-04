# Portfolio Revamp — Njenga Sam 2.0

**Goal:** Transform the static portfolio into a PHP-driven, admin-manageable site (imitating Project-Elpis) with a visible navbar, editable recent-works gallery (scrollable, 3×2 visible), iframe project modals, testimonials, a working contact page, and a fixed footer. Keep color theory (Blue + Amber complementary) and Policy-as-Code compliance.

## Steps
- [x] 1. Database: create/import `portfolio_db`, add `messages.is_read` column
- [x] 2. `includes/functions.php`: add contact-message + services helpers
- [x] 3. `includes/header.php`: visible sticky navbar (Home, About, Services, Projects, Contact, Compliance)
- [x] 4. `includes/footer.php`: full footer with socials, quick links, contract info (fix invisible footer)
- [x] 5. `css/portfolio.css`: complementary theme, hero side-by-side layout, scrollable gallery (3×2, ≤50vw), iframe modal, footer
- [x] 6. `index.php`: dynamic homepage (hero, about brief, services, gallery w/ scrollbar, testimonials, CTA)
- [x] 7. `about.php` + `services.php`: separate pages (resume-informed)
- [x] 8. `projects.php` + `project.php`: full gallery + project detail (iframe-friendly, visit-link)
- [x] 9. `contact.php`: working contact form (saves to `messages`)
- [x] 10. Admin: verify messages `is_read`, add links to new pages
- [x] 11. Test: `php -l` all files, verify pages render & DB works

## Post-Revamp Production Features
- [x] 12. Testimonial image upload: add `image` column to `testimonials` (schema + migration + ALTER on dev DB), `testimonialImage()` helper, admin upload form + preview, delete cleanup, public avatar display
- [x] 13. Admin session logout: 5-min idle auto-logout JS (admin footer) + browser-close sessions (server-side `cookie_lifetime=0`)
- [x] 14. Fix `admin/compliance.php` Forbidden: `.htaccess` was blocking any file named `compliance.php`; switched to protecting `/includes/` directory instead
- [x] 15. Production hygiene: `.gitignore` added, `.cpanel.yml` cleanup rules for dev artifacts (test.html, ndex.html, index.q.html, comingsoon.html, index.html, test/, .DS_Store)
- [ ] 16. Final pre-production audit (security, config, uploads, deploy)

