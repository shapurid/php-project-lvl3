<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Utils\UrlFormer;

class UrlFormerTest extends TestCase
{
    public function testClass()
    {
        $faker = \Faker\Factory::create();
        $url = "http://{$faker->domainName}";
        $path = '/';
        $parsedUrl = parse_url($url . $path);
        $formedUrl = (new UrlFormer($parsedUrl))->formUrl();

        $this->assertEquals($url, $formedUrl);
    }
}
