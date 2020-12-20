<?php

declare(strict_types=1);

namespace App\UseCase\Task\Incomplete;

use App\Models\Task;
use Exception;

class Handler
{
    public function handle(Command $command): void
    {
        $task = Task::find($command->id);

        if (!$task) {
            throw new Exception(__('task.not_found'));
        }

        if (!$task->completed) {
            throw new Exception(__('task.already_incomplete'));
        }

        $task->completed = false;

        if (!$task->save()) {
            throw new Exception(__('task.incomplete_failed'));
        }
    }
}
