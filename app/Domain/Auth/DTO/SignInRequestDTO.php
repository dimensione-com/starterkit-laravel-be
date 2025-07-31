<?php

namespace App\Domain\Auth\DTO;

use App\Util\Form;

class SignInRequestDTO extends Form

{
    public function authorize()
    {
        return true; // Consenti a tutti gli utenti di fare la richiesta
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
            // 'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Il campo email è obbligatorio.',
            'email.email' => 'Devi inserire un indirizzo email valido.',
            'password.required' => 'Devi inserire una password.',
            // 'password.min' => 'La password deve contenere almeno 8 caratteri.',
        ];
    }
}
