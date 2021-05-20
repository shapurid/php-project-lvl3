<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use App\Http\Requests\StoreUrlRequest;
use App\Repositories\UrlCheckRepository;
use App\Repositories\UrlRepository;

use function App\Helpers\normalizeUrl;

class UrlsController extends Controller
{
    /**
     * @return View|Factory
     */
    public function index(UrlRepository $urlRepository)
    {
        $urls = $urlRepository->findAll();
        return view('urls.index', [ 'urls' => $urls ]);
    }

    /**
     * @param int|string $urlId
     * @return View|Factory|void
     */

    public function show($urlId, UrlRepository $urlRepository, UrlCheckRepository $urlCheckRepository)
    {
        $foundUrl = $urlRepository->findByIdOrFail($urlId);

        $urlChecks = $urlCheckRepository->findAllByUrlId($urlId);
        return view('urls.show', ['url' => $foundUrl, 'urlChecks' => $urlChecks]);
    }

    /**
     * @param \App\Http\Requests\StoreUrlRequest $request
     * @return Redirector|RedirectResponse
     */

    public function store(StoreUrlRequest $request, UrlRepository $urlRepository)
    {
        ['url' => ['name' => $urlName]] = $request->validated();

        $normalizedUrl = normalizeUrl($urlName);

        $foundUrl = $urlRepository->findOneWhere('name', $normalizedUrl);

        if (isset($foundUrl->id)) {
            flash('Данный сайт уже проходил проверку')->warning();
            return redirect(route('urls.show', ['urlId' => $foundUrl->id]));
        }
        $insertedUrlId = $urlRepository->insert(['name' => $normalizedUrl]);
        flash('Сайт успешно добавлен')->success();
        return redirect(route('urls.show', ['urlId' => $insertedUrlId]));
    }
}
