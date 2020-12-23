<?php

declare(strict_types=1);

namespace Tests\Feature\Task;

use App\Models\Step;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;

    private const BASE_URL = '/tasks/';

    /**
     * Попытка доступа неавторизованного пользователя
     */
    public function test_guest_has_not_access()
    {
        $task = Task::factory()->create();

        $response = $this->delete(self::BASE_URL . $task->id);
        $response->assertRedirect('login');
    }

    /**
     * Удаление несуществующей задачи
     */
    public function test_not_existed_task()
    {
        $this->signIn();

        $response = $this->delete(self::BASE_URL . '999');
        $response->assertNotFound();
    }

    /**
     * Попытка удаления задачи другого пользователя
     */
    public function test_delete_another_user()
    {
        $this->signIn();

        $task = Task::factory()->create();
        $response = $this->delete(self::BASE_URL . $task->id);
        $response->assertForbidden();
    }

    /**
     * Успешное удаление задачи
     */
    public function test_delete_successful()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id]);
        $response = $this->delete(self::BASE_URL . $task->id);

        $response->assertSessionHas('alert.success');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);

        $response->assertRedirect('/tasks');
    }

    /**
     * Успешное удаление задачи вместе с шагами
     */
    public function test_delete_successful_with_steps()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id]);
        $stepFirst = Step::factory()->create(['task_id' => $task->id]);
        $stepSecond = Step::factory()->create(['task_id' => $task->id]);

        $response = $this->delete(self::BASE_URL . $task->id);

        $response->assertSessionHas('alert.success');

        $this->assertDatabaseMissing('steps', [
            'id' => $stepFirst->id,
        ]);

        $this->assertDatabaseMissing('steps', [
            'id' => $stepSecond->id,
        ]);

        $response->assertRedirect('/tasks');
    }
}
