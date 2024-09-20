<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class CreateGroupRequest extends FormRequest
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
            'name' => 'required|min:6|max:128|unique:groups',
            'description' => 'required|min:10|max:255',
        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Le nom du groupe est requis.',
            'name.min' => 'Le nom du groupe doit comporter au minimum 6 caractères',
            'name.max' => 'Le nom du groupe ne peut excéder au maximum 128 caractères.',
            'name.unique' => 'Il semblerait que ce nom ne soit plus disponible.',

            'description.required' => 'La description du groupe est requise.',
            'description.min' => 'La description du groupe doit comporter au minimum 6 caractères',
            'description.max' => 'La description du groupe ne peut excéder au maximum 128 caractères.',

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
