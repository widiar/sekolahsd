<?php

namespace app\Http\Controllers\General;

use app\Helpers\Main;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;


class Underconstruction extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $this->breadcrumb = [
            [
                'label' => '',
                'route' => '#'
            ]
        ];
    }

    function index()
    {
        $data = Main::data($this->breadcrumb);
        return view('general/underconstruction', $data);
    }

}