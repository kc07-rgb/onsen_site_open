<?php
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=onsen_hotel_site',
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    echo $e->getMessage();
    exit("DB接続エラー");
}

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>鳥沢温泉 | お知らせ</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ma+Shan+Zheng&family=Noto+Serif+JP:wght@200..900&family=Yuji+Boku&display=swap"
        rel="stylesheet">
    <link href='https://cdn.boxicons.com/3.0.7/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/3.0.7/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./news.css">
</head>

<body>
    <a href="./news_list.php">ニュースリストへ</a>
    <form action="news_post.php" class="formwrraper" method="POST" enctype="multipart/form-data">
        <label for="title">タイトル</label>
        <input type="text" name="title" id="title">
        <label for="text">テキスト</label>
        <textarea name="comment" id="text"></textarea>
        <input type="file" name="image">
        <select name="category" id="category">
            <option value="" disabled selected>カテゴリー</option>
            <option value="all">すべて</option>
            <option value="info">お知らせ</option>
            <option value="event">イベント</option>
            <option value="facility">施設情報</option>
            <option value="campaign">キャンペーン</option>
        </select>
        <input type="submit" value="投稿" name="submitbtn">
    </form>

</body>

</html>