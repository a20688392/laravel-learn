<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AllRequest;

class UserRegister extends AllRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    /**
     * 回傳相應的錯誤訊息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'name 必填',
            'name.min' => 'name 最短2個字',
            'name.max' => 'name 最長255個字',
            'email.required' => 'email 必填',
            'email.email' => '格式必須符合 email 格式',
            'email.max' => 'email 最長255個字',
            'email.unique' => '信箱已被註冊',
            'password.required' => 'password 必填',
            'password.min' => 'password 最短6碼',
            'password.confirmed' => '與密碼驗證不符'
        ];
    }
}
