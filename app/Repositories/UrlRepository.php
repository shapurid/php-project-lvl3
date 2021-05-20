<?php

namespace App\Repositories;

use App\Models\Url;
use Illuminate\Support\Facades\Http;

class UrlRepository
{
    public function findAll()
    {
        return Url::all();
    }

    public function findById($id)
    {
        return Url::find($id);
    }

    public function findByIdOrFail($id)
    {
        return Url::findOrFail($id);
    }

    public function findOneWhere($fieldName, $value)
    {
        return Url::firstWhere($fieldName, $value);
    }

    public function getResponse($url)
    {
        return Http::get($url);
    }

    public function insert($createData)
    {
        return Url::create($createData);
    }
}
