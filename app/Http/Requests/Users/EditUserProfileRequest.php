<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EditUserProfileRequest extends FormRequest
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
            'username' => 'min:3|max:16',
            'password' => 'min:6|max:128',
            'phoneNumber' => 'min:6|max:30',
            'passwordConfirm' => 'same:password',
            'profilePhoto' => 'file|mimes:jpeg,jpg,png|max:2000000',
        ];
    }


    public function messages(): array
    {
        return [

            'username.min' => 'Le nom d\'utilisateur doit comporter au minimum 3 caractères',
            'username.max' => 'Le nom d\'utilisateur ne peut excéder au maximum 16 caractères.',
            'username.unique' => 'Le nom d\'utilisateur a déjà été utilisé',

            'password.min' => 'Le mot de passe doit comporter au minimum 6 caractères',
            'password.max' => 'Le mot de passe ne peut excéder au maximum 128 caractères.',

            'phoneNumber.min' => 'Le numeero de téléphone doit comporter au minimum 6 caractères',
            'phoneNumber.max' => 'Le numero de téléphone ne peut excéder au maximum 128 caractères.',

            'passwordConfirm.same' => 'Les deux mots de passes ne sont pas identiques.',

            'profilePhoto.file' => 'La ressource envoyée n\'est pas autorisée',
            'profilePhoto.mimes' => 'Le format de l\'image ,n\'est pas pris en charge',
            'profilePhoto.max' => 'L\'image téléchargé ne peut excéder 2 Mo',
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
