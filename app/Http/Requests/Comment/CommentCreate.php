<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\AllRequest;

class CommentCreate extends AllRequest
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
            'title' => ['required', 'string', 'max:10'],
            'description' => ['required', 'string'],
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
            'title.required' => 'title 必填',
            'description.required' => 'description 必填'
        ];
    }
}
