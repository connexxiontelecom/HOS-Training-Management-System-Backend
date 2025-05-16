<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationHelper
{
    /**
     * Validate the request data against the provided rules.
     *
     * @param array $rules Associative array of validation rules (e.g., ['name' => 'required|string'])
     * @param Request $request The HTTP request containing data to validate
     * @return Validator The validator instance with validation results
     */
    public function validate(array $rules, Request $request): Validator
    {
        return  Validator::make($request->all(), $rules);
    }

    /**
     * Get the first error message from the validator.
     *
     * @param Validator $validator The validator instance
     * @return string|null The first error message, or null if no errors
     */
    public function getFirstError(Validator $validator): ?string
    {
        return $validator->errors()->first();
    }
}
