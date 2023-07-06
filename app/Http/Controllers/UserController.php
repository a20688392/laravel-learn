<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * 使用者註冊
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // 驗證 client 端輸入
        $rules = [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:12', 'confirmed'],
        ];
        //更改默認 錯誤訊息
        $messages = [
            'name.required' => 'name 必填',
            'email.required' => 'email 必填',
            'email.email' => '格式必須符合 email 格式',
            'email.unique' => '信箱已被註冊',
            'password.required' => 'password 必填',
            'password.confirmed' => '與密碼驗證不符'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        // 將錯誤訊息以 JSON 格式印出
        if ($validator->fails()) {
            return response(['message' => $validator->errors()]);
        }

        // 為了合併系統自動安排的值，先將之前的 request 值存在 $data 內
        $data = $request->all();
        // 預設值插入
        $data['password'] = Hash::make($data['password']);

        // 將存入 $data 的值插入，新增使用者
        $user = User::create($data);

        $reposeData = [
            'status' => 200,
            'message' => '創建成功',
            'userData' => $user
        ];

        return response()->json(
            $reposeData,
            200,
        );
    }
}
