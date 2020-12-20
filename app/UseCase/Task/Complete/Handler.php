<?php

declare(strict_types=1);

namespace App\UseCase\Task\Complete;

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

        if ($task->completed) {
            throw new Exception(__('task.already_completed'));
        }

        $task->completed = true;

        if (!$task->save()) {
            throw new Exception(__('task.complete_failed'));
        }
    }
}
