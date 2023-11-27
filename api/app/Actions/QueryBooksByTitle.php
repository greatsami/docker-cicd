<?php

namespace App\Actions;

use App\Services\ApiRequest;
use App\Supports\GoogleBooksApiClient;
use Illuminate\Http\Client\Response;

class QueryBooksByTitle
{
    public function __invoke(string $title): Response
    {
        $client = app(GoogleBooksApiClient::class);
        $request = ApiRequest::get('volumes')
            ->setQuery('q', 'intitle:'.$title)
            ->setQuery('printType', 'books');
        return $client->send($request);
    }
}
