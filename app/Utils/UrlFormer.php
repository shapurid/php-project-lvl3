<?php

namespace App\Utils;

class UrlFormer
{
    private string $scheme;
    private string $host;
    private string $path;

    private function normalizePath(string $path): string
    {
        return $path === '/' ? '' : $path;
    }

    /**
     * @param array<string, string> $parsedUrl
     */

    public function __construct(array $parsedUrl)
    {
        $this->scheme = $parsedUrl['scheme'];
        $this->host = $parsedUrl['host'];
        $path = $parsedUrl['path'] ?? '';
        $this->path = $this->normalizePath($path);
    }

    public function formUrl(): string
    {
        return "{$this->scheme}://{$this->host}{$this->path}";
    }
}
