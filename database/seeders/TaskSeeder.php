<?php

namespace Database\Seeders;

use App\Models\Step;
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

        for ($i = 0; $i < 5; $i++) {
            $task = Task::factory()->create(['user_id' => $user->id]);
            Step::factory(10)->create(['task_id' => $task->id]);

            $task = Task::factory()->create(['user_id' => $user->id, 'completed' => true]);
            Step::factory(10)->create(['task_id' => $task->id]);
        }
    }
}
