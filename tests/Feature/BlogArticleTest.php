<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_article_appears_in_journal_and_opens_by_slug(): void
    {
        $post = BlogPost::create([
            'title' => 'Published Article',
            'slug' => 'published-article',
            'excerpt' => 'A short article summary.',
            'content' => 'The complete article body.',
            'status' => 'published',
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('blog'))
            ->assertOk()
            ->assertSee('Published Article');

        $this->get(route('blog.show', $post->slug))
            ->assertOk()
            ->assertSee('The complete article body.');

        $this->assertDatabaseHas('blog_posts', [
            'id' => $post->id,
            'views' => 1,
        ]);
    }

    public function test_draft_and_scheduled_articles_are_hidden(): void
    {
        BlogPost::create([
            'title' => 'Draft Article',
            'slug' => 'draft-article',
            'content' => 'This draft is private.',
            'status' => 'draft',
        ]);

        BlogPost::create([
            'title' => 'Scheduled Article',
            'slug' => 'scheduled-article',
            'content' => 'This article is not published yet.',
            'status' => 'published',
            'published_at' => now()->addDay(),
        ]);

        $this->get(route('blog'))
            ->assertOk()
            ->assertDontSee('Draft Article')
            ->assertDontSee('Scheduled Article');

        $this->get(route('blog.show', 'draft-article'))->assertNotFound();
        $this->get(route('blog.show', 'scheduled-article'))->assertNotFound();
    }
}
