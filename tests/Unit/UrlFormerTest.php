<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Utils\UrlFormer;

class UrlFormerTest extends TestCase
{
    public function testClass(): void
    {
        $faker = \Faker\Factory::create();
        $url = "http://{$faker->domainName}";
        $path = '/';
        $parsedUrl = parse_url($url . $path);
        if (!is_array($parsedUrl)) {
            throw new \Exception('parsedUrl is not array');
        }
        $formedUrl = (new UrlFormer($parsedUrl))->formUrl();

        $this->assertEquals($url, $formedUrl);
    }
}
