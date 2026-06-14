<?php
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=konsent_onsen',
        "konsent_onsen",
        "Tika0724",
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

$error = $_SESSION["error"] ?? "";
$old = $_SESSION["old"] ?? "";
unset($_SESSION["error"], $_SESSION["old"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>鳥沢温泉 | お知らせ</title>
    <link rel="icon" href="../img/favicon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ma+Shan+Zheng&family=Noto+Serif+JP:wght@200..900&family=Yuji+Boku&display=swap"
        rel="stylesheet">
    <link href='https://cdn.boxicons.com/3.0.7/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/3.0.7/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./news_form.css">
</head>

<body>
    <a href="./news_list.php">ニュースリストへ</a>

    <?php if ($error): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif ?>

    <form action="./news_post.php" class="formwrraper" method="POST" enctype="multipart/form-data">

        <label for="title">タイトル</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($old["title"] ?? "") ?>">

        <label for="text">テキスト</label>
        <textarea name="comment" id="text"><?= htmlspecialchars($old["comment"] ?? "") ?></textarea>

        <input type="file" name="image" id="fileInput" value="<?= htmlspecialchars($old["img"] ?? "") ?>">
        <img class="preview" id="preview" src="">

        <select name="category" id="category">
            <option value="" disabled <?= empty($old["category"]) ? "selected" : "" ?>>カテゴリー</option>
            <option value="all" <?= ($old["category"] ?? "") === "all" ? "selected" : "" ?>>すべて</option>
            <option value="info" <?= ($old["category"] ?? "") === "info" ? "selected" : "" ?>>お知らせ</option>
            <option value="event" <?= ($old["category"] ?? "") === "event" ? "selected" : "" ?>>イベント</option>
            <option value="facility" <?= ($old["category"] ?? "") === "event" ? "selected" : "" ?>>施設情報</option>
            <option value="campaign" <?= ($old["category"] ?? "") === "category" ? "selected" : "" ?>>キャンペーン</option>
        </select>

        <input type="submit" value="投稿" name="submitbtn">
    </form>

</body>

<script>
    document.getElementById("fileInput").addEventListener("change", function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.getElementById("preview");
                preview.src = e.target.result;
                preview.style.display = "block";
            }

            reader.readAsDataURL(file);
        }
    });
</script>

</html>