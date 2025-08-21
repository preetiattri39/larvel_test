<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    /**
     * functionName : rules
     * createdDate  : 21-08-2025
     * purpose      : Validate new comment payload
     */
    public function rules(): array
    {
        return [
            'content'     => 'required|string',
            'author_name' => 'required|string|max:120',
        ];
    }
}
