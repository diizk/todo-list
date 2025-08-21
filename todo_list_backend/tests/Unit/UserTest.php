<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_has_many_tasks(): void
    {
        $user = User::factory()->create();

        $tasks = Task::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $user->tasks);
        $this->assertCount(3, $user->tasks);

        $this->assertTrue($user->tasks->contains($tasks->first()));
    }

    public function test_a_user_has_correct_task_relationship(): void
    {
        $user = User::factory()->create();

        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->tasks->contains($task));
    }
}