<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class BaseController extends Controller
{
    /**
     * Display the index page for the application.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return view('index');
    }
}
