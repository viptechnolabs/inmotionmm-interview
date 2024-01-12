<?php

namespace App\Http\Controllers\API;

use App\Exceptions\RecordNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ResponseTrait;

    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $filter = $request->get('filter');

        $tasksQuery = Task::query();

        if ($filter === 'completed') {
            $tasksQuery->where('completed', true);
        } elseif ($filter === 'incomplete') {
            $tasksQuery->where('completed', false);
        }

        $tasks = $tasksQuery->get();

        return TaskResource::collection($tasks)
            ->additional([
                'message' => 'Task List',
                'status' => true
            ]);
    }

    public function details($id): \Illuminate\Http\JsonResponse|TaskResource
    {
        $task = Task::find($id);
        if (empty($task)) {
            return $this->error(message: 'Task not found');
        }

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

    public function update(Request $request): \Illuminate\Http\JsonResponse|TaskResource
    {
        // Request params
        $id = $request->input('id');
        $title = $request->input('title');
        $description = $request->input('description');
        $completed = $request->input('completed');

        $task = Task::find($id);
        if (empty($task)) {
            return $this->error(message: 'Task not found');
        }
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
        if (empty($task)) {
            return $this->error(message: 'Task not found');
        }
        $task->delete();
        return $this->success(message: 'Task deleted successfully.');
    }

}
