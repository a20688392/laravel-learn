<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\AllRequest;

class CommentGetAll extends AllRequest
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
            'startTime' => [
                'date_format:Y-m-d H:i:s'
            ],
            'endTime' => [
                'date_format:Y-m-d H:i:s',
                'after_or_equal:startTime'
            ],
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
            'startTime.date_format' => '日期時間格式必須為 Y-m-d H:i:s',
            'endTime.date_format' => '日期時間格式必須為 Y-m-d H:i:s',
            'endTime.after_or_equal' => '結束時間必須大於或等於起始時間。',
        ];
    }
}
