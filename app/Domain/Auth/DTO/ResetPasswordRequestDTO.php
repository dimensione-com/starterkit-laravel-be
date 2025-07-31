<?php

namespace App\Domain\Auth\DTO;

use App\Util\Form;

class ResetPasswordRequestDTO extends Form
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'token' => 'string|required|max:64',
            'password' => 'string|required',
            'password_confirmation' => 'string|required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'token.required' => 'Token obbligatorio',
            'token.string' => 'Il token deve essere una stringa',
            'token.max' => 'Il token deve essere massimo di 64 caratteri',
            'password.required' => 'La password obbligatoria',
            'password.string' => 'La password deve essere una stringa',
            'password_confirmation.required' => 'La password obbligatoria',
            'password_confirmation.string' => 'La password deve essere una stringa',
            'password_confirmation.same' => 'La password deve essere uguale alla password',
        ];
    }
}
