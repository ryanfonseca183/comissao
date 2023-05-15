<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Decimal implements Rule
{
    private $max_length;
    private $digits;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($max_length, $digits)
    {
        $this->max_length = $max_length;
        $this->digits = $digits;
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
        if(! is_numeric($value)) return false;

        $matches = [];
        preg_match('/^\d*.(\d*)$/', $value, $matches);
        $decimals = strlen(end($matches));
        $integer = strlen(floor($value));

        return $integer <= ($this->max_length - $this->digits) && $decimals == $this->digits;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O campo :attribute deve ter no máximo '. $this->max_length .' digitos com '. $this->digits .' casas decimais';
    }
}
