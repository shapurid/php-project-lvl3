<?php

namespace App\Helpers;

function normalizeUrl($url)
{
    $parsedUrl = parse_url($url);
    $scheme = $parsedUrl['scheme'];
    $host = $parsedUrl['host'];
    $path = $parsedUrl['path'] ?? '';
    $normalizedPath = $path === '/' ? '' : $path;
    return "{$scheme}://{$host}{$normalizedPath}";
}
