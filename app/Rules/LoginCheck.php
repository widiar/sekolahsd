<?php

namespace app\Rules;

use app\Models\mOrangTua;
use app\Models\mUser;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use app\Models\mUserRole;
use Session;

class LoginCheck implements Rule
{

    protected $username;
    protected $id_user_role;

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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $username = $this->username;
        $password = $value;
        $userPassword = mUser::where('username', $username)->value('password');
        $orangTuaPassword = mOrangTua::where('username', $username)->value('password');
        $level = '';
        $type = '';
        $status = FALSE;

        /**
         * Login user
         */
        if (Hash::check($password, $userPassword)) {
            $status = TRUE;
            $type = 'user';
        } elseif (Hash::check($password, $orangTuaPassword)) {
            $status = TRUE;
            $type = 'orangtua';
        }

        if ($status) {
            if($type == 'user') {
                $user = mUser
                    ::where([
                        'username' => $username,
                    ])
                    ->first();
                $user_role = mUserRole::where('id', $user->id_user_role)->first();
            } else {
                $user = mOrangTua::where('username', $username)->first();
                $user->nama = $user->siswa->swa_nama;
                $user_role = mUserRole::where('id', 23)->first();
            }

            $user->foto = 'empty.png';

            $session = [
                'login' => TRUE,
                'level' => $level,
                'user' => $user,
                'user_role' => $user_role
            ];

            Session::put($session);
        }


        return $status;
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
