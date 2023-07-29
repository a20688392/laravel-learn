<?php

namespace App\Docs\Comment;

/**
 *  @OA\Delete(
 *      tags={"Comment"},
 *      path="/api/comments/{id}",
 *      summary="軟刪除單一留言",
 *      description="需要攜帶 Bearer Token 在 Header 上",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(
 *          name="id",
 *          description="留言 ID",
 *          required=true,
 *          in="path",
 *          example=1
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="軟刪除單一留言",
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
class Delete
{
}
