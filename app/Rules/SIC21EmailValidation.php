<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Str;

class SIC21EmailValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

          if (! Str::contains($domainPart , 'marine.defensecdd.gouv.fr'))
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
        return 'Seul des emails intradef.gouv.fr sont acceptés.';
    }
}
