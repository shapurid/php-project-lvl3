<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UrlsController extends Controller
{
    public function index()
    {
        $urls = DB::table('urls')->get();
        return view('urls.index', [ 'urls' => $urls ]);
    }

    public function show($urlId)
    {
        $foundUrl = DB::table('urls')->find($urlId);
        if (is_null($foundUrl)) {
            abort(404);
        }
        return view('urls.show', ['url' => $foundUrl]);
    }

    public function store(Request $request)
    {
        ['url' => ['name' => $urlName]] = $this->validate(
            $request,
            ['url.name' => 'required'],
            ['url.name.required' => 'Введите адрес страницы.']
        );

        $validatedUrl = Validator::make(
            parse_url($urlName),
            [
                'scheme' => 'required',
                'host' => 'bail|required',
                'path' => 'nullable|string'
            ],
            ['required' => 'Введите корректный адрес страницы.']
        )->validate();

        $normalizedUrl = "{$validatedUrl['scheme']}://{$validatedUrl['host']}" . ($validatedUrl['path'] ?? '/');

        $foundUrl = DB::table('urls')->where('name', $normalizedUrl)->first();

        if (!is_null($foundUrl)) {
            flash('Данный сайт уже проходил проверку', 'warning');
            return redirect()->route('urls.show', ['urlId' => $foundUrl->id]);
        }
        $insertedUrlId = DB::table('urls')->insertGetId([
            'name' => $normalizedUrl,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        flash('Сайт успешно добавлен', 'success');
        return redirect()->route('urls.show', ['urlId' => $insertedUrlId]);
    }
}
