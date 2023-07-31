# Coding style

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
![image](/docs/php-pre-commit.png)

#### 依據規定找出各開發者的錯誤
![image](/docs/ci-report.png)

### git hook
可以參考文章~ 關於 [git hook](https://git-scm.com/book/zh/v2/%E8%87%AA%E5%AE%9A%E4%B9%89-Git-Git-%E9%92%A9%E5%AD%90)

#### 設定進 pre-commit
> 由於直接改 .git/hooks 是不會被追蹤的

> 因此自訂 檢查腳本

> 將會"只"檢查 git staged changes 中的程式碼

#### 新增腳本 .githooks\pre-commit
```bash
# .githooks\pre-commit
# 放入以下程式碼
#!/bin/bash

# Function to check if a file is in the Git staged area
function is_staged {
    git diff --cached --name-only | grep -q "$1"
}

# Function to run PHP_CodeSniffer on the staged files
function run_phpcs_on_staged {
    vendor/bin/phpcs --standard=psr12 -p $@
}

# Function to check if PHP_CodeSniffer reported any errors
function phpcs_has_errors {
    if [[ -n $(run_phpcs_on_staged "$@") ]]; then
        return 0 # Has errors
    else
        return 1 # No errors
    fi
}

# Function to display errors and abort commit
function display_errors_and_abort {
    echo "PHP_CodeSniffer found errors. Please fix them before committing."
    run_phpcs_on_staged "$@" # Rerun PHP_CodeSniffer to display full error output
    exit 1 # Exit with non-zero status code to prevent the commit
}

# Directories to scan
DIRECTORIES_TO_SCAN=("app" "config" "routes" "tests")

# Process the staged code
function process_staged_code {
    # Check each directory in DIRECTORIES_TO_SCAN
    for dir in "${DIRECTORIES_TO_SCAN[@]}"; do
        if is_staged "$dir"; then
            # Get the files in the staged directory
            staged_files=$(git diff --cached --name-only --diff-filter=ACM "$dir")

            # Run PHP_CodeSniffer on the staged files and check for errors
            if phpcs_has_errors "$staged_files"; then
                display_errors_and_abort "$staged_files"
            fi
        fi
    done
}

# Call the function to process staged code
process_staged_code

# If no errors found, allow the commit to proceed
exit 0
```
#### 讓腳本可被 git hook 使用
```bash
git config core.hooksPath .githooks
```
#### 讓腳本可在 linux 中運行
```bash
chmod +x .githooks\pre-commit
```
#### 在初始化專案時，啟動 git hook
```
//composer.json
"scripts": {
  //..
  // 設定顏色顯示
  // 設定規範為 PSR12
  "post-install-cmd": [
    //..
    "git config core.hooksPath .githooks"
  ],
}
```