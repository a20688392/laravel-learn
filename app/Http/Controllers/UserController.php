<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * 使用者註冊
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $reposeData = [
            'status' => 200,
            'message' => '創建成功',
        ];

        $rules = [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:12', 'confirmed'],
        ];

        $messages = [
            'email.required' => 'email 必填',
            'email.email' => '格式必須符合 email 格式',
            'email.unique' => '信箱已被註冊',
            'password.required' => 'password 必填',
            'password.confirmed' => '與密碼驗證不符'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        // 將錯誤訊息以 JSON 格式印出
        if ($validator->fails()) {
            $httpStatus = 401;
            $reposeData = [
                'message' => '註冊失敗',
                'errors' => $validator->errors()
            ];
            return response()->json(
                $reposeData,
                $httpStatus
            );
        }
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
}
