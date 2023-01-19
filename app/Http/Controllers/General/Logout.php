<?php

namespace app\Http\Controllers\General;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;

class Logout extends Controller
{
    function index()
    {

    }

    function do()
    {
        Session::flush();
        return redirect()->route('loginPage');
    }
}
