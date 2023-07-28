<?php

namespace App\Docs\Comment\Models;

/**
 *  @OA\Schema(
 *      schema="Comment",
 *      @OA\Property(
 *          property="id",
 *          description="留言 ID",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="title",
 *          description="留言 標題",
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="description",
 *          description="留言 描述",
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          description="留言 創建時間",
 *          type="string",
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          description="留言 更新時間",
 *          type="string",
 *      ),
 *  )
 */
class Comment
{
}
