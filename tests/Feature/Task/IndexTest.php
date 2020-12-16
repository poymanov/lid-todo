<?php

declare(strict_types=1);

namespace Tests\Feature\Task;

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
}
