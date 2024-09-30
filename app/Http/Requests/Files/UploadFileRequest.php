<?php

namespace App\Http\Requests\Files;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UploadFileRequest extends FormRequest
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
            'file' => 'required|file|mimes:jpeg,jpg,png,docx,pdf,gif,mp4,mp3,xlsx|max:10000000'
        ];
    }


    public function messages(): array
    {
        return [
            'file.required' => 'Vous n\'avez téléchargé aucun fichier',
            'file.file' => 'Le format de la ressource envoyée n\'est pas autorisée',
            'file.mimes' => 'Le format du fichier n\'est pas pris en charge',
            'file.max' => 'La taille du fichier téléchargé ne peut excéder 10 Mo',
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
