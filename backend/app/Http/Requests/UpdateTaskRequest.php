<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    /**
     * functionName : rules
     * createdDate  : 21-08-2025
     * purpose      : Validate update task payload
     */
    public function rules(): array
    {
        return [
            'title'       => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
             'status'     => 'sometimes|in:Pending,In Progress,Completed,Under Review,Todo',

            'due_date'    => 'sometimes|nullable|date_format:Y-m-d',
        ];
    }
}
