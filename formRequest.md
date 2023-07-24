# laravel FormRequest
[Day 10. FormRequest 管理驗證規則的好幫手](https://ithelp.ithome.com.tw/articles/10214788)

[Day 05. 一不小心就會扯遠的依賴注入 (DI)](https://ithelp.ithome.com.tw/articles/10213983)

## FormRequest

### 原理是因為依賴注入(Dependency Injection，DI)

我們可以從 Illuminate\Http\Request 的 api 文件中看到，Request 本身並沒有帶入驗證規則，所以我們才需要在 controller 中自行驗證。好在從 Illuminate\Foundation\Http\FormRequest (後續簡稱 FormRequest) 我們可以看到它具有 validateResolved() 功能，這個 function 是當 FormRequest 產生實例後會去執行、驗證本身是否合法:

#### 客製驗證回應
下面是將驗證的規則跟客製的錯誤訊息寫至 FormRequest 的作法:

在 cmd 中執行以下指令產生位置在 App\Http\Requests 的 FormRequest。
```bash=
php artisan make:request <Request 名稱>
```

### 準備好一個全域繼承
```
app
├───Http
│   ├───Controllers
│   ├───Middleware
│   └───Requests
│       └───AllRequest.php
```
```bash=
# app\Http\Requests\AllRequest.php
<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class AllRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * 回傳相應的錯誤訊息
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
    protected function failedValidation(Validator $validator)
    {
        // 取得錯誤資訊
        $responseData = $validator->errors();
        $httpStatus = Response::HTTP_BAD_REQUEST;
        $response = [
            "statusCode" => $httpStatus,
            "error" => $responseData
        ];
        // 產生 JSON 格式的 response，(422 是 Laravel 預設的錯誤 http status，可自行更換)，這邊以 400
        $response = response()->json($response, $httpStatus);
        // 丟出 exception
        throw new HttpResponseException($response);
    }
}


```

### UserLogin 去繼承 AllRequest
重寫 規則(rules)、回應訊息(messages)
```
app
├───Http
│   ├───Controllers
│   ├───Middleware
│   └───Requests
│       ├───User
│       │   └───UserLogin.php
│       └───AllRequest.php
```
```bash=
# app\Http\Requests\User\UserLogin.php

<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AllRequest;

class UserLogin extends AllRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * 回傳相應的錯誤訊息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'email 必填',
            'email.email' => '格式必須符合 email 格式',
            'password.required' => 'password 必填',
            'password.min' => 'password 最短6碼',
        ];
    }
}

```

### UserRegister 去繼承 AllRequest
重寫 規則(rules)、回應訊息(messages)
```
app
├───Http
│   ├───Controllers
│   ├───Middleware
│   └───Requests
│       ├───User
│       │   ├───UserRegister.php
│       │   └───UserLogin.php
│       └───AllRequest.php
```
```bash=
# app\Http\Requests\User\UserRegister.php

<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AllRequest;

class UserRegister extends AllRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }

    /**
     * 回傳相應的錯誤訊息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'name 必填',
            'name.min' => 'name 最短2個字',
            'name.max' => 'name 最長255個字',
            'email.required' => 'email 必填',
            'email.email' => '格式必須符合 email 格式',
            'email.max' => 'email 最長255個字',
            'email.unique' => '信箱已被註冊',
            'password.required' => 'password 必填',
            'password.min' => 'password 最短6碼',
            'password.confirmed' => '與密碼驗證不符'
        ];
    }
}


```
### 如何應用在 Controller
```bash=
# app\Http\Controllers\UserController.php

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLogin;
use App\Http\Requests\UserRegister;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * 使用者註冊
     *
     * @param  UserRegister  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegister $request)
    {
        $reposeData = [
            'status' => 200,
            'message' => '創建成功',
        ];
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
        ]);
        return response()->json(
            $reposeData,
            200,
        );
    }

    /**
     * 使用者登入
     * @param UserLogin $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLogin $request)
    {
        $attempt =  User::where('email', $request->email)->first();
        if ($attempt && Hash::check($request->password, $attempt->password)) {
            $httpStatus = 200;
            $reposeData = [
                'message' => '登入成功',
                "name" => $attempt->name
            ];
        } else {
            $httpStatus = 401;
            $reposeData = [
                'message' => '登入失敗',
                "errors" => [
                    "auth" => "帳號或密碼錯誤"
                ]
            ];
        }

        return response()->json(
            $reposeData,
            $httpStatus
        );
    }
}

```