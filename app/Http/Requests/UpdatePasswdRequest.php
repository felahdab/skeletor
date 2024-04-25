<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		// L'utilisateur a le droit de modifier son propre mot de passe
		// meme s'il n'a pas d'autre autorisation.
		if (intval($this->input('userid')) == auth()->user()->id) 
			return true;
		// Dans tous les autres cas, il faut que l'utilisateur ait l'autorisation
		// de modifier le mot de passe des autres.
		if (auth()->user()->hasPermissionTo('changepasswd.allusers') || auth()->user()->IsSuperAdmin())
		{
			return true;
		}
		else {
			return false;
		}
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'userid'   => 'required|int',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ];
    }
}
