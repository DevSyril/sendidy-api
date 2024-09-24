<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegistrationRequest extends FormRequest
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
            'username' => 'required|min:3|max:16|unique:users',
            'email' => 'required|min:6|max:128|email|unique:users',
            'password' => 'required|min:6|max:128',
            'passwordConfirm' => 'required|same:password',
        ];
    }


    public function messages(): array
    {
        return [

            'email.required' => 'L\'adresse E-mail de l\'utilisateur est requis.',
            'email.min' => 'L\'adresse E-mail doit comporter au minimum 6 caractères',
            'email.max' => 'L\'adresse E-mail ne peut excéder au maximum 128 caractères.',
            'email.email' => 'L\'adresse E-mail renseigné n\'est pas valide',
            'email.unique' => 'L\'adresse E-mail renseigné a déjà été utilisé',

            'username.required' => 'Le nom d\'utilisateur est requis.',
            'username.min' => 'Le nom d\'utilisateur doit comporter au minimum 3 caractères',
            'username.max' => 'Le nom d\'utilisateur ne peut excéder au maximum 16 caractères.',
            'username.unique' => 'Le nom d\'utilisateur a déjà été utilisé',

            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit comporter au minimum 6 caractères',
            'password.max' => 'Le mot de passe ne peut excéder au maximum 128 caractères.',

            'passwordConfirm.required' => 'Le champs de confirmation du mot de passe est requis.',
            'passwordConfirm.same' => 'Les deux mots de passes ne sont pas identiques.',
        ];
    }


    public function failedValidation(validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Echec de validation.',
            'data' => $validator->errors()
        ]));
    }
}
