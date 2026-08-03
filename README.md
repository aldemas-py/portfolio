# Njenga Sam — Portfolio

My personal portfolio website. A responsive, single-page site showcasing my
projects, skills, and design philosophy, backed by a small PHP admin panel and
a **Policy as Code** compliance system.

## Features

- Responsive single-page portfolio (`index.html`)
- Project showcase grid (writing_dev, imageResizer, templates, and more)
- Admin panel with dashboard, projects, testimonials, messages, profile, and
  compliance management
- **Policy as Code** compliance engine that reads versioned YAML policies and
  enforces runtime security controls

## Compliance & Policy as Code

Security, privacy, accessibility, deployment, backup and incident-response
controls are declared as machine-readable policies in [`policies/`](policies/)
and enforced by [`includes/compliance.php`](includes/compliance.php).

| Artifact | Purpose |
|----------|---------|
| [`policies/`](policies/) | Versioned YAML policy files (6 domains) |
| [`includes/compliance.php`](includes/compliance.php) | Runtime enforcement engine (headers, CSP, HSTS, session hardening) |
| [`admin/compliance.php`](admin/compliance.php) | Admin compliance dashboard |
| [`compliance.php`](compliance.php) | Public compliance posture page |
| [`SECURITY.md`](SECURITY.md) | Human-readable security policy |
| [`COMPLIANCE.md`](COMPLIANCE.md) | Human-readable compliance guide |
| [`.htaccess`](.htaccess) | Server-level security headers & hardening |
| [`.cpanel.yml`](.cpanel.yml) / [`.cp.yml`](.cp.yml) | Policy-gated deployment pipeline |

### Enforced runtime controls

- HTTP security headers (X-Content-Type-Options, X-Frame-Options, Referrer-Policy,
  X-XSS-Protection, Permissions-Policy, Content-Security-Policy)
- HSTS (production)
- HTTPS redirect
- Session hardening (HttpOnly, SameSite=Strict, strict mode, 30-min timeout)
- Login rate limiting (5 attempts / 5-min lockout)
- Prepared statements + output encoding (`h()`)
- Upload whitelist (images only, max 5MB)

## Running locally (XAMPP)

1. Copy the project into `htdocs/portfolio`.
2. Start Apache + MySQL in XAMPP.
3. Import `sql/database.sql` into phpMyAdmin.
4. Configure DB credentials in `includes/config.php`.
5. Open `http://localhost/portfolio/`.

## Admin

- URL: `/admin/`
- Login uses `password_hash` (bcrypt) credentials from `admin_users`.

## Branding

- **Primary:** Blue `#2563EB`
- **Accent (complementary):** Warm Amber `#F59E0B`

## License

Personal portfolio. See [SECURITY.md](SECURITY.md) for reporting guidelines.
