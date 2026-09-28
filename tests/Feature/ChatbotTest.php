<?php

namespace Tests\Feature;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    use RefreshDatabase;

    public function test_chatbot_returns_a_local_reply_when_openai_key_is_missing(): void
    {
        config([
            'chatbot.enabled' => true,
            'chatbot.provider' => 'openai',
            'services.openai.key' => null,
        ]);

        $response = $this->post(route('chat.message'), [
            'session_id' => 'test-session-123',
            'message' => 'hello',
        ]);

        $response->assertOk();
        $this->assertStringContainsString('Hi! I\'m the FanHub assistant.', $response->streamedContent());
        $this->assertDatabaseHas('chat_messages', ['sender' => 'user', 'message' => 'hello']);
        $this->assertDatabaseHas('chat_messages', ['sender' => 'bot']);
    }

    public function test_authenticated_user_cannot_read_another_users_chat_history(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $session = ChatSession::create([
            'session_id' => 'private-chat-session',
            'user_id' => $owner->id,
        ]);
        ChatMessage::create([
            'chat_session_id' => $session->id,
            'sender' => 'bot',
            'message' => 'Private reply',
            'created_at' => now(),
        ]);

        $this->actingAs($otherUser)
            ->getJson(route('chat.history', ['session_id' => $session->session_id]))
            ->assertForbidden();
    }
}
