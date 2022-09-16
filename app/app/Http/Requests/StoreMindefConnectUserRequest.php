<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\IntradefEmailValidation;

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
            'email' =>  [ 'required', 'email:rfc,dns', 'unique:users,email', new IntradefEmailValidation],
            // 'matricule' => 'required',
            'date_embarq' => 'required|date', 
            'date_debarq' => 'date|nullable',
            'grade_id' => 'required|numeric',
            'specialite_id' => 'required|numeric',
            'diplome_id' => 'required|numeric',
            'secteur_id' => 'required|numeric',
            'unite_destination_id' => 'required|numeric',
        ];
    }
}
