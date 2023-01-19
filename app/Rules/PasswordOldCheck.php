<?php

namespace app\Rules;

use Illuminate\Contracts\Validation\Rule;
use app\Models\mUser;

class PasswordOldCheck implements Rule
{

    private $kode_user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($kode_user)
    {
        $this->kode_user = $kode_user;
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
        $kode_user = $this->kode_user;
        $username = mUser::value('username')->find($kode_user);
        $userPassword = mUser::where('username', $username)->value('password');
        if(Hash::check($value, $userPassword)) {
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
        return 'Password tidak sama dengan password sesuai';
    }
}
