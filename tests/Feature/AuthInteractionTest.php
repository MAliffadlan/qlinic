<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthInteractionTest extends TestCase
{
    public function test_landing_auth_links_have_subtle_feedback_without_changing_navigation(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('href="'.route('login').'"', false);
        $response->assertSee('href="'.route('register').'"', false);
        $response->assertDontSee('onclick=', false);

        $css = file_get_contents(public_path('css/landing.css'));

        $loginHover = $this->cssRule($css, '.landing-nav__login:hover');
        $this->assertStringContainsString('translateY(-1px)', $loginHover);
        $this->assertStringContainsString('scaleX(1)', $this->cssRule($css, '.landing-nav__login:hover::after'));

        $register = $this->cssRule($css, '.landing-nav .landing-nav__register');
        $this->assertStringContainsString('position: relative', $register);
        $this->assertStringContainsString('overflow: hidden', $register);
        $this->assertStringContainsString('translateY(-2px)', $this->cssRule($css, '.landing-nav .landing-nav__register:hover'));
        $this->assertStringContainsString('translateX(4px)', $this->cssRule($css, '.landing-nav .landing-nav__register:hover > span'));
        $this->assertStringContainsString('scale(0.98)', $this->cssRule($css, '.landing-nav .landing-nav__register:active'));
        $this->assertStringContainsString('pointer-events: none', $this->cssRule($css, '.landing-nav .landing-nav__register::after'));
        $this->assertStringContainsString('landing-register-press', $this->cssRule($css, '.landing-nav .landing-nav__register:active::after'));
        $this->assertStringContainsString('@media (hover: hover)', $css);
    }

    public function test_auth_pages_enter_with_a_light_fade_and_respect_reduced_motion(): void
    {
        $login = $this->get(route('login'));
        $login->assertOk();
        $login->assertSee('id="email"', false);
        $login->assertSee('name="password"', false);

        $register = $this->get(route('register'));
        $register->assertOk();
        $register->assertSee('id="name"', false);
        $register->assertSee('id="nik"', false);
        $register->assertSee('id="password_confirmation"', false);

        $css = file_get_contents(public_path('css/app.css'));
        $panel = $this->cssRule($css, '.auth-panel');
        $this->assertStringContainsString('animation: auth-panel-enter 280ms', $panel);
        $this->assertStringContainsString('animation: auth-visual-enter 280ms', $this->cssRule($css, '.auth-visual'));
        $this->assertStringContainsString('@keyframes auth-panel-enter', $css);
        $this->assertStringContainsString('translateY(12px)', $css);
        $this->assertStringContainsString('@media (prefers-reduced-motion: reduce)', $css);
        $this->assertStringContainsString('animation: none', $css);
    }

    public function test_auth_link_press_feedback_overrides_hover_lift(): void
    {
        $css = file_get_contents(public_path('css/landing.css'));
        $this->assertMatchesRegularExpression(
            '/@media \(hover: hover\) \{.*?\.landing-nav \.landing-nav__register:active\s*\{[^}]*transform: translateY\(0\) scale\(0\.98\)/s',
            $css
        );
    }

    public function test_clicking_auth_links_plays_a_short_exit_transition_before_navigation(): void
    {
        $javascript = file_get_contents(public_path('js/landing.js'));
        $css = file_get_contents(public_path('css/landing.css'));

        $this->assertStringContainsString('.landing-nav__login, .landing-nav__register', $javascript);
        $this->assertStringContainsString('event.preventDefault()', $javascript);
        $this->assertStringContainsString('landing-auth-leaving', $javascript);
        $this->assertStringContainsString('landing-auth-leave', $javascript);
        $this->assertStringContainsString('window.location.assign(destination)', $javascript);
        $this->assertStringContainsString('window.setTimeout(navigate, 400)', $javascript);
        $this->assertStringContainsString('event.metaKey', $javascript);
        $this->assertStringContainsString('event.ctrlKey', $javascript);
        $this->assertStringContainsString('event.shiftKey', $javascript);
        $this->assertStringContainsString('event.altKey', $javascript);
        $this->assertStringContainsString('motionPreference.matches', $javascript);
        $this->assertStringContainsString('event.persisted', $javascript);

        $leaving = $this->cssRule($css, '.landing-body.landing-auth-leaving');
        $this->assertStringContainsString('animation: landing-auth-leave 220ms', $leaving);
        $this->assertStringContainsString('@keyframes landing-auth-leave', $css);
    }

    private function cssRule(string $css, string $selector): string
    {
        $matched = preg_match_all('/(?<![\w-])'.preg_quote($selector, '/').'\s*\{([^}]*)\}/', $css, $matches);
        $this->assertGreaterThan(0, $matched, 'Missing CSS rule: '.$selector);

        return implode("\n", $matches[1]);
    }
}
