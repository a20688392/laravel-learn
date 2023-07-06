<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

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
            $httpStatus = Response::HTTP_BAD_REQUEST;
            $reposeData = [
                'statusCode' => $httpStatus,
                'message' => '登入失敗',
                'errors' => $validator->errors()
            ];
            return response()->json(
                $reposeData,
                $httpStatus
            );
        }

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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // 驗證 client 端輸入
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'max:12'],
        ];
        //更改默認 錯誤訊息
        $messages = [
            'email.required' => 'email 必填',
            'email.email' => '格式必須符合 email 格式',
            'password.required' => 'password 必填',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        // 將錯誤訊息以 JSON 格式印出
        if ($validator->fails()) {
            $httpStatus = Response::HTTP_BAD_REQUEST;
            $reposeData = [
                'statusCode' => $httpStatus,
                'message' => '登入失敗',
                'errors' => $validator->errors()
            ];
            return response()->json(
                $reposeData,
                $httpStatus
            );
        }
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
