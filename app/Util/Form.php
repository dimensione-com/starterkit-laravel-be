<?php

namespace App\Util;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Form extends FormRequest
{
    public function rules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function getIpAddress(): string
    {
        if ($this->header('Client-Ip')) {
            return $this->header('Client-Ip');
        }
        return $this->ip();
    }

    public function getHeaderByName(string $headerName): string
    {
        if ($this->header($headerName)) {
            return $this->header($headerName);
        }
        return $this->ip();
    }

    protected function failedValidation(Validator $validator)
    {
//        $errors = $validator->errors();
//        $mapped_errors = $errors->all();
//        if (isset($mapped_errors) && str_contains($mapped_errors[0], 'registrato')) {
//            $result = [
//                'result' => false,
//                'error_message' => "Email già in uso",
//                'error_code' => 409,
//                'validation_errors' => $errors
//            ];
//            throw new HttpResponseException(response()->json($result, 409));
//        } else {
//            $result = [
//                'result' => false,
//                'error_message' => "Validation errors",
//                'error_code' => 400,
//                'validation_errors' => $errors
//            ];
//            throw new HttpResponseException(response()->json($result, 400));
//        }
        throw new HttpResponseException(response()->json([
            'message' => 'Errori di validazione',
            'errors' => $validator->errors(),
        ], 422));
    }

    protected function failedAuthorization()
    {
        $result = [
            'message' => "You must be authenticated to access to this request",
        ];
        throw new HttpResponseException(response()->json($result, 401));
    }
}
