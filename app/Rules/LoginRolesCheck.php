<?php

namespace app\Rules;

use app\Models\mUser;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use app\Models\mUserRole;
use Session;

class LoginRolesCheck implements Rule
{

    protected $username;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $username = $this->username;
        $password = $value;

        $username_login = 'saranaternak';
        $password_login = 'saranaternak123';

        if($username == $username_login && $password == $password_login) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Username atau Password tidak benar';
    }
}
