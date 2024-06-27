<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoBlankSpace implements Rule
{
    public function passes($attribute, $value)
    {
        return trim($value) !== '';
    }

    public function message()
    {
        return 'The :attribute field cannot contain only blank spaces.';
    }
}
