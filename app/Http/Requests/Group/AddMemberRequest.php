<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class AddMemberRequest extends FormRequest
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
            'member_email' => 'required|min:6|max:128|email|',
        ];
    }

    public function messages(): array
    {
        return [

            'email.required' => 'L\'adresse E-mail de l\'utilisateur est requis.',
            'email.min' => 'L\'adresse E-mail doit comporter au minimum 6 caractères',
            'email.max' => 'L\'adresse E-mail ne peut excéder au maximum 128 caractères.',
            'email.email' => 'L\'adresse E-mail renseigné n\'est pas valide',
            'member_email.unique' => 'Il semblerait qu\'un membre utilise déjà cette adresse.',

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
