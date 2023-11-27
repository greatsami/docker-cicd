<?php

use App\Services\ApiRequest;
use App\Supports\GoogleBooksApiClient;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::fake();
    config([
        'services.google_books.base_url' => 'https://example.com',
        'services.google_books.api_key' => 'foo',
    ]);
});

it('sets the base url', function () {
    $request = ApiRequest::get('foo');

    app(GoogleBooksApiClient::class)->send($request);

    Http::assertSent(static function (Request $request) {
        expect($request)->url()->toStartWith('https://example.com/foo');

        return true;
    });
});

it('sets the api key as a query parameter', function () {
    $request = ApiRequest::get('foo');

    app(GoogleBooksApiClient::class)->send($request);

    Http::assertSent(static function (Request $request) {
        expect($request)->url()->toContain('key=foo');

        return true;
    });
});
