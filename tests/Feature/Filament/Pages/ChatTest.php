<?php

namespace Tests\Feature\Filament\Pages;

use App\Events\MessageSent;
use App\Filament\Pages\Chat;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\UserRole;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestCase;

class ChatTest extends TestCase
{
    private function adminUser(): User
    {
        return User::factory()->create(['role' => UserRole::Admin]);
    }

    public function test_mount_creates_or_uses_conversation_with_admin(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();

        Livewire::actingAs($customer)
            ->test(Chat::class)
            ->assertSet('conversationId', 1)
            ->assertSet('otherUserId', $admin->id);
    }

    public function test_mount_marks_incoming_admin_messages_as_read(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();

        $conversation = Conversation::between($customer->id, $admin->id);
        $unread = Message::factory()->create([
            'conversation_id' => $conversation->id,
            'user_id' => $admin->id,
            'content' => 'Hello there',
        ]);

        Livewire::actingAs($customer)
            ->test(Chat::class);

        $this->assertNotNull($unread->fresh()->read_at);
    }

    public function test_send_marks_own_message_as_unread_and_fires_message_sent(): void
    {
        Event::fake([MessageSent::class]);

        $admin = $this->adminUser();
        $customer = User::factory()->create();

        Livewire::actingAs($customer)
            ->test(Chat::class)
            ->set('message', 'Hi admin')
            ->call('send')
            ->assertSet('message', '')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('messages', [
            'user_id' => $customer->id,
            'content' => 'Hi admin',
        ]);
    }

    public function test_load_messages_includes_read_status(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = Conversation::between($customer->id, $admin->id);

        Message::factory()->read()->create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'content' => 'My read message',
        ]);

        Livewire::actingAs($customer)
            ->test(Chat::class)
            ->assertSet('messages.0.read', true);
    }
}
