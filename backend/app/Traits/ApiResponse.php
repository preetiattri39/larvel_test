<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * functionName : successResponse
     * createdDate  : 21-08-2025
     * purpose      : Send a successful JSON response with data
     */
    protected function successResponse($data = [], $message = 'Success', $code = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    /**
     * functionName : errorResponse
     * createdDate  : 21-08-2025
     * purpose      : Send an error JSON response with optional errors
     */
    protected function errorResponse($message = 'Something went wrong', $code = 400, $errors = [])
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors
        ], $code);
    }

    /**
     * functionName : validationErrorResponse
     * createdDate  : 21-08-2025
     * purpose      : Send validation error response with 422 status code
     */
    protected function validationErrorResponse($errors, $message = 'Validation Error')
    {
        return $this->errorResponse($message, 422, $errors);
    }

    /**
     * functionName : notFoundResponse
     * createdDate  : 21-08-2025
     * purpose      : Send not found response with 404 status code
     */
    protected function notFoundResponse($message = 'Resource not found')
    {
        return $this->errorResponse($message, 404);
    }
}
