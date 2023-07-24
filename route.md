# Laravel API路由
###### tags: `Laravel`
[Day 11 : user ( api routes )](https://ithelp.ithome.com.tw/articles/10220900)

在完成 Model 與 Migration 的設置後，我們將會定義 API routes，在講到 api routes 之前，先來介紹一下 Laravel 基本的 route 概念。

## Routing
最基本的 Router 結構為以下格式：
![](/docs/route-example.png)
### 基本常見的路由 HTTP method
> 各自涵義請看 Restful API 介紹

```
Route::get
Route::post
Route::delete
Route::patch
Route::put
```
### URL 則是網址呼叫的 API 位置
#### 例如
```php=
# 於 routes\api.php 最尾端加上
Route::get('/test', function () {
    return "hi";
});
Route::get('/test/{id}', function ($id) {
    return $id;
});
```
#### 測試方式
#### 1. laravel 內建伺服器
```bash=
# 在專案根目錄下指令
php artisan serve

# 打開網頁瀏覽器即可測試
http://127.0.0.1:8000/api/test
#回應應該是 hi
http://127.0.0.1:8000/api/test/1
#回應應該是 1
```
#### 2. 用 xampp or laragon 你常用的網頁伺服器都行
```bash=
# 假設你是 xampp，網頁根目錄是 C:\xampp\htdocs
# 專案位置在 C:\xampp\htdocs\laravel-learn
# 那網址就會是
http://localhost/laravel-learn/public/api/test
#回應應該是 hi
http://localhost/laravel-learn/public/api/test/1
#回應應該是 1
```
### CallBack 呼叫 Controller的class
```php=
# 最上面引入 Controller class
use App\Http\Controllers\UserController;
# 底部加入
Route::post('/users/register', [UserController::class, "register"]);
Route::post('/users/login', [UserController::class, "login"]);
```
### 可以將同樣路由合併
```php=
Route::prefix('users')->group(function () {
    Route::post('/register', [UserController::class, "register"]);
    Route::post('/login', [UserController::class, "login"]);
});
```
#### 測試方式
#### 1. laravel 內建伺服器
```bash=
# 在專案根目錄下指令
php artisan serve

# 打開網頁瀏覽器即可測試
# 註冊
http://127.0.0.1:8000/api/users/register
```
#### 2. 用 xampp or laragon 你常用的網頁伺服器都行
```bash=
# 假設你是 xampp，網頁根目錄是 C:\xampp\htdocs
# 專案位置在 C:\xampp\htdocs\laravel-learn
# 那網址就會是
# 註冊
http://localhost/laravel-learn/public/api/users/register
# 登入
http://localhost/laravel-learn/public/api/users/login
# 回傳和資料與上同樣
```

```php=
# 註冊
# 使用 POST
# body
# 在 postman 使用 form-data or raw
{
    "name":"test",
    "email":"test@example.com",
    "password":"testtest",
    "password_confirmation":"testtest"
}
# 回應應該類似以下
{
    "statusCode": 200,
    "message": "創建成功",
    "userData": {
        "name": "test123",
        "email": "test123@example.com",
        "updated_at": "2023-07-18T04:06:50.000000Z",
        "created_at": "2023-07-18T04:06:50.000000Z",
        "id": 4
    }
}
```
![](/docs/register-access.png)

```php=
# -----------------------------------
# 不符合驗證登入資料
{
    "name":"test123",
    "email":"test123@example.com",
    "password":"test",
    "password_confirmation":"testtest"
}
# 回應應該類似以下
{
    "statusCode": 400,
    "message": "註冊失敗",
    "error": {
        "email": [
            "信箱已被註冊"
        ],
        "password": [
            "password 最短6碼",
            "與密碼驗證不符"
        ]
    }
}
```
![](/docs/register-error.png)

```php=
# 登入
# 使用 POST
# body
# 在 postman 使用 raw
http://127.0.0.1:8000/api/users/login
# 符合驗證登入資料
{
    "email":"test@example.com",
    "password":"testtest"
}
# 回應應該類似以下
{
    "statusCode": 200,
    "message": "登入成功",
    "name": "test"
}
```
![](/docs/login-access.png)
```php=
# -----------------------------------
# 不符合驗證登入資料
{
    "email":"test",
    "password":"test"
}
# 回應應該類似以下
{
    "statusCode": 400,
    "message": "登入失敗",
    "errors": {
        "email": [
            "格式必須符合 email 格式"
        ],
        "password": [
            "password 最短6碼"
        ]
    }
}
```
![](/docs/login-error.png)

