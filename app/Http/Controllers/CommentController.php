<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentCreate;
use App\Http\Requests\Comment\CommentUpdate;
use App\Models\Comment;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.verified', ['except' => ['getAll', 'getOne']]);
    }
    /**
     * 獲取所有留言
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        // 將存入 $data 的值插入，新增使用者
        $comments = Comment::all();

        $httpStatus = Response::HTTP_OK;
        $reposeData = [
            'statusCode' => $httpStatus,
            'message' => '獲取所有留言成功',
            'comments' => $comments
        ];

        return response()->json(
            $reposeData,
            $httpStatus
        );
    }
    /**
     * 獲取單一留言
     *
     * @param  int  $id 留言 ID
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
        // 搜尋指定留言 ID 是否存在
        $comment = Comment::find($id);
        if ($comment == null) {
            $httpStatus = Response::HTTP_NOT_FOUND;
            $repose_data = [
                'statusCode' => $httpStatus,
                'message' => '取得失敗',
                'errors' => [
                    "comment" => '單一留言搜尋失敗'
                ]
            ];

            return response()->json(
                $repose_data,
                $httpStatus
            );
        }
        $httpStatus = Response::HTTP_OK;
        $reposeData = [
            'statusCode' => $httpStatus,
            'message' => '單一留言搜尋成功',
            'comment' => $comment
        ];

        return response()->json(
            $reposeData,
            $httpStatus
        );
    }
    /**
     * 創建新留言
     *
     * @param  CommentCreate  $request
     * @return \Illuminate\Http\Response
     */
    public function createComment(CommentCreate $request)
    {
        // 為了合併系統自動安排的值，先將之前的 request 值存在 $data 內
        $data = $request->all();
        $data['user_id'] = auth('api')->id();

        // 將存入 $data 的值插入，創建新留言
        $comment = Comment::create($data);

        $httpStatus = Response::HTTP_OK;
        $reposeData = [
            'statusCode' => $httpStatus,
            'message' => '創建留言成功',
            'commentData' => $comment
        ];

        return response()->json(
            $reposeData,
            $httpStatus
        );
    }
    /**
     * 更新留言
     *
     * @param  CommentUpdate  $request
     * @return \Illuminate\Http\Response
     */
    public function updateComment(CommentUpdate $request, $id)
    {
        $comment = Comment::find($id);
        if (is_null($comment)) {
            $httpStatus = Response::HTTP_NOT_FOUND;
            $repose_data = [
                'statusCode' => $httpStatus,
                'message' => '取得失敗',
                'errors' => [
                    "comment" => [
                        '查無此留言'
                    ]
                ]
            ];

            return response()->json(
                $repose_data,
                $httpStatus
            );
        }
        if ($comment->user_id != auth('api')->id()) {
            $httpStatus = Response::HTTP_FORBIDDEN;
            $repose_data = [
                'statusCode' => $httpStatus,
                'message' => '更改失敗',
                'errors' => [
                    "comment" => [
                        '非本人'
                    ]
                ]
            ];

            return response()->json(
                $repose_data,
                $httpStatus
            );
        }
        $input = ['title', 'description'];
        foreach ($input as $key) {
            if ($request->has($key)) {
                $comment->$key = $request->$key;
            }
        }

        $comment->save();

        $httpStatus = Response::HTTP_OK;
        $reposeData = [
            'statusCode' => $httpStatus,
            'message' => '修改成功',
            'commentData' => $comment,
        ];

        return response()->json(
            $reposeData,
            $httpStatus
        );
    }
    /**
     * 刪除留言-軟刪除
     *
     * @param  int  $id 留言 ID
     * @return \Illuminate\Http\Response
     */
    public function deleteComment($id)
    {
        if (!is_numeric($id)) {
            $httpStatus = Response::HTTP_BAD_REQUEST;
            $repose_data = [
                'statusCode' => $httpStatus,
                'message' => '取得失敗',
                'errors' => [
                    "id" => [
                        'id 是數字'
                    ]
                ]
            ];

            return response()->json(
                $repose_data,
                $httpStatus
            );
        }
        $comment = Comment::find($id);
        if ($comment == null) {
            $httpStatus = Response::HTTP_NOT_FOUND;
            $repose_data = [
                'statusCode' => $httpStatus,
                'message' => '取得失敗',
                'errors' => [
                    "comment" => [
                        '查無此留言'
                    ]
                ]
            ];

            return response()->json(
                $repose_data,
                $httpStatus
            );
        }
        if ($comment->user_id != auth('api')->id()) {
            $httpStatus = Response::HTTP_FORBIDDEN;
            $repose_data = [
                'statusCode' => $httpStatus,
                'message' => '更改失敗',
                'errors' => [
                    "comment" => [
                        '非本人'
                    ]
                ]
            ];

            return response()->json(
                $repose_data,
                $httpStatus
            );
        }
        $comment->delete();

        $httpStatus = Response::HTTP_OK;
        $reposeData = [
            'statusCode' => $httpStatus,
            'message' => '刪除成功',
            'commentData' => $comment,
        ];

        return response()->json(
            $reposeData,
            $httpStatus
        );
    }
}
