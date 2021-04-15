<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlChecksControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->migrateUsing();
        $this->seed();
    }

    public function testStore(): void
    {
        $data = DB::table('urls')->inRandomOrder()->first();
        $content = file_get_contents(__DIR__ . '/fixtures/test.html');

        if (!isset($data->name) || !isset($data->id)) {
            throw new \Exception("data is not object");
        }
        if (!is_string($content)) {
            throw new \Exception("can't get content");
        }

        Http::fake([
            $data->name => Http::response($content, 200, ['content-type' => 'text/html'])
        ]);
        $response = $this->post(route('urls.checks.store', ['urlId' => $data->id]));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('url_checks', ['url_id' => intval($data->id)]);
    }
}
