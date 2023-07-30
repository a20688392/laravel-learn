<?php

namespace App\Docs\Auth;

/**
 * @OA\Post(
 *     path="/api/auth/register",
 *     tags={"Auth"},
 *     summary="使用者註冊",
 *     description="使用者註冊，註冊成功即可登入",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "email", "password", "password_confirmation"},
 *             @OA\Property(
 *               property="name",
 *               type="string",
 *               description="使用者名稱
 *                  必填欄位
 *                  長度限制 2-255 個字元",
 *               minLength=2,
 *               maxLength=255,
 *             ),
 *             @OA\Property(
 *               property="email",
 *               type="string",
 *               description="Email 信箱
 *                  必填欄位
 *                  格式必須符合 email 格式
 *                  長度限制最長 255 個字元",
 *               maxLength=255,
 *             ),
 *             @OA\Property(
 *               property="password",
 *               type="string",
 *               description="密碼",
 *               description="密碼
 *                  必填欄位
 *                  必須與 password_confirmation 相同
 *                  最短 6 個字元",
 *               minLength=6,
 *             ),
 *             @OA\Property(
 *               property="password_confirmation",
 *               type="string",
 *               description="確認密碼
 *               必填欄位
 *               必須與 password 相同",
 *             ),
 *             example={
 *                  "name":"username",
 *                  "email":"user@example.com",
 *                  "password":"test123",
 *                  "password_confirmation":"test123"
 *             }
 *         ),
 *     ),
 *     @OA\Response(
 *         response="201",
 *         description="使用者註冊成功",
 *         @OA\JsonContent(
 *              @OA\Property(
 *                  property="stateCode",
 *                  type="integer",
 *                  description="狀態碼"
 *              ),
 *              @OA\Property(
 *                  property="userData",
 *                  type="object",
 *                  description="用戶資料",
 *                  @OA\Property(
 *                      property="name",
 *                      type="string",
 *                      description="使用者名稱"
 *                  ),
 *                  @OA\Property(
 *                      property="email",
 *                      type="string",
 *                      description="使用者信箱"
 *                  ),
 *                  @OA\Property(
 *                      property="updated_at",
 *                      type="datetime",
 *                      description="使用者更新時間"
 *                  ),
 *                  @OA\Property(
 *                      property="created_at",
 *                      type="datetime",
 *                      description="使用者創辦時間"
 *                  ),
 *                  @OA\Property(
 *                      property="id",
 *                      type="integer",
 *                      description="使用者ID"
 *                  )
 *              ),
 *              example={
 *                  "stateCode": 201,
 *                   "userData": {
 *                      "name": "username",
 *                      "email": "user@example.com",
 *                      "updated_at": "2023-07-26T15:06:02.538Z",
 *                      "created_at": "2023-07-26T15:06:02.538Z",
 *                      "id": 1
 *                  }
 *              }
 *         )
 *     ),
 *     @OA\Response(
 *          response="400",
 *          description="驗證錯誤",
 *          ref="#/components/schemas/BadRequest"
 *      ),
 *  )
 */
class Register
{
}
