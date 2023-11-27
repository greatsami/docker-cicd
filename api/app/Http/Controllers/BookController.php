<?php

namespace App\Http\Controllers;

use App\Actions\QueryBooksByTitle;

class BookController extends Controller
{
    public function show($title)
    {
        $response = app(QueryBooksByTitle::class)($title);

        return $response->json();
    }
}
