<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

readonly class AuthController
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = [
            'email' => $request->validated('login'),
            'password' => $request->validated('password'),
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'title' => $user->getTitle(),
        ]);
    }

    public function logout(): JsonResponse
    {
        /*
         * Needs doctrine storage
         *
         * tests/Feature/AuthTest.php
         * vendor/tymon/jwt-auth/src/Providers/Storage/Illuminate.php
         * vendor/tymon/jwt-auth/src/Contracts/Providers/Storage.php
         * config/jwt.php - providers.storage
         */
        throw new \RuntimeException('Not implemented.');
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
