<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUrlRequest;
use Carbon\Carbon;

use function App\Helpers\normalizeUrl;

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
     * @param \App\Http\Requests\StoreUrlRequest $request
     * @return Redirector|RedirectResponse
     */

    public function store(StoreUrlRequest $request)
    {
        ['url' => ['name' => $urlName]] = $request->validated();

        $normalizedUrl = normalizeUrl($urlName);

        $foundUrl = DB::table('urls')->where('name', $normalizedUrl)->first();

        if (isset($foundUrl->id)) {
            flash('Данный сайт уже проходил проверку')->warning();
            return redirect(route('urls.show', ['urlId' => $foundUrl->id]));
        }
        $insertedUrlId = DB::table('urls')->insertGetId([
            'name' => $normalizedUrl,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        flash('Сайт успешно добавлен')->success();
        return redirect(route('urls.show', ['urlId' => $insertedUrlId]));
    }
}
