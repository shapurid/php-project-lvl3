<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use DiDom\Document;
use Carbon\Carbon;

class UrlChecksController extends Controller
{
    public function store($urlId)
    {
        $foundUrl = DB::table('urls')->find($urlId);
        if (is_null($foundUrl)) {
            abort(404);
        }
        try {
            $response = Http::get($foundUrl);
            [$mediaType] = explode('; ', $response->header('content-type'));
            if (strcmp($mediaType, 'text/htm') !== 0) {
                flash('Запрашиваемый ресурс не отдаёт html, нечего анализировать', 'error');
                return redirect()->route('urls.show', ['urlId' => $urlId]);
            }
            $statusCode = $response->status();
            $body = $response->body();
            $document = new Document($body);
            $foundH1Tag = $document->first('h1');
            $foundMetaKeywords = $document->first('meta[name=keywords]');
            $foundMetaDescription = $document->first('meta[name=description]');

            $h1Content = is_null($foundH1Tag)
                ? null
                : $foundH1Tag->text();
            $metaKeywordsContent = is_null($foundMetaKeywords)
                ? null
                : $foundMetaKeywords->getAttribute('content');
            $metaDescriptionContent = is_null($foundMetaDescription)
                ? null
                : $foundMetaDescription->getAttribute('content');
            DB::table('url_checks')->insert([
                'url_id' => $urlId,
                'status_code' => $statusCode,
                'h1' => $h1Content,
                'keywords' => $metaKeywordsContent,
                'description' => $metaDescriptionContent,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        } catch (ConnectionException $error) {
            flash('Запрашиваемый ресурс не найден', 'error');
            return redirect()->route('urls.show', ['urlId' => $urlId]);
        } catch (\Exception $error) {
            abort(500);
        }
        flash('Проверка успешно пройдена', 'success');
        return redirect()->route('urls.show', ['urlId' => $urlId]);
    }
}
