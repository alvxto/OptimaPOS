<?php

namespace App\Controllers;
use App\Libraries\Parser;

class Home extends BaseController
{
    public function index()
    {
        // Parser::view('BackEnd\Layout\Views\main');
        return view('welcome_message');
    }
}
