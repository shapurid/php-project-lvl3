<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use App\Http\Requests\StoreUrlRequest;
use App\Models\Url;

use function App\Helpers\normalizeUrl;

class UrlsController extends Controller
{
    /**
     * @return View|Factory
     */
    public function index()
    {
        $urls = Url::all();
        return view('urls.index', [ 'urls' => $urls ]);
    }

    /**
     * @param int|string $urlId
     * @return View|Factory|void
     */

    public function show($urlId)
    {
        $foundUrl = Url::findOrFail($urlId);

        $urlChecks = Url::find($urlId)->checks;
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

        $foundUrl = Url::firstWhere('name', $normalizedUrl);

        if (isset($foundUrl->id)) {
            flash('Данный сайт уже проходил проверку')->warning();
            return redirect(route('urls.show', ['urlId' => $foundUrl->id]));
        }
        $insertedUrlId = Url::create([
            'name' => $normalizedUrl
        ]);
        flash('Сайт успешно добавлен')->success();
        return redirect(route('urls.show', ['urlId' => $insertedUrlId]));
    }
}
