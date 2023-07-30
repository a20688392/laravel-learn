<?php

namespace App\Docs\Comment;

/**
 *  @OA\Get(
 *      tags={"Comment"},
 *      path="/api/comments?keyword={keyword}?startTime={startTime}?endTime={endTime}",
 *      summary="獲取所有留言或關鍵字,時間區段",
 *      @OA\Parameter(
 *          description="關鍵字
 *          可選",
 *          in="query",
 *          name="keyword",
 *          required=false,
 *          @OA\Schema(type="string"),
 *          example=1
 *      ),
 *      @OA\Parameter(
 *          description="起始時間，預設未填為 2020-06-27 00:00:00
 *          可選
 *          日期時間格式必須為 Y-m-d H:i:s",
 *          in="query",
 *          name="startTime",
 *          required=false,
 *          @OA\Schema(
 *            type="string",
 *            format="dateTime"
 *          ),
 *          example="2020-06-27 00:00:00"
 *      ),
 *      @OA\Parameter(
 *          description="結束時間，預設未填為 現在時間
 *          可選
 *          日期時間格式必須為 Y-m-d H:i:s",
 *          in="query",
 *          name="endTime",
 *          required=false,
 *          @OA\Schema(
 *              type="string",
 *              format="dateTime"
 *          ),
 *          example="2023-07-28 00:00:00"
 *      ),
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
