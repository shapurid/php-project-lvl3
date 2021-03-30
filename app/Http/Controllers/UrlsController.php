<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UrlsController extends Controller
{
    public function index()
    {
        $urls = DB::table('urls')->get();
        return view('urls.index', [ 'urls' => $urls ]);
    }
}
