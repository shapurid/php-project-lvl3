<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class HomeController extends Controller
{
    /**
     * @return View|Factory
     */
    public function index()
    {
        return view('welcome');
    }
}
