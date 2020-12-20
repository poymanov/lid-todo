<?php

declare(strict_types=1);

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompleteTest extends TestCase
{
    use RefreshDatabase;

    private const BASE_URL = '/tasks/';

    /**
     * Попытка доступа неавторизованного пользователя
     */
    public function test_guest_has_not_access()
    {
        $task = Task::factory()->create();

        $response = $this->patch(self::BASE_URL . $task->id . '/complete');
        $response->assertRedirect('login');
    }

    /**
     * Попытка завершения несуществующей задачи
     */
    public function test_not_existed_task()
    {
        $this->signIn();

        $response = $this->patch(self::BASE_URL . '999/complete');
        $response->assertNotFound();
    }

    /**
     * Попытка завершения задачи другого пользователя
     */
    public function test_complete_another_user()
    {
        $this->signIn();

        $task = Task::factory()->create();
        $response = $this->patch(self::BASE_URL . $task->id . '/complete');
        $response->assertForbidden();
    }

    /**
     * Попытка завершения задачи, которая уже завершена
     */
    public function test_complete_already_completed()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id, 'completed' => true]);
        $response = $this->patch(self::BASE_URL . $task->id . '/complete');

        $response->assertSessionHas('alert.error');
        $response->assertRedirect('/tasks');
    }

    /**
     * Успешное завершение задачи
     */
    public function test_complete_successful()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id]);
        $response = $this->patch(self::BASE_URL . $task->id . '/complete');

        $response->assertSessionHas('alert.success');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => 1
        ]);

        $response->assertRedirect('/tasks');
    }
}
