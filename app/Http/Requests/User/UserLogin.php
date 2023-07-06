<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AllRequest;

class UserLogin extends AllRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6'],
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
            'email.required' => 'email 必填',
            'email.email' => '格式必須符合 email 格式',
            'password.required' => 'password 必填',
            'password.min' => 'password 最短6碼',
        ];
    }
}
