<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\IntradefEmailValidation;

class UpdateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        // Let's get the route param by name to get the User object value
        $user = request()->route('user');

        return [
            'name' => 'required',
            'prenom' => 'required',
            'email' =>  [ 'required', 'email:rfc,dns', Rule::unique('users')->ignore($user->id), new IntradefEmailValidation],
            'matricule' => 'required',
            'date_embarq' => 'required|date',
            'date_debarq' => 'date|nullable',
            'grade_id' => 'required|numeric',
            'specialite_id' => 'required|numeric',
            'diplome_id' => 'required|numeric',
            'secteur_id' => 'required|numeric',
            'unite_destination_id' => 'required|numeric',
            'user_comment' => 'nullable',
            'nid'=>'nullable',
            'comete'=>'nullable',
            'socle'=>'nullable'
            
        ];
    }
}