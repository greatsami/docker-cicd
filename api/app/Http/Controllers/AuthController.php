<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::query()->where('email', $request->email)->first();
            $token = $user->createToken('token', ['*'])->plainTextToken;

            return response()->json(['data' => ['token' => $token]], ResponseAlias::HTTP_OK);
        }

        return response()->json([], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
    }
}
