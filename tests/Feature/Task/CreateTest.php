<?php

declare(strict_types=1);

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    private const CREATE_TASK_URL = '/tasks/create';

    /**
     * Попытка доступа неавторизованного пользователя
     */
    public function test_guest_has_not_access()
    {
        $response = $this->get(self::CREATE_TASK_URL);
        $response->assertRedirect('login');
    }

    /**
     * Страница создания новой задачи открывается без ошибок
     */
    public function test_create_task_page_can_be_rendered()
    {
        $this->signIn();
        $response = $this->get(self::CREATE_TASK_URL);
        $response->assertSuccessful();
    }

    /**
     * На странице создания новой задачи отображается заголовок
     */
    public function test_create_task_page_header_can_be_rendered()
    {
        $this->signIn();
        $response = $this->get(self::CREATE_TASK_URL);
        $response->assertSee('Новая задача');
    }

    /**
     * Отображение формы создания новой задачи
     */
    public function test_form()
    {
        $this->signIn();
        $response = $this->get(self::CREATE_TASK_URL);

        $response->assertSee('Название');
        $response->assertSee('Описание');
        $response->assertSee('Создать');
    }

    /**
     * Попытка создания задачи с пустыми данными
     */
    public function test_validation_failed_empty()
    {
        $this->signIn();

        $this->post(self::CREATE_TASK_URL)->assertSessionHasErrors([
            'title',
            'description',
        ]);
    }

    /**
     * Успешное создание задачи
     */
    public function test_create_successful()
    {
        $user = User::factory()->create();
        $this->signIn($user);

        $task = Task::factory()->makeOne();
        $response = $this->post(self::CREATE_TASK_URL, $task->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('alert.success');

        $this->assertDatabaseHas('tasks', [
            'title' => $task->title,
            'description' => $task->description,
            'user_id' => $user->id,
            'completed' => 0,
        ]);

        $response->assertRedirect('/tasks');
    }
}
