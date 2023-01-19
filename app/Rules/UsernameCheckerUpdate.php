<?php

namespace app\Rules;

use Illuminate\Contracts\Validation\Rule;
use app\Models\mUser;

class UsernameCheckerUpdate implements Rule
{

    protected $id;
    protected $username;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
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
        $username_first = mUser::select('username')->where('id', $this->id)->first()->username;
        $username = $value;
        $this->username = $value;

        if($username == $username_first) {
            return TRUE;
        } else {
            $checkSame = mUser::where('username', $username)->whereNotIn('username', array($username_first))->count();
            if($checkSame > 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Username <strong>'.$this->username.'</strong> is not Available';
    }
}
