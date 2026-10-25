<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminNavigationStyleTest extends TestCase
{
    public function test_dashboard_and_tv_choices_have_consistent_rounding(): void
    {
        $css = file_get_contents(public_path('css/admin.css'));
        $rule = '/\.admin-nav__link\s*\{(?:(?!\}).)*border-radius:\s*10px\s*;/s';
        $this->assertMatchesRegularExpression($rule, $css);
        $this->assertSame(1, substr_count(file_get_contents(resource_path('views/layouts/admin.blade.php')), 'admin-nav__link {{ request()->routeIs(\'admin.dashboard\')'));
        $this->assertStringContainsString("routeIs('admin.display')", file_get_contents(resource_path('views/layouts/admin.blade.php')));
    }

    public function test_sidebar_brand_is_centered_without_moving_the_mobile_close_button(): void
    {
        $css = file_get_contents(public_path('css/admin.css'));

        $this->assertMatchesRegularExpression(
            '/\.admin-sidebar__brand\s*\{(?:(?!\}).)*justify-content:\s*center\s*;/s',
            $css,
            'The Qlinic logo and wordmark must be centered in the sidebar.'
        );
        $this->assertMatchesRegularExpression(
            '/\.admin-sidebar__brand\s+\.brand\s*\{(?:(?!\}).)*justify-content:\s*center\s*;/s',
            $css
        );
        $this->assertMatchesRegularExpression(
            '/\.admin-sidebar__close\s*\{(?:(?!\}).)*position:\s*absolute\s*;/s',
            $css,
            'The mobile close button must not push the centered brand off-center.'
        );
    }
}
