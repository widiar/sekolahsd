<?php

namespace app\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Session;

use app\Models\mUser;
use Hash;

class UsernameCheckerLoginNow implements Rule
{

    private $username;
    private $type;

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
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = FALSE;
        $password = $value;
        $user = Session::get('user');

        if($user->username == $this->username) {
            $userPassword = mUser::where('username', $this->username)->value('password');

            if(Hash::check($password, $userPassword)) {
                $result = TRUE;
            } else {
                $this->type = 'wrong_password';
            }
        } else {
            $this->type = 'wrong_user';
        }

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch($this->type) {
            case "wrong_password": return 'Username atau Password salah'; break;
            case "wrong_user": return "Username yang login saat ini salah"; break;
            default : return "Username atau Password salah";
        }
    }
}
