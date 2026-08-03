# Compliance & Policy as Code

**Njenga Sam Portfolio** — machine-readable policies live in [`policies/`](policies/).

## What is Policy as Code here?

Every compliance domain is captured as a versioned, reviewable YAML policy file in
`policies/`. The PHP engine `includes/compliance.php` reads these files at runtime and
enforces the controls they declare — so the documentation **is** the enforcement source.

## Policy Inventory

| Domain | Policy file | Framework | Verification |
|--------|-------------|-----------|--------------|
| Security | `security.policy.yaml` | OWASP ASVS L1, GDPR | Periodic |
| Privacy | `privacy.policy.yaml` | GDPR, Kenya DPA 2019 | Periodic |
| Accessibility | `accessibility.policy.yaml` | WCAG 2.1 AA | Each release |
| Deployment | `deployment.policy.yaml` | — | Every deployment |
| Backup & DR | `backup.policy.yaml` | — | Monthly |
| Incident Response | `incident-response.policy.yaml` | — | Quarterly |

## Enforcement Points

- `includes/compliance.php` — security headers, CSP, HSTS, session hardening, HTTPS redirect.
- `admin/login.php` — login rate limiting (5 attempts / 5 min lockout).
- `admin/compliance.php` — admin compliance dashboard (policy posture + runtime headers).
- `compliance.php` — public compliance posture page.
- `admin/partials/header.php` — enforces headers on every admin page.

## Deployment Pipeline (Policy Gated)

The deployment pipeline in `.cpanel.yml` / `.cp.yml` enforces these gates:

1. **Validate PHP lint** — `php -l` on all changed `.php` files (no syntax errors).
2. **Validate policy YAML** — all `policies/*.yaml` present and parseable.
3. **Secrets scan** — fail if any credential/secret is present in the artifact.
4. **Copy static assets** — `css/`, `js/`, `images/`, `head/`, `writing_dev/`, `imageResizer/`.
5. **Verify headers** — post-deploy smoke check that security headers are present.
6. **Smoke test HTTPS** — confirm the site responds over HTTPS with HSTS.

## Daily Development Compliance

- Always run `php -l` on modified PHP files before committing.
- Keep policy files in sync with any code change that alters controls.
- On any security/privacy change, update `policies/*.yaml` **and** `SECURITY.md`.
- Review the admin Compliance dashboard after each release to confirm 100% posture.

## Data Subject Rights

To exercise access, rectification, or erasure under GDPR / Kenya DPA 2019, contact
**leumaskabura@gmail.com**.
