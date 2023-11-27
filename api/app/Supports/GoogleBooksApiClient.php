<?php

namespace App\Supports;

use App\Services\ApiClient;
use Illuminate\Http\Client\PendingRequest;

class GoogleBooksApiClient extends ApiClient
{
    protected function baseUrl(): string
    {
        return config('services.google_books.base_url');
    }

    protected function authorize(PendingRequest $request): PendingRequest
    {
        return $request->withQueryParameters([
            'key' => config('services.google_books.api_key'),
        ]);
    }
}
