<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use DiDom\Document;
use Carbon\Carbon;

class UrlChecksController extends Controller
{
    /**
     * Undocumented function
     *
     * @param int|string $urlId
     * @return RedirectResponse|Redirector
     */
    public function store($urlId)
    {
        $foundUrl = DB::table('urls')->find($urlId);
        if (is_null($foundUrl)) {
            abort(404);
        }
        try {
            $response = Http::get($foundUrl->name);
            [$mediaType] = explode('; ', $response->header('content-type'));
            if (strcmp($mediaType, 'text/html') !== 0) {
                flash('Запрашиваемый ресурс не отдаёт html, нечего анализировать')->error();
                return redirect(route('urls.show', ['urlId' => $urlId]));
            }
            $statusCode = $response->status();
            $body = $response->body();
            $document = new Document($body);
            $foundH1Tag = $document->first('h1');
            $foundMetaKeywords = $document->first('meta[name=keywords]');
            $foundMetaDescription = $document->first('meta[name=description]');

            $h1Content = optional($foundH1Tag)->text();
            $metaKeywordsContent = optional($foundMetaKeywords)->getAttribute('content');
            $metaDescriptionContent = optional($foundMetaDescription)->getAttribute('content');
            DB::table('url_checks')->insert([
                'url_id' => $urlId,
                'status_code' => $statusCode,
                'h1' => $h1Content,
                'keywords' => $metaKeywordsContent,
                'description' => $metaDescriptionContent,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
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
