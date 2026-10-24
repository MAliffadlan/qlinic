# Qlinic Minimal Landing — Design Spec

**Status:** Approved for implementation
**Date:** 2026-10-25
**Scope:** Guest-facing `/` landing page only.

## Intent

Make the landing feel calmer and more focused: fewer sections, more whitespace, one clear primary action, and restrained motion. It should look polished on a laptop and comfortable on a phone without changing Qlinic's application behavior.

## Chosen approach

Use a **light editorial-minimal** presentation, retaining the existing warm paper, forest green, Fraunces, and Plus Jakarta Sans tokens. This is the recommended option: it fits the existing brand and avoids rebuilding the app design system.

The page becomes four compact blocks:

1. **Header:** Qlinic brand, one anchor `Cara kerja`, text link `Masuk`, and a small `Daftar` button. At narrow widths, hide only the anchor; keep both account actions reachable.
2. **Hero:** Two columns on desktop. Left: a short eyebrow, `Antre dari rumah. Datang tepat waktu.`, one concise supporting paragraph, a primary `Ambil nomor antrean` link to registration, a quiet `Lihat layar antrean` link to the public display, and one-line trust copy `Gratis · Tanpa install aplikasi`. Right: one labeled **illustrative** queue card, `UMM-012`, with status `Menunggu panggilan`, a restrained progress indicator, and a small status chip. Do not include the decorative arch, plant SVG, mini queue card, or large patterned panel.
3. **How it works:** A bordered, three-column sequence `01 Daftar`, `02 Pilih poli`, `03 Pantau giliran`. Each has one short sentence. This also contains two plain service choices `Poli Umum` and `Poli Gigi` linking to registration, rather than two large promotional cards.
4. **Closing/footer:** A short closing sentence with registration/login actions and a minimal footer with `Layar antrean`. Remove the TV showcase, FAQ, large CTA panel, and duplicated footer navigation from the landing only. The actual `/display`, login, and registration routes remain untouched.

## Motion

- On first load, stagger the hero eyebrow/copy/actions and visual using opacity plus at most 12px vertical movement, 400–550ms.
- The ticket enters gently, then uses a slow 6-second float of at most 4px. The status dot has a quiet opacity pulse. No continuous rotation, cursor-following, parallax, animated counters, or large background effects.
- Reveal the steps once with `IntersectionObserver`, using a small stagger; show immediately if unavailable or if JS is disabled.
- Keep `prefers-reduced-motion: reduce` explicit in `landing.css`: no float/pulse/reveal movement, no smooth scrolling, content visible from the start.
- Motion must never hide navigation, primary actions, or the ticket permanently. Hover motion is optional and must have a keyboard-focus equivalent where relevant.

## Accessibility and responsive behavior

- One `<h1>`, semantic header/main/section/footer, logical heading order, a skip link, and meaningful link names.
- The ticket is an illustration, not live queue data: visible label `Ilustrasi antrean` and no invented live metrics. It must not imply a real patient has that ticket.
- Use existing Blade `route()` and `asset()` helpers for every internal link/asset so `/qlinic/` proxy support and direct port access continue working.
- Mobile: one-column hero; comfortable readable type; primary and secondary hero actions stack only where necessary; no horizontal overflow at 320, 375, and 390px. Desktop checks: 768, 1280, and 1440px.
- Preserve visible focus, adequate color contrast, and at least 44px interactive targets. External Google Fonts remain optional enhancements with system-font fallbacks.

## Boundaries

- Only landing markup, its dedicated stylesheet, a dedicated landing script if needed, and landing tests/docs may change.
- Do not alter authentication, queue/database behavior, global `qlinic.css`, admin/patient dashboards, actual display styling, proxy configuration, or dashboard/Mectov Space.
- No framework, npm package, animation library, stock photo, or new remote asset dependency.
- Preserve the local untracked `Jurnal_Pengembangan_Qlinic.docx` and the server's existing proxy/deployment modifications. Do not commit, reset, or overwrite unrelated work.

## Acceptance

A visitor can understand the purpose, see the next action, and reach registration/login/display from the shorter page. The design is visibly lighter than the current 372-line landing and its 1,196-line dedicated stylesheet, while preserving all functional routes, mobile readability, keyboard access, reduced-motion behavior, and the public `/qlinic/` prefix.
