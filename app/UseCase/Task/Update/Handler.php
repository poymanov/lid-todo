<?php

declare(strict_types=1);

namespace App\UseCase\Task\Update;

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

        $task->title = $command->title;
        $task->description = $command->description;

        if (!$task->save()) {
            throw new Exception(__('task.edit_failed'));
        }
    }
}
