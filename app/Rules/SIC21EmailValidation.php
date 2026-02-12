<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Str;

class SIC21EmailValidation implements Rule
{
    public string $validDomain;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->validDomain = config('services.sic21.mail_tld');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $domainPart = explode('@', $value)[1] ?? null;
        

          if (!$domainPart) {
            return false;
          }

          if (! Str::contains($domainPart , $this->validDomain))
          {
              return false;
          }

          return true;
        }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $validDomain = $this->validDomain;
        return "Seul des emails {$validDomain} sont acceptés.";
    }
}
