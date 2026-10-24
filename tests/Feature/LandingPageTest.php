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
