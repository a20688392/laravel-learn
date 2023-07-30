<?php

namespace App\Docs\Auth;

/**
 *  @OA\Post(
 *      tags={"Auth"},
 *      path="/api/auth/login",
 *      summary="使用者登入",
 *      description="使用者登入，登入成功即獲取 accessToken",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              required={"email","password"},
 *              @OA\Property(
 *                  property="email",
 *                  type="string",
 *                  description="Email 信箱
 *                              必填欄位
 *                              格式必須符合 email 格式",
 *              ),
 *              @OA\Property(
 *                  property="password",
 *                  type="string",
 *                  description="密碼
 *                              必填欄位",
 *                              minLength=6,
 *              ),
 *              example={
 *                  "email": "user@example.com",
 *                  "password": "test123"
 *              }
 *          ),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="登入成功",
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="stateCode",
 *                  type="string",
 *                  description="HTTP 狀態碼",
 *              ),
 *              @OA\Property(
 *                  property="accessToken",
 *                  type="string",
 *                  description="HTTP 狀態碼",
 *              ),
 *              example={
 *                  "stateCode": 200,
 *                  "accessToken": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2xhcmF2ZWwtbGVhcm5cL3B1YmxpY1wvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTY5MDQyNTE3MSwiZXhwIjoxNjkwNDI4NzcxLCJuYmYiOjE2OTA0MjUxNzEsImp0aSI6IkR4aTFUVVV5VTVPVkk2dmoiLCJzdWIiOjMsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.FlVKNcXy8ApBesduE976AkN6s_GExhzrd90v0GK-1LU"
 *              }
 *          )
 *      ),
 *      @OA\Response(
 *          response="400",
 *          description="驗證錯誤",
 *          ref="#/components/schemas/BadRequest"
 *      ),
 *  )
 */
class Login
{
}
