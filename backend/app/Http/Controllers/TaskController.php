<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    use ApiResponse;

    /**
     * functionName : index
     * createdDate  : 21-08-2025
     * purpose      : List tasks with optional filters and pagination
     * Query params : status, due_date_from, due_date_to, search, sort_by, sort_dir
     */
    public function index(Request $request)
    {
        $query = Task::query();
    
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
            if ($request->filled('due_date_from') && $request->filled('due_date_to')) {
            $query->whereBetween('due_date', [
                $request->get('due_date_from'),
                $request->get('due_date_to')
            ]);
        } elseif ($request->filled('due_date_from')) {
            $query->where('due_date', '>=', $request->get('due_date_from'));
        } elseif ($request->filled('due_date_to')) {
            $query->where('due_date', '<=', $request->get('due_date_to'));
        }
            if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        if (in_array($sortBy, ['created_at','due_date','title','status']) &&
            in_array($sortDir, ['asc','desc'])) {
            $query->orderBy($sortBy, $sortDir);
        }
    
        $tasks = $query->get();
    
        return $this->successResponse($tasks, 'Task list fetched successfully');
    }
    

    /**
     * functionName : store
     * createdDate  : 21-08-2025
     * purpose      : Create a new task
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());
        return $this->successResponse($task, 'Task created successfully', 201);
    }

    /**
     * functionName : show
     * createdDate  : 21-08-2025
     * purpose      : Get a task by id with comments
     */
    public function show(Task $task)
    {
        $task->load(['comments']);
        return $this->successResponse($task, 'Task details fetched successfully');
    }

    /**
     * functionName : update
     * createdDate  : 21-08-2025
     * purpose      : Update a task by id
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return $this->successResponse($task, 'Task updated successfully');
    }

    /**
     * functionName : destroy
     * createdDate  : 21-08-2025
     * purpose      : Delete a task by id
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
