<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6|max:128'
        ];
    }

    public function messages(): array
    {
        return [
            
            'email.required' => 'L\'adresse E-mail de l\'utilisateur est requis.',
            'email.email' => 'L\'adresse E-mail renseigné n\'est pas valide',

            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit comporter au minimum 6 caractères',
            'password.max' => 'Le mot de passe ne peut excéder au maximum 128 caractères.',

        ];
    }


    public function failedValidation(validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Echec de validation.',
            'data'      => $validator->errors()
        ]));
    }
}
