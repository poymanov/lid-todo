<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * Главная страница открывается без ошибок
     *
     * @return void
     */
    public function test_home_page_can_be_rendered()
    {
        $response = $this->get('/');
        $response->assertSuccessful();
    }
}
