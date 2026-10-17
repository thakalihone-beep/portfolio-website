<?php

namespace Tests\Feature;

use App\Models\User;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_message_is_saved_and_confirmation_is_shown(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Ria Example',
            'email' => 'ria@example.com',
            'subject' => 'Project inquiry',
            'message' => 'I would like to discuss a project.',
        ]);

        $response->assertRedirectToRoute('contact');
        $response->assertSessionHas('status', 'Thanks for reaching out. Your message has been received.');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Ria Example',
            'email' => 'ria@example.com',
            'subject' => 'Project inquiry',
            'message' => 'I would like to discuss a project.',
            'status' => 'unread',
        ]);
    }

    public function test_invalid_message_is_rejected_without_saving(): void
    {
        $response = $this->from(route('contact'))
            ->post(route('contact.store'), [
                'name' => '',
                'email' => 'not-an-email',
                'subject' => '',
                'message' => '',
            ]);

        $response->assertRedirectBackWithErrors(['name', 'email', 'subject', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_only_configured_admin_emails_can_access_the_admin_panel(): void
    {
        config(['filament.admin_emails' => ['owner@example.com']]);

        $admin = new User([
            'name' => 'Site Owner',
            'email' => 'owner@example.com',
            'password' => 'secret',
        ]);
        $visitor = new User([
            'name' => 'Visitor',
            'email' => 'visitor@example.com',
            'password' => 'secret',
        ]);

        $this->assertTrue($admin->canAccessPanel(Panel::make()->id('admin')));
        $this->assertFalse($visitor->canAccessPanel(Panel::make()->id('admin')));
        $this->assertFalse($admin->canAccessPanel(Panel::make()->id('other')));
    }

    public function test_guests_cannot_view_the_contact_inbox(): void
    {
        $this->get(route('filament.admin.resources.contact-messages.index'))
            ->assertRedirectToRoute('filament.admin.auth.login');
    }
}
