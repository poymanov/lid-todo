<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    /**
     * Получение всех задач пользователя, отсортированных по признаку завершения
     *
     * @param int $userId
     * @return Collection
     */
    public function getAllByUserOrderedByCompleted(int $userId): Collection
    {
        return Task::where('user_id', $userId)->orderBy('completed', 'asc')->get();
    }
}
