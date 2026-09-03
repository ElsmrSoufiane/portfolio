<?php

namespace Tests\Feature\Filament\Pages;

use App\Filament\Pages\AdminChat;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\UserRole;
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
}
