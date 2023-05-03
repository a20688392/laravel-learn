# ENV 設定

## 在那之前先來做環境初始化
### 先來確認以下事情
#### 1. .env 設定
>.env 檔並不會預設就存在，因為這是整個專案的環境變數

> 將 .env.example 複製成 .env

>會被放在 [.gitignore](https://medium.com/@ji3g4kami/gitignore-%E5%A4%A7%E5%B0%8F%E4%BA%8B-9016584660f6) 放於例外

![image](/docs/env-setting.png)

#### 2. 預設情況下，不會有 APP key
> 透過artisan產生一組網站專屬密鑰用來確保session、password等加密資料安全性

![image](/docs/php-key.png)
```bash=
php artisan key:generate
```
>就會在 .env 產生

![image](/docs/app-key.png)

3. 設定資料庫資訊

![image](/docs/database.png)

4. 設定時區
> 於 config/app.php

> 找到 timezone ，將原本的改成

> 'timezone' => env('APP_TIMEZONE', 'UTC'),

> 將它取代成使用環境變數，沒有的情況預設 UTC

![image](/docs/timezone.png)

> 記得 .env 和 .env.example 都要加上

![image](/docs/env-example-timezone.png)
![image](/docs/env-timezone.png)
