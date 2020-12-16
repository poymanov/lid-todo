<?php

declare(strict_types=1);

namespace Tests\Feature\Dashboard;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    private const DASHBOARD_URL = '/dashboard';

    /**
     * Попытка доступа неавторизованного пользователя
     */
    public function test_guest_has_not_access()
    {
        $response = $this->get(self::DASHBOARD_URL);
        $response->assertRedirect('login');
    }

    /**
     * Стартовая страница личного кабинета открывается без ошибок
     */
    public function test_dashboard_can_be_rendered()
    {
        $this->signIn();
        $response = $this->get(self::DASHBOARD_URL);
        $response->assertSuccessful();
    }
}
