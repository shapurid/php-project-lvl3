<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $tableName = 'urls';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('urls.index'));

        $response->assertStatus(200);
    }

    public function testShow(): void
    {
        $data = DB::table($this->tableName)->inRandomOrder()->first();
        $response = $this->get(route('urls.show', ['urlId' => $data->id]));
        $response->assertStatus(200);

        $this->assertDatabaseHas($this->tableName, ['id' => $data->id]);
    }

    public function testStore(): void
    {
        $url = "https://www.{$this->faker->domainName}";
        $response = $this->post(route('urls.store', ['url[name]' => $url]));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas($this->tableName, ['name' => "{$url}"]);
    }
}
