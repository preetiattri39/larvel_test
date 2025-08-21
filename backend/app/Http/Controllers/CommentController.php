<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    use ApiResponse;

    /**
     * functionName : index
     * createdDate  : 21-08-2025
     * purpose      : List comments for a specific task
     */
    public function index(Task $task)
    {
        $comments = $task->comments()->latest()->get();

        return $this->successResponse($comments, 'Comments fetched successfully');
    }

    /**
     * functionName : store
     * createdDate  : 21-08-2025
     * purpose      : Create a new comment for a specific task
     */
    public function store(StoreCommentRequest $request, $taskId)
    {
    $task = Task::findOrFail($taskId); // Throws 404 if not found

    $comment = $task->comments()->create([
        'content'     => $request->content,
        'author_name' => $request->author_name,
    ]);

    return $this->successResponse($comment, 'Comment added successfully');
}
}
