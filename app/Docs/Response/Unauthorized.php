<?php

namespace App\Docs\Response;

/**
 *  @OA\Schema(
 *      schema="Unauthorized",
 *      @OA\Property(
 *          property="statusCode",
 *          description="HTTP 狀態碼",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="error",
 *          type="string",
 *          description="錯誤訊息",
 *      ),
 *      example={
 *          "statusCode": 401,
 *          "error": "Unauthorized"
 *      }
 *  )
 */
class Unauthorized
{
}
