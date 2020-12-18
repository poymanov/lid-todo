<?php

declare(strict_types=1);

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    private const TASKS_URL = '/tasks';

    /**
     * Попытка доступа неавторизованного пользователя
     */
    public function test_guest_has_not_access()
    {
        $response = $this->get(self::TASKS_URL);
        $response->assertRedirect('login');
    }

    /**
     * Страница с задачами открывается без ошибок
     */
    public function test_dashboard_can_be_rendered()
    {
        $this->signIn();
        $response = $this->get(self::TASKS_URL);
        $response->assertSuccessful();
    }

    /**
     * На странице с задачами есть кнопка добавления новой задачи
     */
    public function test_create_button_rendered()
    {
        $this->signIn();
        $response = $this->get(self::TASKS_URL);
        $response->assertSee('Создать');
    }

    /**
     * На странице с задачами отображаются колонки для таблицы с данными
     */
    public function test_table_columns_rendered()
    {
        $this->signIn();
        $response = $this->get(self::TASKS_URL);

        $response->assertSee('Наименование');
        $response->assertSee('Статус');
    }

    /**
     * Отображение задач
     */
    public function test_tasks_rendered()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $taskFirst = Task::factory()->create(['user_id' => $user->id]);
        $taskSecond = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->get(self::TASKS_URL);
        $response->assertSee($taskFirst->title);
        $response->assertSee($taskSecond->title);
    }

    /**
     * Отображение задач определенного пользователя
     */
    public function test_particular_user_tasks_rendered()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $taskFirst = Task::factory()->create(['user_id' => $user->id]);
        $taskSecond = Task::factory()->create(['user_id' => $user->id]);
        $taskThird = Task::factory()->create();
        $taskFourth = Task::factory()->create();

        $response = $this->get(self::TASKS_URL);
        $response->assertSee($taskFirst->title);
        $response->assertSee($taskSecond->title);
        $response->assertDontSee($taskThird->title);
        $response->assertDontSee($taskFourth->title);
    }
}
