<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ResponseTrait;

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $tasks = Task::all();
        return TaskResource::collection($tasks)
            ->additional([
                'message' => 'Task List',
                'status' => true
            ]);
    }

    public function details($id): TaskResource
    {
        $task = Task::findOrFail($id)->first();

        return (new TaskResource($task))
            ->additional([
                'message' => 'Task Details',
                'status' => true
            ]);
    }

    public function store(Request $request): TaskResource
    {
        // Request params
        $title = $request->input('title');
        $description = $request->input('description');
        $completed = $request->input('completed');

        $task = new Task();
        $task->title = $title;
        $task->description = $description;
        $task->completed = $completed;
        $task->save();

        return (new TaskResource($task))
            ->additional([
                'message' => 'Task added successfully',
                'status' => true
            ]);
    }

    public function update(Request $request): TaskResource
    {
        // Request params
        $id = $request->input('id');
        $title = $request->input('title');
        $description = $request->input('description');
        $completed = $request->input('completed');

        $task = Task::find($id);
        $task->title = $title;
        $task->description = $description;
        $task->completed = $completed;
        $task->save();

        return (new TaskResource($task))
            ->additional([
                'message' => 'Task updated successfully',
                'status' => true
            ]);
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->error(message: 'Task not found');
        }
        $task->delete();
        return $this->success(message: 'Task deleted successfully.');
    }

}
