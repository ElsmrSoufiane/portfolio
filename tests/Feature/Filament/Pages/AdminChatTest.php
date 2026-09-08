<?php

namespace Tests\Feature\Filament\Pages;

use App\Events\MessageSent;
use App\Filament\Pages\AdminChat;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\UserRole;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class AdminChatTest extends TestCase
{
    private function adminUser(): User
    {
        return User::factory()->create(['role' => UserRole::Admin]);
    }

    private function conversationBetween(User $admin, User $customer): Conversation
    {
        return Conversation::factory()->create([
            'user_one_id' => $customer->id,
            'user_two_id' => $admin->id,
        ]);
    }

    public function test_mount_lists_only_conversations_involving_the_admin(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $otherAdmin = $this->adminUser();

        $conversation = $this->conversationBetween($admin, $customer);
        $this->conversationBetween($otherAdmin, User::factory()->create());

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->assertCount('conversations', 1)
            ->assertSet('conversations.0.id', $conversation->id)
            ->assertSet('activeConversationId', $conversation->id);
    }

    public function test_mount_loads_messages_of_the_active_conversation(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        Message::factory()->create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'content' => 'Hello admin',
        ]);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->assertSet('activeConversationId', $conversation->id)
            ->assertCount('messages', 1)
            ->assertSee('Hello admin');
    }

    public function test_switch_conversation_loads_the_selected_messages(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $this->conversationBetween($admin, $customer);
        $second = $this->conversationBetween($admin, $customer);

        Message::factory()->create(['conversation_id' => $second->id, 'user_id' => $customer->id, 'content' => 'Second message']);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->call('switchConversation', $second->id)
            ->assertSet('activeConversationId', $second->id)
            ->assertSee('Second message');
    }

    public function test_send_stores_message_in_the_active_conversation(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->set('message', 'Are you there?')
            ->call('send')
            ->assertSet('message', '')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'user_id' => $admin->id,
            'content' => 'Are you there?',
        ]);
    }

    public function test_send_requires_a_message(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $this->conversationBetween($admin, $customer);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->call('send')
            ->assertHasErrors('message');
    }

    public function test_admin_can_edit_any_message_in_the_active_conversation(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);
        $message = Message::factory()->create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'content' => 'A typo',
        ]);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->callAction('edit', ['id' => $message->id], ['content' => 'Fixed message'])
            ->assertHasNoErrors();

        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'content' => 'Fixed message',
        ]);
    }

    public function test_admin_can_delete_any_message_in_the_active_conversation(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);
        $message = Message::factory()->create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'content' => 'Remove me',
        ]);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->callAction('delete', ['id' => $message->id]);

        $this->assertDatabaseMissing('messages', ['id' => $message->id]);
    }

    public function test_admin_cannot_switch_to_a_conversation_they_do_not_belong_to(): void
    {
        $admin = $this->adminUser();
        $otherAdmin = $this->adminUser();
        $foreign = $this->conversationBetween($otherAdmin, User::factory()->create());

        $this->expectException(NotFoundHttpException::class);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->call('switchConversation', $foreign->id);
    }

    public function test_switch_conversation_marks_incoming_messages_as_read(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        $unread = Message::factory()->create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'content' => 'Mark me read',
        ]);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->call('switchConversation', $conversation->id);

        $this->assertNotNull($unread->fresh()->read_at);
    }

    public function test_switch_conversation_only_marks_the_other_partys_unread_messages(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        $adminMessage = Message::factory()->create([
            'conversation_id' => $conversation->id,
            'user_id' => $admin->id,
            'read_at' => null,
        ]);
        $customerMessage = Message::factory()->create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'read_at' => null,
        ]);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->call('switchConversation', $conversation->id);

        $this->assertNull($adminMessage->fresh()->read_at);
        $this->assertNotNull($customerMessage->fresh()->read_at);
    }

    public function test_send_broadcasts_message_sent_event(): void
    {
        Event::fake([MessageSent::class]);

        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->set('message', 'Broadcast me')
            ->call('send');

        Event::assertDispatched(MessageSent::class, function (MessageSent $event) use ($conversation): bool {
            return $event->message->content === 'Broadcast me'
                && $event->message->conversation_id === $conversation->id;
        });
    }

    public function test_load_messages_includes_read_status(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        Message::factory()->read()->create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'content' => 'Read message',
        ]);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->assertSet('messages.0.read', true);
    }

    public function test_conversation_list_contains_unread_count(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        Message::factory()->count(3)->create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
            'read_at' => null,
        ]);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->assertSet('conversations.0.unread', 3);
    }

    public function test_channel_auth_denies_non_participants(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $stranger = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        $this->actingAs($stranger)
            ->postJson('/broadcasting/auth', [
                'channel_name' => 'private-conversation.'.$conversation->id,
                'socket_id' => '123.456',
            ])
            ->assertStatus(403);
    }

    public function test_channel_auth_allows_participants(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        $this->actingAs($customer)
            ->postJson('/broadcasting/auth', [
                'channel_name' => 'private-conversation.'.$conversation->id,
                'socket_id' => '123.456',
            ])
            ->assertOk();
    }

    public function test_mount_loads_only_the_last_ten_messages(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        $messages = collect(range(1, 15))->map(
            fn (int $i): Message => Message::factory()->create([
                'conversation_id' => $conversation->id,
                'user_id' => $customer->id,
                'content' => "Message {$i}",
            ])
        );

        $component = Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->assertCount('messages', 10)
            ->assertSet('hasMoreMessages', true);

        $loadedIds = collect($component->get('messages'))->pluck('id')->all();

        $this->assertEquals($messages->slice(5)->pluck('id')->all(), $loadedIds);
    }

    public function test_load_messages_does_not_indicate_more_when_ten_or_fewer(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        Message::factory()->count(5)->create([
            'conversation_id' => $conversation->id,
            'user_id' => $customer->id,
        ]);

        Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->assertCount('messages', 5)
            ->assertSet('hasMoreMessages', false);
    }

    public function test_load_older_messages_fetches_the_previous_batch(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $conversation = $this->conversationBetween($admin, $customer);

        $messages = collect(range(1, 25))->map(
            fn (int $i): Message => Message::factory()->create([
                'conversation_id' => $conversation->id,
                'user_id' => $customer->id,
                'content' => "Message {$i}",
            ])
        );

        $component = Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->assertCount('messages', 10);

        $component->call('loadOlderMessages')
            ->assertCount('messages', 20)
            ->assertSet('hasMoreMessages', true);

        $loadedIds = collect($component->get('messages'))->pluck('id')->all();

        $this->assertEquals($messages->slice(5)->pluck('id')->all(), $loadedIds);
    }

    public function test_switch_conversation_resets_pagination(): void
    {
        $admin = $this->adminUser();
        $customer = User::factory()->create();
        $first = $this->conversationBetween($admin, $customer);
        $second = $this->conversationBetween($admin, $customer);

        Message::factory()->count(15)->create([
            'conversation_id' => $first->id,
            'user_id' => $customer->id,
        ]);

        Message::factory()->count(3)->create([
            'conversation_id' => $second->id,
            'user_id' => $customer->id,
        ]);

        $component = Livewire::actingAs($admin)
            ->test(AdminChat::class)
            ->assertCount('messages', 10)
            ->assertSet('hasMoreMessages', true);

        $component->call('switchConversation', $second->id)
            ->assertCount('messages', 3)
            ->assertSet('hasMoreMessages', false);
    }
}
