<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Utils\UrlFormer;

class UrlsController extends Controller
{
    /**
     * @return View|Factory
     */
    public function index()
    {
        $urls = DB::table('urls')->get();
        return view('urls.index', [ 'urls' => $urls ]);
    }

    /**
     * @param int|string $urlId
     * @return View|Factory|void
     */

    public function show($urlId)
    {
        $foundUrl = DB::table('urls')->find($urlId);
        if (is_null($foundUrl)) {
            abort(404);
        }
        $urlChecks = DB::table('url_checks')->where('url_id', '=', $urlId)->get();
        return view('urls.show', ['url' => $foundUrl, 'urlChecks' => $urlChecks]);
    }

    /**
     * @return Redirector|RedirectResponse
     */

    public function store(Request $request)
    {
        ['url' => ['name' => $urlName]] = $this->validate(
            $request,
            ['url.name' => 'required'],
            ['url.name.required' => 'Введите адрес страницы.']
        );

        $parsedUrl = parse_url($urlName);
        $normalizedParsedUrl = is_array($parsedUrl) ? $parsedUrl : [];

        $validatedUrl = Validator::make(
            $normalizedParsedUrl,
            [
                'scheme' => 'required',
                'host' => 'bail|required',
                'path' => 'nullable|string'
            ],
            ['required' => 'Введите корректный адрес страницы.']
        )->validate();

        $formedUrl = (new UrlFormer($validatedUrl))->formUrl();

        $foundUrl = DB::table('urls')->where('name', $formedUrl)->first();

        if (isset($foundUrl->id)) {
            flash('Данный сайт уже проходил проверку')->warning();
            return redirect(route('urls.show', ['urlId' => $foundUrl->id]));
        }
        $insertedUrlId = DB::table('urls')->insertGetId([
            'name' => $formedUrl,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        flash('Сайт успешно добавлен')->success();
        return redirect(route('urls.show', ['urlId' => $insertedUrlId]));
    }
}
