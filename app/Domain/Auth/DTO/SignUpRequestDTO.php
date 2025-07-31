<?php

namespace App\Domain\Auth\DTO;

use App\Util\Form;

class SignUpRequestDTO extends Form
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:30',
            'surname' => 'required|string|max:30',
            'email' => 'required|string|email|unique:users,email|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Il nome è richiesto',
            'name.string' => 'Il nome deve essere una stringa',
            'name.max' => 'Il nome deve essere massimo di 30 caratteri',
            'surname.required' => 'Il cognome è richiesto',
            'surname.string' => 'Il cognome deve essere una stringa',
            'surname.max' => 'Il cognome deve essere massimo 30 caratteri',
            'email.required' => 'Il campo email è obbligatorio.',
            'email.email' => 'Devi inserire un indirizzo email valido.',
            'password.required' => 'Devi inserire una password.',
            'password.min' => 'Devi inserire un password.',
            'password.string' => 'Devi inserire un password.',
            'confirm_password.required' => 'Devi inserire una password di conferma password.',
            'confirm_password.same' => 'Le password non corrispondono.',
            'username.required' => 'Devi inserire un nome utente.',
            'username.string' => 'Devi inserire un nome utente.',
            'username.max' => 'Il nome utente deve esser una max 255.',
            // 'password.min' => 'La password deve contenere almeno 8 caratteri.',
        ];
    }
}
