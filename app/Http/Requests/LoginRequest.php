<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function getCredentials()
    {
        return $this->only('email', 'password');
    }

    /**
     * Validate if provided parameter is valid email.
     *
     * @return bool
     *
     * @throws BindingResolutionException
     */
    private function isEmail($param)
    {
        $factory = $this->container->make(ValidationFactory::class);

        return !$factory->make(
            ['username' => $param],
            ['username' => 'email']
        )->fails();
    }
}
