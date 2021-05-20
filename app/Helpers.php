<?php

namespace App\Helpers;

use DiDom\Document;

function normalizeUrl($url)
{
    $parsedUrl = parse_url($url);
    $scheme = $parsedUrl['scheme'];
    $host = $parsedUrl['host'];
    $path = $parsedUrl['path'] ?? '';
    $normalizedPath = $path === '/' ? '' : $path;
    return "{$scheme}://{$host}{$normalizedPath}";
}

function extractDataFromResponse($response)
{
    $statusCode = $response->status();
    $body = $response->body();
    $document = new Document($body);
    $foundH1Tag = $document->first('h1');
    $foundMetaKeywords = $document->first('meta[name=keywords]');
    $foundMetaDescription = $document->first('meta[name=description]');

    $h1Content = optional($foundH1Tag)->text();
    $metaKeywordsContent = optional($foundMetaKeywords)->getAttribute('content');
    $metaDescriptionContent = optional($foundMetaDescription)->getAttribute('content');

    return [
        'status_code' => $statusCode,
        'h1' => $h1Content,
        'keywords' => $metaKeywordsContent,
        'description' => $metaDescriptionContent
    ];
}
