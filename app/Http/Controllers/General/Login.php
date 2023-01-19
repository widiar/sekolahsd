<?php

namespace app\Http\Controllers\General;

use app\Models\mUserRole;
use app\Rules\LoginRolesCheck;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Rules\LoginCheck;
use Illuminate\Support\Facades\Log;
use app\Models\mUser;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    function index()
    {
        $data = [
            'pageTitle' => 'Login | ' . env('APP_NAME'),
            'roles' => mUserRole::orderBy('role_name', 'ASC')->get()
        ];

        return view('general/login', $data);
    }

    function do(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => ['required', new LoginCheck($request->username)]
        ]);

        //        return response(422, []);

    }

    function roles(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'password' => ['required', new LoginRolesCheck($request->username)]
        ]);
    }
}
