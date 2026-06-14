<?php
try {
    $pdo = new PDO(
        'mysql:host=DBホスト名;dbname=DB名;charset=utf8',
        'ユーザー名',
        'パスワード',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "接続成功";
} catch (PDOException $e) {
    echo "接続失敗：" . $e->getMessage();
}