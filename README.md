部屬步驟
===

## 匯入資料庫
```
CREATE DATABASE webtrain_messageboard;
SOURCE webtrain_messageboard.sql;
```

## 設定環境變數
```
cp env.php.example env.php
```
再修改 `env.php` 裡面的 `DB_HOST`(主機)、`DB_USER`(使用者名稱)、`DB_PWD`(密碼) 等資訊

Update Note
===

## 2020/05/19
1. 修改commit訊息`[Feature]修改符合PSR`

## 2020/05/16
1. 修改符合PSR
2. 新增 `README.md`
