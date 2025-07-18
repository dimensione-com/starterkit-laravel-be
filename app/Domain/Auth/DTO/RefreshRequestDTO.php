<?php

namespace App\Domain\Auth\DTO;

use App\Util\Form;

class RefreshRequestDTO extends Form
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'refresh_token' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'refresh_token.required' => 'Il refresh token è obbligatorio',
            'refresh_token.string' => 'Il refresh token deve essere una stringa',
        ];
    }
}
