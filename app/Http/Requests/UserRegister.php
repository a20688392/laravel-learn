<?php

namespace App\Http\Requests;

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
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
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
            'email.required' => 'email 必填',
            'email.email' => '格式必須符合 email 格式',
            'email.unique' => '信箱已被註冊',
            'password.required' => 'password 必填',
            'password.confirmed' => '與密碼驗證不符'
        ];
    }
}
