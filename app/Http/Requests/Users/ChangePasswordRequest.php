<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ChangePasswordRequest extends FormRequest
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
            'password' => 'required|min:6|max:128',
            'passwordConfirm' => 'required|same:password',
        ];
    }


    
    public function messages(): array
    {
        return [

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
