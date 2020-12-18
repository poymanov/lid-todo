<?php

declare(strict_types=1);

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private const BASE_URL = '/tasks/';

    /**
     * Попытка доступа неавторизованного пользователя
     */
    public function test_guest_has_not_access()
    {
        $task = Task::factory()->create();

        $response = $this->get(self::BASE_URL . $task->id . '/edit');
        $response->assertRedirect('login');
    }

    /**
     * Страница редактирования несуществующей задачи не открывается
     */
    public function test_not_existed_task()
    {
        $this->signIn();

        $response = $this->get(self::BASE_URL . '999/edit');
        $response->assertNotFound();
    }

    /**
     * На странице редактирования задачи выводятся данные по этой задаче
     */
    public function test_form()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->get(self::BASE_URL . $task->id . '/edit');

        $response->assertSee($task->title);
        $response->assertSee($task->description);
    }

    /**
     * Попытка просмотра страницы редактирования задачи другого пользователя
     */
    public function test_another_user_task_edit_page()
    {
        $this->signIn();

        $task = Task::factory()->create();

        $response = $this->get(self::BASE_URL . $task->id . '/edit');
        $response->assertForbidden();
    }

    /**
     * Попытка редактирования задачи с пустыми данными
     */
    public function test_validation_failed_empty()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->patch(self::BASE_URL . $task->id)->assertSessionHasErrors([
            'title',
            'description',
        ]);
    }

    /**
     * Попытка редактирования задачи со слишком длинным названием
     */
    public function test_validation_failed_long_title()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->patch(self::BASE_URL . $task->id, [
            'title' => $this->faker->sentence(200),
            'description' => 'test'
        ])->assertSessionHasErrors([
            'title',
        ]);
    }

    /**
     * Успешное редактирование задачи
     */
    public function test_update_successful()
    {
        $title = 'test';
        $description = 'test';

        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id]);
        $response = $this->patch(self::BASE_URL . $task->id, compact('title', 'description'));

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('alert.success');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $title,
            'description' => $description,
        ]);

        $response->assertRedirect('/tasks');
    }
}
