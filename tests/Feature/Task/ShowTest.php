<?php

declare(strict_types=1);

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    private const BASE_URL = '/tasks/';

    /**
     * Попытка доступа неавторизованного пользователя
     */
    public function test_guest_has_not_access()
    {
        $response = $this->get(self::BASE_URL);
        $response->assertRedirect('login');
    }

    /**
     * Страница просмотра несуществующей задачи не открывается
     */
    public function test_not_existed_task()
    {
        $this->signIn();

        $response = $this->get(self::BASE_URL . '999');
        $response->assertNotFound();
    }

    /**
     * Страница просмотра задачи открывается без ошибок
     */
    public function test_show_task_page_can_be_rendered()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->get(self::BASE_URL . $task->id);
        $response->assertSuccessful();
    }

    /**
     * На странице просмотра задачи выводятся данные по этой задаче
     */
    public function test_show_task_page_with_task_data_rendered()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->get(self::BASE_URL . $task->id);
        $response->assertSee($task->title);
        $response->assertSee($task->description);

    }

    /**
     * Попытка просмотра задачи другого пользователя
     */
    public function test_another_user_task_show_page()
    {
        $this->signIn();

        $task = Task::factory()->create();

        $response = $this->get(self::BASE_URL . $task->id);
        $response->assertForbidden();
    }
}
