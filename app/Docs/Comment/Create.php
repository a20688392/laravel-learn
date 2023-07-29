<?php

namespace App\Docs\Comment;

/**
 *  @OA\Post(
 *      tags={"Comment"},
 *      path="/api/comments",
 *      summary="創建留言",
 *      description="需要攜帶 Bearer Token 在 Header 上",
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              required={"title","description"},
 *              @OA\Property(
 *                  property="title",
 *                  type="string",
 *                  description="留言 標題
 *                      必填欄位
 *                      最長 10 個字元",
 *                  maxLength=10,
 *              ),
 *              @OA\Property(
 *                  property="description",
 *                  type="string",
 *                  description="留言 描述
 *                      必填欄位",
 *              ),
 *              example={
 *                  "title": "這是標題",
 *                  "description": "這是描述"
 *              }
 *          ),
 *      ),
 *      @OA\Response(
 *          response="201",
 *          description="創建留言成功",
 *          @OA\JsonContent(
 *             @OA\Property(
 *                  property="stateCode",
 *                  type="integer",
 *                  description="狀態碼"
 *              ),
 *             @OA\Property(
 *                  property="comment",
 *                  type="object",
 *                  description="單一留言",
 *                  ref="#/components/schemas/Comment"
 *              ),
 *              example={
 *                  "stateCode": 200,
 *                  "comment": {
 *                          "id": 1,
 *                          "title": "這是標題",
 *                          "description": "這是描述",
 *                          "created_at": "2023-07-24 10:16:08",
 *                          "updated_at": "2023-07-24 10:16:08",
 *                          "user_id": 1
 *                  },
 *              },
 *          ),
 *      ),
 *      @OA\Response(
 *        response=401,
 *        description="身分驗證未通過",
 *        @OA\JsonContent(ref="#/components/schemas/Unauthorized")
 *      )
 *  )
 */
class Create
{
}
