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

    public function store(Request $request)
    {
        ['url' => ['name' => $name]] = $this->validate(
            $request,
            [
                'url.name' => 'required'
            ],
            [
                'url.name.required' => 'Введите адрес страницы.'
            ]
        );

        $foundUrl = DB::table('urls')->where('name', $name)->get();

        if ($foundUrl->isNotEmpty()) {
            flash('Данный сайт уже проходил проверку', 'warning');
            return redirect()->route('root');
        }
        return $name;
    }
}
