<?php

declare(strict_types=1);

namespace App\UseCase\Task\Delete;

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

        if (!$task->delete()) {
            throw new Exception(__('task.delete_failed'));
        }
    }
}
