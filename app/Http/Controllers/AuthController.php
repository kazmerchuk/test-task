<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\Authenticator;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @param Authenticator $authenticator
     * @return JsonResponse
     */
    public function login(LoginRequest $request, Authenticator $authenticator): JsonResponse
    {
        $token = $authenticator->authenticate($request->get('login'), $request->get('password'));
        if (false === $token) {
            return response()->json([
                'status' => 'failure',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'token' => $token,
        ]);
    }
}
