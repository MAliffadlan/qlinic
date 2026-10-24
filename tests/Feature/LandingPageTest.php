<?php

namespace Tests\Feature;

use DOMDocument;
use DOMXPath;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_minimal_landing_keeps_actions_and_removes_long_sections(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertViewIs('landing');

        foreach ([
            'Antre dari rumah',
            'Datang tepat waktu',
            'Ilustrasi antrean',
            'Poli Umum',
            'Poli Gigi',
        ] as $text) {
            $response->assertSeeText($text);
        }

        foreach ([route('register'), route('login'), route('queue.display')] as $url) {
            $response->assertSee('href="'.$url.'"', false);
        }

        $content = $response->getContent();
        $this->assertSame(1, $this->headingCount($content, 'h1'));
        $this->assertSame(3, $this->stepCount($content));
        $response->assertSee(asset('js/landing.js'), false);

        foreach (['id="layar"', 'id="faq"', 'tv-mock', 'hero__plant', 'hero__mini'] as $removed) {
            $response->assertDontSee($removed, false);
        }
    }

    public function test_editorial_landing_has_a_distinct_hero_and_physical_ticket(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $content = $response->getContent();
        $this->assertSame(1, $this->elementCount($content, '//section[contains(concat(" ", normalize-space(@class), " "), " hero ")]//div[contains(concat(" ", normalize-space(@class), " "), " hero__stage ")]'));
        $this->assertSame(1, $this->elementCount($content, '//figure[contains(concat(" ", normalize-space(@class), " "), " ticket-demo ")]//div[contains(concat(" ", normalize-space(@class), " "), " ticket-demo__perforation ")]'));
        $this->assertSame(1, $this->elementCount($content, '//section[@id="cara-kerja" and contains(concat(" ", normalize-space(@class), " "), " journey ")]'));
        $response->assertSee('Ilustrasi antrean', false);
        $this->assertSame(3, $this->elementCount($content, '//article[contains(concat(" ", normalize-space(@class), " "), " step-row ")]/div'));
        $response->assertDontSee('service-links', false);
    }

    public function test_closing_has_one_action_instead_of_a_duplicate_login(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $content = $response->getContent();
        $closing = '//section[contains(concat(" ", normalize-space(@class), " "), " closing ")]';
        $this->assertSame(1, $this->elementCount($content, $closing.'//a'));
        $this->assertSame(1, $this->elementCount($content, $closing.'//a[@href="'.route('register').'"]'));
        $this->assertSame(0, $this->elementCount($content, $closing.'//a[@href="'.route('login').'"]'));
        $this->assertSame(1, $this->elementCount($content, $closing.'//*[contains(concat(" ", normalize-space(@class), " "), " queue-buddy ")][@role="img"]'));
        $this->assertSame(0, $this->elementCount($content, $closing.'//p[contains(concat(" ", normalize-space(@class), " "), " closing__flow ")]'));
        $this->assertSame(1, $this->elementCount($content, '//header//a[@href="'.route('login').'"]'));
    }

    public function test_footer_does_not_repeat_the_queue_display_link(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $content = $response->getContent();
        $this->assertSame(0, $this->elementCount($content, '//footer//a[@href="'.route('queue.display').'"]'));
        $this->assertSame(0, $this->elementCount($content, '//footer//*[contains(concat(" ", normalize-space(@class), " "), " landing-footer__brand ")]'));
        $this->assertSame(1, $this->elementCount($content, '//section[contains(concat(" ", normalize-space(@class), " "), " hero ")]//a[@href="'.route('queue.display').'"]'));
    }

    public function test_header_omits_the_tagline_and_footer_has_centered_copyright(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $content = $response->getContent();
        $response->assertDontSeeText('Ruang tunggu, versi baru.');
        $response->assertDontSeeText('Antre lebih nyaman, tanpa aplikasi tambahan.');
        $response->assertSeeText('© 2026 Qlinic. All rights reserved.');
        $this->assertSame(0, $this->elementCount($content, '//header//*[contains(concat(" ", normalize-space(@class), " "), " landing-nav__note ")]'));
        $this->assertSame(0, $this->elementCount($content, '//footer//*[contains(concat(" ", normalize-space(@class), " "), " landing-footer__brand ")]'));
        $this->assertSame(1, $this->elementCount($content, '//footer//p[normalize-space()="© 2026 Qlinic. All rights reserved."]'));

        $css = file_get_contents(public_path('css/landing.css'));
        $this->assertMatchesRegularExpression('/\.landing-footer__inner\s*\{[^}]*justify-content\s*:\s*center/s', $css);
        $this->assertMatchesRegularExpression('/\.landing-footer p\s*\{[^}]*text-align\s*:\s*center/s', $css);
    }

    public function test_landing_is_usable_without_javascript(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('class="landing-body"', false);
        $response->assertSee('href="#main"', false);
        $response->assertSee('id="main"', false);
        $response->assertDontSee('onclick=', false);

        $this->assertDoesNotMatchRegularExpression(
            '/<style[^>]*>[^<]*(?:opacity\s*:\s*0|visibility\s*:\s*hidden)/s',
            $response->getContent()
        );
    }

    public function test_landing_uses_existing_public_assets(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('src="'.asset('logo.png').'"', false);
        $response->assertSee('href="'.asset('logo.png').'"', false);
        $response->assertDontSee(asset('img/logo.png'), false);
    }

    public function test_landing_motion_is_progressive_and_reduced_motion_safe(): void
    {
        $css = file_get_contents(public_path('css/landing.css'));
        $javascript = file_get_contents(public_path('js/landing.js'));

        $this->assertMatchesRegularExpression(
            '/\.landing-body\s+\.reveal\s*\{[^}]*opacity\s*:\s*1/s',
            $css
        );
        $this->assertStringNotContainsString('color: var(--muted);', $css);
        $this->assertStringContainsString('@media (prefers-reduced-motion: reduce)', $css);
        $this->assertStringContainsString('scroll-behavior: auto', $css);
        $this->assertStringContainsString('.landing-motion', $css);
        $this->assertStringNotContainsString('.js .reveal', $css);
        $this->assertStringContainsString('landing-header.is-scrolled', $css);
        $this->assertStringContainsString('border-radius: 999px', $css);
        $this->assertStringContainsString('updateHeader', $javascript);
        $this->assertStringContainsString('window.scrollY', $javascript);
        $this->assertStringContainsString('requestAnimationFrame', $javascript);
        $this->assertStringContainsString('IntersectionObserver', $javascript);
        $this->assertStringContainsString('classList.add("landing-motion")', $javascript);
        $this->assertStringContainsString('observer.unobserve', $javascript);
        $this->assertStringContainsString('addEventListener("scroll", scheduleHeaderUpdate, { passive: true })', $javascript);
        $this->assertStringContainsString('if (headerFrame !== null) return;', $javascript);
    }

    private function elementCount(string $html, string $query): int
    {
        $document = new DOMDocument;
        @$document->loadHTML($html, LIBXML_NOERROR);

        return (new DOMXPath($document))->query($query)->length;
    }

    private function stepCount(string $html): int
    {
        $document = new DOMDocument;
        @$document->loadHTML($html, LIBXML_NOERROR);

        return (new DOMXPath($document))->query(
            '//article[contains(concat(" ", normalize-space(@class), " "), " step-row ")]'
        )->length;
    }

    private function headingCount(string $html, string $heading): int
    {
        $document = new DOMDocument;
        @$document->loadHTML($html, LIBXML_NOERROR);

        return (new DOMXPath($document))->query('//'.$heading)->length;
    }
}
