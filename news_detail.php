<?php
$id = $_GET['id'];

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=onsen_hotel_site',
        "root",
        ""
    );

    $stmt = $pdo->prepare("SELECT * FROM onsen_hotel_site_table WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $news = $stmt->fetch();
} catch (PDOException $e) {
    echo "エラー：" . $e->getMessage();
}
?>
    
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>鳥沢温泉|<?= $news["title"] ?></title>
</head>

<body>
    <h1><?= htmlspecialchars($news["title"], ENT_QUOTES) ?></h1><!--文字列にするため　'も変換するように-->
    <p><?= date("Y年m月d日",strtotime($news["created_at"]))?></p>
    <?php if (!empty($news["image_name"])): ?>
        <img src="upload/<?= $news["image_name"] ?>" alt="">
    <?php endif; ?>
    <p><?= $news["comment"] ?></p>
    <a href="news_list.php">一覧に戻る</a>
</body>

</html>