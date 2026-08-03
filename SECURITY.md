# Security Policy

**Njenga Sam Portfolio** — [Policy as Code](policies/security.policy.yaml)

## Reporting a Vulnerability

Please report security issues privately to **leumaskabura@gmail.com** rather than
opening a public issue. You will receive a response within 72 hours.

## Security Controls (Runtime Enforced)

The following controls are declared in `policies/security.policy.yaml` and enforced
by `includes/compliance.php` on every page load.

| Control | Status | Details |
|---------|--------|---------|
| HTTP response headers | Enforced | `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `X-XSS-Protection`, `Permissions-Policy`, `Content-Security-Policy` |
| HSTS | Enforced (prod) | `Strict-Transport-Security: max-age=31536000; includeSubDomains` |
| Session cookie HttpOnly | Enforced | `session_set_cookie_params` with `httponly => true` |
| Session cookie SameSite | Enforced | `samesite => 'Strict'` |
| Session strict mode | Enforced | `session.use_strict_mode = 1` |
| Session timeout | Enforced | `SESSION_TIMEOUT = 1800` (30 min) |
| Prepared statements | Enforced | All DB queries use `prepare()` / parameterized statements |
| Output encoding | Enforced | `h()` = `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` |
| Password hashing | Enforced | `password_hash()` / `password_verify()` (bcrypt) |
| Login rate limiting | Enforced | 5 failed attempts → 5-minute lockout (`admin/login.php`) |
| Upload whitelist | Enforced | Only `image/jpeg|png|gif|webp`, max 5MB |
| HTTPS redirect | Enforced (prod) | `enforceHttpsRedirect()` forces 301 to HTTPS |

## Deployment Security

- Secrets are never committed. DB credentials live in `includes/config.php` (non-versioned).
- All deployments are gated by the pipeline in `.cpanel.yml` / `.cp.yml`.
- Run `php -l` on every changed PHP file before merge (see `COMPLIANCE.md`).

## Supported Development

This project is a personal portfolio. No formal security support window is provided;
the owner will address reported vulnerabilities on a best-effort basis.
