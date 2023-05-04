<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLogin;
use App\Http\Requests\UserRegister;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * 使用者註冊
     *
     * @param  UserRegister  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegister $request)
    {
        $reposeData = [
            'status' => 200,
            'message' => '創建成功',
        ];
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
        ]);
        return response()->json(
            $reposeData,
            200,
        );
    }

    /**
     * 使用者登入
     * @param UserLogin $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLogin $request)
    {
        $attempt =  User::where('email', $request->email)->first();
        if ($attempt && Hash::check($request->password, $attempt->password)) {
            $httpStatus = 200;
            $reposeData = [
                'message' => '登入成功',
                "name" => $attempt->name
            ];
        } else {
            $httpStatus = 401;
            $reposeData = [
                'message' => '登入失敗',
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
}
