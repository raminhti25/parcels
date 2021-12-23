<?php

namespace App\Http\Controllers;

use App\Models\Biker;
use App\Models\Sender;
use App\Traits\ApiResponser;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class LoginController extends Controller
{
    use ApiResponser;

    const ADMIN     = 'admin';
    const WORKER    = 'worker';

    /**
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        if ($request->role == 'sender') {
            $user = Sender::create($request->all());
        } else {
            $user = Biker::create($request->all());
        }

        return $this->success(['token' => $user->createToken(time())->plainTextToken]);
    }

    /**
     * @param LoginRequest $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!auth()->guard($request->role)->attempt($request->only('email', 'password'))) {
            return response()->json(['messages' => trans('errors.wrong_credentials')], 401);
        }

        return $this->success(
            ['token' => auth()->guard($request->role)->user()->createToken(time())->plainTextToken]
        );
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
