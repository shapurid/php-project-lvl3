<?php

namespace App\Repositories;

use App\Models\UrlCheck;

class UrlCheckRepository
{
    public function findAll()
    {
        return UrlCheck::all();
    }

    public function findOneById($id)
    {
        return UrlCheck::find($id);
    }

    public function findAllByUrlId($id)
    {
        return UrlCheck::where('url_id', $id)->get();
    }

    public function insert($createData)
    {
        return UrlCheck::create($createData);
    }
}
