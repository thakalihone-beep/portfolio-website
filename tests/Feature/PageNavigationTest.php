<?php

namespace Tests\Feature;

use Tests\TestCase;

class PageNavigationTest extends TestCase
{
    public function test_about_page_shows_site_navigation_and_profile_name(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Home')
            ->assertSee('RoshanGauchan')
            ->assertDontSee('Your Name');
    }
}
