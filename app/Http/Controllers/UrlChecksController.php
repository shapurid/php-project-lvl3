<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Client\ConnectionException;
use App\Repositories\UrlCheckRepository;
use App\Repositories\UrlRepository;

use function App\Helpers\extractDataFromResponse;

class UrlChecksController extends Controller
{
    /**
     * @param int|string $urlId
     * @return RedirectResponse|Redirector
     */
    public function store($urlId, UrlRepository $urlRepository, UrlCheckRepository $urlCheckRepository)
    {
        $foundUrl = $urlRepository->findByIdOrFail($urlId);

        try {
            $response = $urlRepository->getResponse($foundUrl->name);

            $extractedData = extractDataFromResponse($response);

            $urlCheckRepository->insert(
                array_merge(
                    ['url_id' => $urlId],
                    $extractedData
                )
            );
        } catch (ConnectionException) {
            flash('Запрашиваемый ресурс не найден')->error();
            return redirect(route('urls.show', ['urlId' => $urlId]));
        } catch (\Exception) {
            flash('Произошла неизвестная ошибка, попробуйте позже')->error();
            return redirect(route('urls.show', ['urlId' => $urlId]));
        }
        flash('Проверка успешно пройдена')->success();
        return redirect(route('urls.show', ['urlId' => $urlId]));
    }
}
