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
- [ ] 9. `contact.php`: working contact form (saves to `messages`)
- [ ] 10. Admin: verify messages `is_read`, add links to new pages
- [ ] 11. Test: `php -l` all files, verify pages render & DB works

