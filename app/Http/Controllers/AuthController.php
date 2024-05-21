<?php

namespace App\Http\Controllers;

use App\Actions\AuthAction;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param AuthAction $authAction
     */
    public function __construct(protected readonly AuthAction $authAction)
    {}

    /**
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'Authorized', 200, [
                    'token' => $request->user()->createToken('auth_token')->plainTextToken,
                ]
            ]);
        }

        return response()->json([
            'Unauthorized', 403
        ]);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json('Token Revoked', 200);
    }

    /**
     * @param AuthRequest $request
     * @return void
     */
    public function register(AuthRequest $request)
    {
        $user = $this->authAction->register($request);

        return response()->json([
            'user' => $user,
            'message' => 'User created successfully',
        ], 201);
    }
}