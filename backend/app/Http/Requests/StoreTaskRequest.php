<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    /**
     * functionName : rules
     * createdDate  : 21-08-2025
     * purpose      : Validate new task payload
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:Pending,In Progress,Completed,Under Review,Todo',
            'due_date'    => 'nullable|date_format:Y-m-d',
        ];
    }
}
