<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserLogin;
use App\Http\Requests\User\UserRegister;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * 使用者註冊
     *
     * @param  UserRegister  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserRegister $request)
    {
        // 為了合併系統自動安排的值，先將之前的 request 值存在 $data 內
        $data = $request->all();
        // 預設值插入
        $data['password'] = Hash::make($data['password']);

        // 將存入 $data 的值插入，新增使用者
        $user = User::create($data);

        $httpStatus = Response::HTTP_OK;
        $reposeData = [
            'statusCode' => $httpStatus,
            'message' => '創建成功',
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
        $attempt =  User::where('email', $request->email)->first();
        if ($attempt && Hash::check($request->password, $attempt->password)) {
            $httpStatus = Response::HTTP_OK;
            $reposeData = [
                'statusCode' => $httpStatus,
                'message' => '登入成功',
                "name" => $attempt->name
            ];
        } else {
            $httpStatus = Response::HTTP_UNAUTHORIZED;
            $reposeData = [
                'statusCode' => $httpStatus,
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
