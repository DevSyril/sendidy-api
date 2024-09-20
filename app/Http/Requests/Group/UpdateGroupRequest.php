<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateGroupRequest extends FormRequest
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
            'name' => 'min:6|max:128',
            'description' => 'min:10|max:255',
            'profilePhoto' => 'file|mimes:jpeg,jpg,png|max:2000000'
        ];
    }

    public function messages(): array
    {
        return [

            'name.min' => 'Le nom du groupe doit comporter au minimum 6 caractères',
            'name.max' => 'Le nom du groupe ne peut excéder au maximum 128 caractères.',

            'description.min' => 'La description du groupe doit comporter au minimum 6 caractères',
            'description.max' => 'La description du groupe ne peut excéder au maximum 128 caractères.',

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
