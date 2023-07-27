<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserLogin;
use App\Http\Requests\User\UserRegister;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.verified', ['except' => ['login', 'register']]);
    }

    /**
     * 使用者註冊
     *
     * @param  UserRegister  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserRegister $request)
    {
        // 設定白名單，排除非需要的欄位
        $data = $request->only('name', 'email', 'password');
        // 預設值插入
        $data['password'] = Hash::make($data['password']);

        // 將存入 $data 的值插入，新增使用者
        $user = User::create($data);

        $httpStatus = Response::HTTP_CREATED;
        $reposeData = [
            'statusCode' => $httpStatus,
            'userData' => $user
        ];

        return response()->json(
            $reposeData,
            $httpStatus
        );
    }

    /**
     * 使用者登入
     * @param UserLogin $request
     * @return \Illuminate\Http\Response
     */
    public function login(UserLogin $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = JWTAuth::attempt($credentials)) {
            $httpStatus = Response::HTTP_OK;
            $reposeData = [
                'statusCode' => $httpStatus,
                'accessToken' => $token
            ];
        } else {
            $httpStatus = Response::HTTP_UNAUTHORIZED;
            $reposeData = [
                'statusCode' => $httpStatus,
                "errors" => [
                    "auth" => "帳號或密碼錯誤"
                ]
            ];
        }

        return response()->json(
            $reposeData,
            $httpStatus
        );
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::parseToken()->invalidate();
        $httpStatus = Response::HTTP_OK;
        $data = [
            'statusCode' => $httpStatus,
            'message' => 'Successfully logged out'
        ];
        return response()->json(
            $data,
            $httpStatus
        );
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $httpStatus = Response::HTTP_OK;
        $data = [
            'statusCode' => $httpStatus,
            'accessToken' => JWTAuth::parseToken()->refresh()
        ];
        return response()->json(
            $data,
            $httpStatus
        );
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $httpStatus = Response::HTTP_OK;
        $user = auth('api')->user();
        $comments = User::find($user->id)->comments;
        $data = [
            'statusCode' => $httpStatus,
            'user' => $user,
            'comments' => $comments
        ];

        return response()->json(
            $data,
            $httpStatus
        );
    }
}
