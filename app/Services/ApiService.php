<?php
namespace App\Services;


use Illuminate\Support\Facades\Http;


class ApiService
{
    public static function getEntries()
    {
        $response = Http::get('http://web.archive.org/web/20240403172734if_/https://api.publicapis.org/entries');

        if ($response->failed()) {
            throw new \Exception('Failed to fetch data from the API.');
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
