<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:api', ['expect' => ['login']]);
    }

    public function register(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            // 'gender' => [
            //     'required',
            //     Rule::in(['L', 'P']),
            // ],
            // 'phone' => 'required|min:11|max:13',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $password = $request->get('password');
        $attributes = [
            'email' => $request->get('email'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'password' => app('hash')->make($password),
            // 'gender' => $request->get('gender'),
            'phone' => 0, //$request->get('phone'),
            'role_id' => 1,
            'level' => 1, // default level,
            'mentee' => 'Y',
        ];
        $user = User::create($attributes);

        $credentials = $request->only('email', 'password');
        // Validation failed will return 401
        if (!$token = $this->guard()->attempt($credentials)) {
            $this->response->errorUnauthorized();
        }

        $result['data'] = [
            'user' => $user,
            'token' => $token,
            'expired_in' => $this->guard()->factory()->getTTL() * 60,
        ];

        return $this->response->array($result)->setStatusCode(201);
    }

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }

        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorizend'], 401);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
