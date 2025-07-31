<?php

namespace App\Domain\Auth\DTO;

use App\Util\Form;

class SendEmailVerificationRequestDTO extends Form
{
    public function authorize()
    {
        return true; // Consenti a tutti gli utenti di fare la richiesta
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255|exists:users,email',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Il campo email è obbligatorio.',
            'email.email' => 'Devi inserire un indirizzo email valido.',
            'email.exists' => 'La email che hai inserito non esiste.'
        ];
    }
}

