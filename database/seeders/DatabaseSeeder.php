<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        DB::table('urls')->insert([
            [
                'name' => 'https://www.google.ru/',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => "https://www.{$faker->domainName}/",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'name' => "https://www.{$faker->domainName}/",
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]
        ]);
        // $insertedUrlIds = DB::table('urls')->pluck('id');
        // foreach ($insertedUrlIds as $id) {
        //     DB::table('url_checks')->insert([
        //         'url_id' => $id,
        //         'status_code' => 418,
        //         'h1' => $faker->title(),
        //         'keywords' => "{$faker->word}, {$faker->word}, {$faker->word}",
        //         'description' => $faker->text(),
        //         'created_at' => Carbon::now()->toDateTimeString(),
        //         'updated_at' => Carbon::now()->toDateTimeString()
        //     ]);
        // }
    }
}
