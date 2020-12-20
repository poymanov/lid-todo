<?php

declare(strict_types=1);

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncompleteTest extends TestCase
{
    use RefreshDatabase;

    private const BASE_URL = '/tasks/';

    /**
     * Попытка доступа неавторизованного пользователя
     */
    public function test_guest_has_not_access()
    {
        $task = Task::factory()->create();

        $response = $this->patch(self::BASE_URL . $task->id . '/incomplete');
        $response->assertRedirect('login');
    }

    /**
     * Попытка отмены завершения несуществующей задачи
     */
    public function test_not_existed_task()
    {
        $this->signIn();

        $response = $this->patch(self::BASE_URL . '999/incomplete');
        $response->assertNotFound();
    }

    /**
     * Попытка отмены завершения задачи другого пользователя
     */
    public function test_incomplete_another_user()
    {
        $this->signIn();

        $task = Task::factory()->create();
        $response = $this->patch(self::BASE_URL . $task->id . '/incomplete');
        $response->assertForbidden();
    }

    /**
     * Попытка отмены завершения задачи, которая уже еще не завершена
     */
    public function test_incomplete_already_completed()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id]);
        $response = $this->patch(self::BASE_URL . $task->id . '/incomplete');

        $response->assertSessionHas('alert.error');
        $response->assertRedirect('/tasks');
    }

    /**
     * Успешная отмена завершения задачи
     */
    public function test_incomplete_successful()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id, 'completed' => true]);
        $response = $this->patch(self::BASE_URL . $task->id . '/incomplete');

        $response->assertSessionHas('alert.success');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => 0
        ]);

        $response->assertRedirect('/tasks');
    }
}
