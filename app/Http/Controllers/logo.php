<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;


class logo extends Controller
{
    public function logo()
    {
        $image_path = public_path('images/logo.png');
        return response()->file($image_path);
    }
}
