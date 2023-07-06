<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * 所有留言獲取
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        // 將存入 $data 的值插入，新增使用者
        $comments = Comment::all();

        $reposeData = [
            'statusCode' => Response::HTTP_OK,
            'message' => '所有留言搜尋成功',
            'userData' => $comments
        ];

        return response()->json(
            $reposeData,
            Response::HTTP_OK,
        );
    }
    /**
     * 所有留言獲取
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getOne($id)
    {
        // 將存入 $data 的值插入，新增使用者
        $comments = Comment::find($id);
        if (is_null($comments)) {
            $repose_data = [
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => '取得失敗',
                'errors' => [
                    "comment" => '單一留言搜尋失敗'
                ]
            ];

            return response()->json(
                $repose_data,
                Response::HTTP_NOT_FOUND
            );
        }

        $reposeData = [
            'statusCode' => Response::HTTP_NOT_FOUND,
            'message' => '單一留言搜尋成功',
            'userData' => $comments
        ];

        return response()->json(
            $reposeData,
            Response::HTTP_NOT_FOUND
        );
    }
    /**
     * 創建新留言
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createComment(Request $request)
    {
        // 驗證 client 端輸入
        $rules = [
            'title' => ['required', 'string', 'max:10'],
            'description' => ['required', 'string'],
        ];
        //更改默認 錯誤訊息
        $messages = [
            'title.required' => 'title 必填',
            'description.required' => 'description 必填'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        // 將錯誤訊息以 JSON 格式印出
        if ($validator->fails()) {
            $repose_data = [
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => '創建失敗',
                'errors' => $validator->errors()
            ];

            return response()->json(
                $repose_data,
                Response::HTTP_NOT_FOUND
            );
        }

        // 為了合併系統自動安排的值，先將之前的 request 值存在 $data 內
        $data = $request->all();

        // 將存入 $data 的值插入，新增使用者
        $comment = Comment::create($data);

        $reposeData = [
            'statusCode' => Response::HTTP_OK,
            'message' => '創建成功',
            'commentData' => $comment
        ];

        return response()->json(
            $reposeData,
            Response::HTTP_OK,
        );
    }
    /**
     * 更新留言
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateComment(Request $request, $id)
    {
        // 驗證 client 端輸入
        $rules = [
            'title' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string'],
        ];
        //更改默認 錯誤訊息
        $messages = [
            'title.required' => 'title 必填',
            'title.max' => 'title 只能十個字',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        // 將錯誤訊息以 JSON 格式印出
        if ($validator->fails()) {
            $repose_data = [
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => '創建失敗',
                'errors' => $validator->errors()
            ];

            return response()->json(
                $repose_data,
                Response::HTTP_NOT_FOUND
            );
        }
        $comment = Comment::find($id);
        if (is_null($comment)) {
            $repose_data = [
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => '取得失敗',
                'errors' => [
                    "comment" => [
                        '查無此留言'
                    ]
                ]
            ];

            return response()->json(
                $repose_data,
                Response::HTTP_NOT_FOUND
            );
        }
        $input = ['title', 'description'];
        foreach ($input as $key) {
            if ($request->has($key)) {
                $comment->$key = $request->$key;
            }
        }

        $comment->save();

        $reposeData = [
            'statusCode' => Response::HTTP_OK,
            'message' => '創建成功',
            'commentData' => $comment,
        ];

        return response()->json(
            $reposeData,
            Response::HTTP_OK,
        );
    }
    /**
     * 刪除留言-軟刪除
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteComment($id)
    {
        if (!is_numeric($id)) {
            $repose_data = [
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => '取得失敗',
                'errors' => [
                    "id" => [
                        'id 是數字'
                    ]
                ]
            ];

            return response()->json(
                $repose_data,
                Response::HTTP_NOT_FOUND
            );
        }
        $comment = Comment::find($id);
        if (is_null($comment)) {
            $repose_data = [
                'statusCode' => Response::HTTP_NOT_FOUND,
                'message' => '取得失敗',
                'errors' => [
                    "comment" => [
                        '查無此留言'
                    ]
                ]
            ];

            return response()->json(
                $repose_data,
                Response::HTTP_NOT_FOUND
            );
        }
        $comment->delete();

        $reposeData = [
            'statusCode' => Response::HTTP_OK,
            'message' => '刪除成功',
            'commentData' => $comment,
        ];

        return response()->json(
            $reposeData,
            Response::HTTP_OK,
        );
    }
}
