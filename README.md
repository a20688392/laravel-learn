# Coding style
### [使用文章](https://www.techiediaries.com/git-hooks-husky-commitlint/)

## husky
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

### git hook
可以參考文章~

https://git-scm.com/book/zh/v2/%E8%87%AA%E5%AE%9A%E4%B9%89-Git-Git-%E9%92%A9%E5%AD%90

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
