<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\UseCase\Task\Create;
use App\UseCase\Task\Update;

class TaskController extends Controller
{
    /**
     * @var TaskService
     */
    private TaskService $taskService;

    /**
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->getAllByUserOrderedByCompleted(auth()->id());

        return view('task.index', compact('tasks'));
    }

    public function create()
    {
        return view('task.create');
    }

    public function store(CreateRequest $request, Create\Handler $handler)
    {
        $command = new Create\Command();
        $command->title = $request->get('title');
        $command->description = $request->get('description');
        $command->userId = (int) auth()->id();

        try {
            $handler->handle($command);
        } catch (\Throwable $e) {
            return back()->with('create-failed', $e->getMessage());
        }

        return redirect(route('task.index'))->with('alert.success', __('task.created_successfully'));
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return view('task.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        return view('task.edit', compact('task'));
    }

    public function update(UpdateRequest $request, Task $task, Update\Handler $handler)
    {
        $this->authorize('update', $task);

        $command = new Update\Command();
        $command->id = $task->id;
        $command->title = $request->get('title');
        $command->description = $request->get('description');

        try {
            $handler->handle($command);
        } catch (\Throwable $e) {
            return back()->with('update-failed', $e->getMessage());
        }

        return redirect(route('task.index'))->with('alert.success', __('task.updated_successfully'));
    }
}
