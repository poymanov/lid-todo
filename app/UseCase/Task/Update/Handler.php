<?php

declare(strict_types=1);

namespace App\UseCase\Task\Update;

use App\Models\Step;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\DB;

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

        if (!$command->steps) {
            return;
        }

        DB::beginTransaction();

        if (!$task->steps()->delete()) {
            DB::rollBack();
            throw new Exception(__('step.failed_to_delete'));
        }

        foreach($command->steps as $title) {
            $step = new Step();
            $step->title = $title;
            $step->task_id = $task->id;

            if (!$step->save()) {
                DB::rollBack();
                throw new Exception(__('step.create_failed'));
            }
        }

        DB::commit();
    }
}
