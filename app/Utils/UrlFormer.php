<?php

namespace App\Utils;

class UrlFormer
{
    /**
     * @var int|string
     */
    private $scheme;
    /**
     * @var int|string
     */
    private $host;
    /**
     * @var int|string
     */
    private $path;
    /**
     * Undocumented function
     *
     * @param int|string $path
     * @return int|string
     */
    private function normalizePath($path)
    {
        return $path === '/' ? '' : $path;
    }

    /**
     * @param array<string, int|string> $parsedUrl
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
