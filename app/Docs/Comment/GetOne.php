<?php

namespace App\Docs\Comment;

/**
 *  @OA\Get(
 *      tags={"Comment"},
 *      path="/api/comments/{id}",
 *      summary="獲取單一留言",
 *      @OA\Parameter(
 *          name="id",
 *          description="留言 ID",
 *          required=true,
 *          in="path",
 *          example=1
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="獲取單一留言",
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
 *  )
 */
class GetOne
{
}
