<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;

class IntradefEmailValidation implements Rule
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

          if ($domainPart != 'intradef.gouv.fr')
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
