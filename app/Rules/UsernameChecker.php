<?php

namespace app\Rules;

use Illuminate\Contracts\Validation\Rule;
use app\Models\mUser;

class UsernameChecker implements Rule
{
    private $value = '';

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
        $this->value = $value;
        $count = mUser::where('username', $value)->count();
        if($count > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Username \"<strong>".$this->value."</strong>\" not available";
    }
}
