<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\SIC21EmailValidation;
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
        $mail_validation = match(config('skeletor.reseau_de_deploiement')){
            "intradef" => new IntradefEmailValidation,
            "sic21"   => new SIC21EmailValidation
        };
        
        return [
            'name' => 'required',
            'prenom' => 'required',
            'email' =>  [ 'required', 'email:rfc', 'unique:users,email', $mail_validation],
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
