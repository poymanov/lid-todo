<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Step;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class StepFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Step::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'       => $this->faker->sentence,
            'task_id'     => Task::factory(),
        ];
    }
}
