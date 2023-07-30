<?php

namespace App\Docs;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Board API Demo",
 *     description="留言板API 文件",
 * )
 * @OA\PathItem(
 *     path="/"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * )
 */
class Info
{
}
