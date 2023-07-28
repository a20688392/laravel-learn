<?php

namespace App\Docs\Response;

/**
 *  @OA\Schema(
 *      schema="BadRequest",
 *      @OA\Property(
 *          property="statusCode",
 *          description="HTTP 狀態碼",
 *          type="integer",
 *      ),
 *      @OA\Property(
 *          property="error",
 *          type="object",
 *          description="錯誤訊息",
 *          @OA\Property(
 *              property="欄位1",
 *              type="array",
 *              @OA\Items(type="string"),
 *          ),
 *          @OA\Property(
 *              property="欄位2",
 *              type="array",
 *              @OA\Items(type="string"),
 *          ),
 *      ),
 *      example={
 *          "statusCode": 400,
 *          "error": {
 *              "欄位1": {
 *                  "錯誤原因1",
 *                  "錯誤原因2",
 *              },
 *              "欄位2": {
 *                  "錯誤原因1",
 *                  "錯誤原因2",
 *              }
 *          },
 *      }
 *  )
 */
class BadRequest
{
}
