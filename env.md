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
>不更改的話是寫死的，輸出的時間都將會是UTC，台灣是Asia/Taipei (UTC+8)

> 於 config/app.php

> 找到 timezone ，將原本的改成

> 'timezone' => env('APP_TIMEZONE', 'UTC'),

> 將它取代成使用環境變數，沒有的情況預設 UTC

![image](/docs/timezone.png)

> 記得 .env 和 .env.example 都要加上

![image](/docs/env-example-timezone.png)
![image](/docs/env-timezone.png)

---
## 以下為在 Linux 的環境需要做的事情
https://learnku.com/laravel/wikis/25560
### storage 權限不足
![image](/docs/storage.png)

#### 本主機是開發環境用
>將檔案權限全開啟(不安全)
```
chmod -R 0777 storage
```

#### 本主機是正式環境用
>正式環境上應該遵循「最小權限原則」

```
chown -R www-data:www-data storage
```
![image](/docs/finish.png)
## 正式環境下務必
![image](docs/production-env.png)
```
APP_NAME
config/app.php
預設為 Laravel
此服務名稱

APP_ENV
config/app.php
預設為 production
此開發環境，用於加載不同環境時的配置
理論是可以任何值，只要團隊說好就行

通常為
開發: local
測試: test
預上線: staging #嚴謹時才會出現
正式環境: production

APP_DEBUG
config/app.php
預設為 false
開啟時一旦發生錯誤會跳在網頁上，有可能會將重要資訊或程式碼洩漏

APP_URL
config/app.php
預設為 http://localhost
為此服務預設的網頁根目錄
```