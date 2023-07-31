# Coding style
### [使用文章](https://www.techiediaries.com/git-hooks-husky-commitlint/)

## git commit 檢查
### husky
https://github.com/typicode/husky

幫助我們處理git hook時，自動處理我們所寫的規則~!

### yarn npm 選一個用
```bash=
yarn add husky -D
or
npm install husky --save-dev
```

### 安裝檢查commit套件庫與預設模板
```bash=
yarn add @commitlint/cli @commitlint/config-conventional  -D
or
npm install @commitlint/cli @commitlint/config-conventional  --save-dev
```

#### 啟動掛勾
```bash=
npx husky install
```
#### 使初始化安裝時自動啟動掛勾
```
"scripts": {
        //
        "prepare": "husky install"
    },
```

### git hook
可以參考文章~ 關於 [git hook](https://git-scm.com/book/zh/v2/%E8%87%AA%E5%AE%9A%E4%B9%89-Git-Git-%E9%92%A9%E5%AD%90)

#### 設定進 commit-msg
```bash=
npx husky add .husky/commit-msg 'npx commitlint --edit $1'
```

### 創建預設模板設定
```bash=
#在根目錄新增
commitlint.config.js
#裡面加入
module.exports = {
  extends: ['@commitlint/config-conventional'],
};
```
#### 錯誤版本
![image](/docs/commit-error.png)

#### 依據規定版本
![image](/docs/commit-access.png)

---

## 程式碼檢測


### 安裝 php_codesniffer
```bash=
composer require "squizlabs/php_codesniffer=*" --dev
```
#### 新增在 composer install 後初始化檢查設定
#### [關於 composer scripts](https://docs.phpcomposer.com/articles/scripts.html)
#### [關於 phpcs/phpcbf 設定](https://clouding.city/php/phpcs-phpcbf/)
```bash=
//composer.json
"scripts": {
  //..
  // 設定顏色顯示
  // 設定規範為 PSR12
  "post-install-cmd": [
    "phpcs --config-set colors 1",
    "phpcs --config-set default_standard PSR12"
  ],
}
```

#### 新增自訂指令可以自己檢查
```bash=
//composer.json
"scripts": {
  //..
  // phpcs 為檢查
  // phpcbf 為修理
  // 檢查為 PSR12 (--standard=psr12)
  // 顯示進度 (-p)
  // 設定檢查範圍 (app/ config/ routes/ tests/)
  // 確定是誰向 Git 存儲庫提交了每個錯誤和警告 (--report)
  "lint": [
    "phpcs --standard=psr12 -p app/ config/ routes/ tests/"
  ],
  "lint:save": [
    "phpcbf --standard=psr12 -p app/ config/ routes/ tests/"
  ],
  "lint:report": [
    "phpcs --standard=psr12 -p -s --report=gitblame app/ config/ routes/ tests/"
  ]
}
```

#### 依據規定找出錯誤
![image](/docs/lint-error.png)

#### 依據規定找出各開發者的錯誤
![image](/docs/ci-report.png)

### lint-staged 只會處理 git staged 中的程式碼
#### 新增在 git commit 前檢查並修理
>但是不會 commit 進 git staged 內

#### 安裝 lint-staged
```bash=
yarn add -D lint-staged
```
#### 寫入husky git hook
```bash=
npx husky add .husky/pre-commit "npx lint-staged"
```
#### 設定進 pre-commit
> 設定 phpcbf 修理、PSR12、顯示進度、範圍(app/ config/ routes/ tests/)
```bash=
// package.json
{
  //..
  "lint-staged": {
    "{app, config, routes, tests}/**/*.php": "composer lint"
  }
}
```


