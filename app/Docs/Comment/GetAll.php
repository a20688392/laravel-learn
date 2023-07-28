<?php

namespace App\Docs\Comment;

/**
 *  @OA\Get(
 *      tags={"Comment"},
 *      path="/api/comments",
 *      summary="獲取所有留言",
 *      @OA\Response(
 *          response="200",
 *          description="獲取所有留言",
 *          @OA\JsonContent(
 *             @OA\Property(
 *                  property="stateCode",
 *                  type="integer",
 *                  description="狀態碼"
 *              ),
 *             @OA\Property(
 *                  property="comments",
 *                  type="array",
 *                  description="所有留言",
 *                  @OA\Items(ref="#/components/schemas/Comment"),
 *              ),
 *              example={
 *                  "stateCode": 200,
 *                  "comments": {
 *                      {
 *                          "id": 1,
 *                          "title": "這是標題1",
 *                          "description": "這是描述1",
 *                          "created_at": "2023-07-24 10:16:08",
 *                          "updated_at": "2023-07-24 10:16:08",
 *                          "user_id": 1
 *                      },
 *                      {
 *                          "id": 2,
 *                          "title": "這是標題2",
 *                          "description": "這是描述2",
 *                          "created_at": "2023-07-24 10:16:08",
 *                          "updated_at": "2023-07-27 06:45:11",
 *                          "user_id": 2
 *                      },
 *                  },
 *              },
 *          ),
 *      ),
 *  )
 */
class GetAll
{
}
