<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\SIC21EmailValidation;

class StoreMindefConnectUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'prenom' => 'required',
            'email' =>  [ 'required', 'email:rfc,dns', 'unique:users,email', new SIC21EmailValidation],
            // 'matricule' => 'required',
            'date_embarq' => 'required|date', 
            'date_debarq' => 'date|nullable',
            'grade_id' => 'nullable',
            'specialite_id' => 'nullable',
            'diplome_id' => 'nullable',
            'secteur_id' => 'nullable',
            'unite_id' => 'nullable',
            'unite_destination_id' => 'nullable',
        ];
    }
}
