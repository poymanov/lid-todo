<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Task\CreateRequest;
use App\UseCase\Task\Create;

class TaskController extends Controller
{
    public function index()
    {
        return view('task.index');
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
}
