<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_homepage_renders_with_default_profile_fallback(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('RoshanGauchan');
        $response->assertSee('Software Engineer & AI Builder');
    }
}
