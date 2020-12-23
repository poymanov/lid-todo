<?php

declare(strict_types=1);

namespace App\UseCase\Task\Delete;

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

        DB::beginTransaction();

        if ($task->steps()->exists()) {
            if (!$task->steps()->delete()) {
                DB::rollBack();
                throw new Exception(__('step.failed_to_delete'));
            }
        }

        if (!$task->delete()) {
            DB::rollBack();
            throw new Exception(__('task.delete_failed'));
        }

        DB::commit();
    }
}
