<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FromTimeBeforeToTimeValidation implements Rule
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
        $fromTime = request($attribute);
        $toTime = request('to_time');

        return strtotime($toTime) > strtotime($fromTime);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The "to_time" must be After the "from_time".';
    }
}
