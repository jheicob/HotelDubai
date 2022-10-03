<?php

namespace App\Traits;

trait CustomResponseFormRequestTrait {
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $message = collect($validator->errors())->flatten();
        $response = custom_response_error(422, 'error validation', $message,422);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
