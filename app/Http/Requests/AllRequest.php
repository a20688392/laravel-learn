<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class AllRequest extends FormRequest
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
        return [];
    }

    /**
     * 回傳相應的錯誤訊息
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
    protected function failedValidation(Validator $validator)
    {
        // 取得錯誤資訊
        $responseData = $validator->errors();
        $httpStatus = Response::HTTP_BAD_REQUEST;
        $response = [
            "statusCode" => $httpStatus,
            "error" => $responseData
        ];
        // 產生 JSON 格式的 response，(422 是 Laravel 預設的錯誤 http status，可自行更換)，這邊以 400
        $response = response()->json($response, $httpStatus);
        // 丟出 exception
        throw new HttpResponseException($response);
    }
}
