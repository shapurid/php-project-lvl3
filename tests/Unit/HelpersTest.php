<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use function App\Helpers\normalizeUrl;

class HelpersTest extends TestCase
{
    public function testNormalizeUrl(): void
    {
        $faker = \Faker\Factory::create();
        $url = "http://{$faker->domainName}";
        $path = '/';

        $normalizedUrl = normalizeUrl("{$url}{$path}");

        self::assertTrue($url === $normalizedUrl);
    }
}
