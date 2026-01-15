<?php

namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;

class ErrorController extends Controller
{

    public function notFound()
    {
        return view('error.404'); // Ensure you have a view file at resources/views/errors/404.blade.php
    }

    public function serverError()
    {
        return view('error.404'); // Ensure you have a view file at resources/views/errors/500.blade.php
    }
}
