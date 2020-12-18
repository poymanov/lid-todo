<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create(['email' => 'test@test.ru']);

        Task::factory(5)->create(['user_id' => $user->id]);
        Task::factory(5)->create(['user_id' => $user->id, 'completed' => true]);
    }
}
