<?php

namespace App\Http\Controllers;

use App\Actions\QueryBooksByTitle;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show($title)
    {
        $response = app(QueryBooksByTitle::class)($title);
        return $response->json();
    }
}
