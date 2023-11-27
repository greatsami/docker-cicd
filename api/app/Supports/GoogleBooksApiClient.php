<?php

namespace App\Supports;

use App\Services\ApiClient;
use Illuminate\Http\Client\PendingRequest;

class GoogleBooksApiClient extends ApiClient
{

    /**
     * @return string
     */
    protected function baseUrl(): string
    {
        return config('services.google_books.base_url');
    }

    /**
     * @param PendingRequest $request
     * @return PendingRequest
     */
    protected function authorize(PendingRequest $request): PendingRequest
    {
        return $request->withQueryParameters([
            'key' => config('services.google_books.api_key'),
        ]);
    }
}
