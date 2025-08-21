<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Laravel\Sanctum\Sanctum;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create());
    }

    public function test_authenticated_user_can_list_their_tasks(): void
    {
        $user = Auth::user();
        Task::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_authenticated_user_can_create_a_task(): void
    {
        $taskData = [
            'title' => 'My first task',
            'description' => 'A description of my task',
            'status' => 'pending',
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
                 ->assertJsonPath('title', 'My first task');

        $this->assertDatabaseHas('tasks', [
            'title' => 'My first task',
            'user_id' => Auth::id(),
        ]);
    }

    public function test_authenticated_user_can_view_their_task(): void
    {
        $user = Auth::user();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('title', $task->title);
    }

    public function test_authenticated_user_cannot_view_another_users_task(): void
    {
        $anotherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(403); // Forbidden
    }

    public function test_authenticated_user_can_update_their_task(): void
    {
        $user = Auth::user();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'status' => 'done'
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('title', 'Updated Title')
                 ->assertJsonPath('status', 'done');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_authenticated_user_cannot_update_another_users_task(): void
    {
        $anotherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Attempted Update',
        ]);

        $response->assertStatus(403);
    }

    public function test_authenticated_user_can_delete_their_task(): void
    {
        $user = Auth::user();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_authenticated_user_cannot_delete_another_users_task(): void
    {
        $anotherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(403);
    }
}