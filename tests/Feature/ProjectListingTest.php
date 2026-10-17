<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_page_lists_published_projects_and_their_links(): void
    {
        Project::create([
            'title' => 'Portfolio Platform',
            'slug' => 'portfolio-platform',
            'short_description' => 'A published portfolio application.',
            'github_url' => 'https://github.com/example/portfolio-platform',
            'is_published' => true,
        ]);

        Project::create([
            'title' => 'Private Project',
            'slug' => 'private-project',
            'is_published' => false,
        ]);

        $this->get(route('projects'))
            ->assertOk()
            ->assertSee('Portfolio Platform')
            ->assertSee('A published portfolio application.')
            ->assertSee('https://github.com/example/portfolio-platform')
            ->assertDontSee('Private Project');
    }

    public function test_projects_page_shows_an_empty_state_without_published_projects(): void
    {
        $this->get(route('projects'))
            ->assertOk()
            ->assertSee('No projects have been published yet.')
            ->assertDontSee('Haatify')
            ->assertDontSee('Orvi Task');
    }
}
