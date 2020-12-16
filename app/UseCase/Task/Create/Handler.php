<?php

declare(strict_types=1);

namespace App\UseCase\Task\Create;

use App\Models\Task;
use App\Models\User;
use Exception;

class Handler
{
    public function handle(Command $command): void
    {
        $user = User::find($command->userId);

        if (!$user) {
            throw new Exception(__('task.create_user_failed'));
        }

        $task = new Task();
        $task->title = $command->title;
        $task->description = $command->description;
        $task->user_id = $user->id;

        if (!$task->save()) {
            throw new Exception(__('task.create_failed'));
        }
    }
}
