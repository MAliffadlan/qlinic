# Qlinic Minimal Landing Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the long Qlinic guest landing with a shorter, responsive editorial-minimal page with restrained motion and no application behavior changes.

**Architecture:** Keep the existing Laravel route and Blade rendering. Replace only the landing-specific markup/styles, put its small progressive-enhancement script in a dedicated deferred asset, and test the rendered landing plus real browser layout/motion. Deploy the same reviewed source to the existing server image without touching runtime SQLite, unrelated local changes, or other Compose services.

**Tech Stack:** Laravel 12, Blade, plain CSS, vanilla JavaScript, PHPUnit, local browser/CDP checks, Docker Compose/Nginx deployment.

**Spec:** `docs/superpowers/specs/2026-10-25-minimal-landing-design.md`

## Global Constraints

- Implement the four-block light editorial-minimal layout and exact content priorities in the spec; do not introduce a second visual direction.
- Only `resources/views/landing.blade.php`, `public/css/landing.css`, new `public/js/landing.js`, `tests/Feature/LandingPageTest.php`, and design/plan docs are in scope for this feature.
- Use Blade `route()`/`asset()` helpers for internal routes/assets. No hard-coded root links, new npm packages, remote images, animation libraries, or changes to global `qlinic.css`.
- No real-time or fabricated patient data in the illustration. Visible label must be `Ilustrasi antrean`.
- Respect reduced motion, no-JS rendering, keyboard focus, semantic headings, 44px targets, and 320–1440px layouts without horizontal overflow.
- Never test against or reset production SQLite. Preserve local `Jurnal_Pengembangan_Qlinic.docx` and server changes to `bootstrap/app.php`, `.deploy/`, and `tests/Feature/ReverseProxyUrlTest.php`.

## Review Focus

- Reduced-motion/JS-disabled users must still see all content and links; pin this in Task 2 browser assertions.
- Public `/qlinic/` proxy URLs must retain the prefix after deploying the same assets; pin this in Task 3 public smoke checks.
- Small screens must not clip the ticket or actions; pin 320px/375px overflow and bounding-box checks in Task 2.
- Queue status must not look like live data; pin the illustration label and absence of live-only TV/FAQ content in Task 1.
- Deployment must preserve production data and unrelated work; pin pre/post database counts and untouched proxy configuration checks in Task 3.

---

### Task 1: Landing content and regression contract

**Files:**
- Create: `tests/Feature/LandingPageTest.php`
- Modify: `resources/views/landing.blade.php`
- Test: `tests/Feature/LandingPageTest.php`

**Interfaces:**
- Consumes: Existing guest `GET /`, route names `landing`, `login`, `register`, and `queue.display`.
- Produces: Rendered landing with landmarks `#main`, `#cara-kerja`, `.hero__visual`, `.ticket-demo`, `.steps-list`, and asset `js/landing.js`; all links use Laravel-generated URLs.

- [ ] **Step 1: Write the failing feature test**

Create `LandingPageTest` with `test_minimal_landing_keeps_actions_and_removes_long_sections()` and `test_landing_is_usable_without_javascript()`. Assert HTTP 200; `view()->name` is `landing`; one `<h1>`; visible copy includes `Antre dari rumah`, `Datang tepat waktu`, `Ilustrasi antrean`, `Poli Umum`, and `Poli Gigi`; exactly three `.step-row` elements; generated routes for registration/login/display occur; and content includes `landing.js`. Assert absent strings/landmarks `id="layar"`, `id="faq"`, `tv-mock`, `hero__plant`, and `hero__mini`. Assert `.landing-body` includes the skip link and that no-JS content does not depend on an inline script to become visible.

Example central assertions:

```php
$response->assertOk();
$response->assertSee('Ilustrasi antrean');
$response->assertSee(route('register'), false);
$response->assertSee(route('login'), false);
$response->assertSee(route('queue.display'), false);
$this->assertSame(3, substr_count($response->getContent(), 'class="step-row'));
$response->assertDontSee('id="faq"', false);
$response->assertDontSee('tv-mock', false);
```

- [ ] **Step 2: Run the test to verify it fails**

Run in an isolated test runtime using the existing `phpunit.xml` SQLite `:memory:` configuration:

```bash
php artisan test --filter=LandingPageTest
```

Expected: FAIL because the current landing contains `id="faq"`, `tv-mock`, `hero__plant`, and lacks `Ilustrasi antrean`/`landing.js`. If dependencies or cached production config interfere, use a disposable copy/container with testing env; never alter production `.env` or DB.

- [ ] **Step 3: Implement the minimal landing structure**

Replace `resources/views/landing.blade.php` with the four blocks specified: header, hero, three-step section with two plain poli links, closing/footer. Keep metadata and existing font/stylesheet links. Use the existing `.brand`, `.btn`, `.container`, `.eyebrow`, and `.section-title` tokens. Add `<script src="{{ asset('js/landing.js') }}" defer></script>` and no inline application logic. Make the decorative ticket a non-live illustration, with `UMM-012` and `Menunggu panggilan` retained solely as example content. Keep all actions as normal anchors; do not add forms or controllers.

- [ ] **Step 4: Run the focused test to verify it passes**

Run `php artisan test --filter=LandingPageTest`. Expected: both landing tests pass, with no production DB access.

- [ ] **Step 5: Review the isolated change**

Run `git diff --check -- resources/views/landing.blade.php tests/Feature/LandingPageTest.php` and inspect the diff. Confirm no local journal or server proxy files are staged. Do not commit yet; visual behavior still needs verification.

### Task 2: Responsive visual system and restrained animation

**Files:**
- Modify: `public/css/landing.css`
- Create: `public/js/landing.js`
- Modify: `tests/Feature/LandingPageTest.php`
- Test: `tests/Feature/LandingPageTest.php` plus browser checks recorded in the execution report.

**Interfaces:**
- Consumes: `.landing-body`, `.landing-nav`, `.hero`, `.hero__visual`, `.ticket-demo`, `.steps-list`, `.reveal` from Task 1.
- Produces: `public/js/landing.js` adds `landing-motion` only when motion is permitted and `IntersectionObserver` exists; adds `.is-visible` to observed reveal targets. CSS `.reveal` remains visible by default.

- [ ] **Step 1: Add failing static/browser assertions**

Add a feature test asserting `landing.js` is present, `prefers-reduced-motion` appears in `public/css/landing.css`, and `.reveal` has a visible default. Prepare a browser check script that loads the isolated preview, records `document.documentElement.scrollWidth <= window.innerWidth`, visible CTA/ticket bounding boxes, heading order, link targets, and computed animation duration under reduced motion. Before implementation, verify the reduced-motion/no-JS checks fail against the old landing where its script-hidden reveal states or new assets do not satisfy the contract.

- [ ] **Step 2: Replace the landing stylesheet**

Replace the 1,196-line landing-specific stylesheet with a focused stylesheet for only the new markup. Keep existing warm-paper/forest tokens; remove arch, plant, mini-card, TV, FAQ, and oversized promotional panel styles. Use responsive grids, `clamp()` type/spacing, a restrained border/radius/shadow on the single ticket, and no decorative background patterns. At mobile widths use one-column hero/steps and ensure long ticket text cannot overflow. Preserve visible focus and 44px minimum interactive targets.

- [ ] **Step 3: Implement progressive-enhancement motion**

In `public/js/landing.js`, check `window.matchMedia('(prefers-reduced-motion: reduce)')` before enabling motion. Use a small `IntersectionObserver` callback to add `.is-visible` once and unobserve. Use CSS classes/keyframes for staggered initial hero entry and a 6-second, <=4px ticket float; use opacity-only status pulsing. When JS is disabled, observer is missing, or reduced motion is requested, do not apply hidden/transform states. Do not add scroll listeners, parallax, timers, or third-party code.

- [ ] **Step 4: Run focused and existing tests**

Run:

```bash
php artisan test --filter=LandingPageTest
php artisan test
git diff --check -- resources/views/landing.blade.php public/css/landing.css public/js/landing.js tests/Feature/LandingPageTest.php
```

Expected: all tests pass and diff check is clean. Run browser checks at 320, 375, 390, 768, 1280, and 1440px; verify no horizontal overflow, visible CTA/ticket, working registration/login/display links, keyboard focus, no-JS visibility, and zero continuous motion under reduced motion. Capture desktop/mobile previews for review. Fix and rerun if any check fails.

- [ ] **Step 5: Review and commit only this feature**

Inspect the scoped diff for accessibility, misleading live-data wording, and unrelated changes. If using an isolated worktree, commit only landing code/assets/tests plus reviewed design docs with `feat: simplify Qlinic landing page`. Otherwise leave a clean scoped change set ready for the user-approved commit; never include `Jurnal_Pengembangan_Qlinic.docx` or server-only proxy files.

### Task 3: Preview, deploy, and verify the public landing

**Files:**
- Review only: `/home/mectov/project_pribadi/qlinic/resources/views/landing.blade.php`
- Review only: `/home/mectov/project_pribadi/qlinic/public/css/landing.css`
- Review only: `/home/mectov/project_pribadi/qlinic/public/js/landing.js`
- Test only: `/home/mectov/project_pribadi/qlinic/tests/Feature/LandingPageTest.php`
- Runtime reference: `/home/mectov/project_pribadi/qlinic-deploy/README.md`

**Interfaces:**
- Consumes: Reviewed landing changes from Tasks 1–2; existing `/home/mectov/docker-compose.yml` service `qlinic` and `web-statis` proxy.
- Produces: Updated public `https://projects.malifadlan.dev/qlinic/` landing with unchanged registration/login/display behavior and unchanged SQLite data.

- [ ] **Step 1: Verify the reviewed candidate and server safety**

Run focused/full tests against the exact candidate. Record current `git status`, database service/user/queue counts, and `PRAGMA integrity_check` read-only. Confirm local/server source versions match before copying and that no unrelated source modifications will be included. Stop for review if unexpected changes exist. Do not rebuild or change the live page in this step.

- [ ] **Step 2: Deploy only Qlinic after user approval**

Copy only the reviewed landing view, dedicated CSS/JS, and test to `/home/mectov/project_pribadi/qlinic`; preserve `bootstrap/app.php`, `.deploy/`, `ReverseProxyUrlTest.php`, runtime `.env`, and `data/database.sqlite`. Rebuild/recreate only `qlinic` from `/home/mectov/docker-compose.yml` with `docker compose up -d --no-deps --build qlinic`. Do not recreate `web-statis`, change Nginx, run seed/reset, or deploy from the retired standalone compose file.

- [ ] **Step 3: Run public and regression verification**

Wait for `qlinic` health to be `healthy`, verify `web-statis nginx -t`, then check HTTP 200 and the new copy/asset at `https://projects.malifadlan.dev/qlinic/`. Confirm every same-origin generated URL retains `/qlinic/`; CSS/JS/logo return 200 with a browser user-agent; reduced-motion/mobile checks pass in the browser; direct `http://100.97.130.23:8089` still renders the new landing. Run existing `smoke_test.py` and `public_smoke_test.py` with the private credential supplied via environment (not output), deleting test cookies afterward. Re-read database counts and integrity; expected: unchanged `2 services`, `4 users`, `0 queues`, `integrity ok`.

- [ ] **Step 4: Report actual result and remaining work**

Report the public link, tested viewport/motion results, direct/public smoke output, database invariants, and files changed. If a browser screenshot tool is unavailable, explicitly state which visual checks were not performed rather than claiming them. Mention the previously recorded upstream dev-tool `npm audit` findings only as a separate pre-existing note; do not mix that audit into this landing change. Commit/push only after the user reviews the visual result and explicitly chooses that action.
