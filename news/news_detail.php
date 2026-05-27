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

$categories = [
    "all" => "すべて",
    "news" => "お知らせ",
    "event" => "イベント",
    "facility" => "施設情報",
    "campaign" => "キャンペーン"
];

$categorySql = "SELECT category , COUNT(*) AS count FROM onsen_hotel_site_table GROUP BY category";
$categoryStm = $pdo->query($categorySql);

$categoryCounts = [];

while ($row = $categoryStm->fetch(PDO::FETCH_ASSOC)){
    $categoryCounts[$row["category"]] = $row["count"];
}

//前の記事
$backStmt = $pdo->prepare("SELECT * FROM onsen_hotel_site_table WHERE id < :id ORDER BY id DESC LIMIT 1");
$backStmt->bindParam(':id', $id, PDO::PARAM_INT);
$backStmt->execute();
$back = $backStmt->fetch();

//次の記事
$nextStm = $pdo->prepare("SELECT * FROM onsen_hotel_site_table WHERE id > :id ORDER BY id ASC LIMIT 1");
$nextStm->bindParam(':id', $id, PDO::PARAM_INT);
$nextStm->execute();
$next = $nextStm->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>鳥沢温泉|<?= $news["title"] ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ma+Shan+Zheng&family=Noto+Serif+JP:wght@200..900&family=Yuji+Boku&display=swap"
        rel="stylesheet">
    <link href='https://cdn.boxicons.com/3.0.7/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/3.0.7/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/page_header.css">
    <link rel="stylesheet" href="./news_list2.css">
    <link rel="stylesheet" href="./news_detail.css">
</head>

<body>

    <header id="header">
        <div id="header-top">
            <a href="../header.php" class="main-logo">鳥沢温泉</a>

            <nav class="header-top-nav">
                <ul class="header-top-list">
                    <li><a href="/温泉/news/news_list.php">お知らせ</a></li>
                    <li><a href="">よくあるご質問</a></li>
                    <li><a href="/温泉/contact/contact.html">お問い合わせ</a></li>
                    <li><a href="/温泉/reservation/reservation.php">ご予約</a></li>
                    <li><a href=""><i class='bx  bx-camera-alt' style='color:#fff'></i> </a></li>
                </ul>
            </nav>
        </div>

        <div id="header-vew">
            <a href="" class="main-logo">鳥沢温泉</a>
            <nav class="header-nav">
                <ul class="header-nav-list">
                    <li><a href="">温泉</a></li>
                    <li><a href="">お部屋</a></li>
                    <li><a href="">お食事</a></li>
                    <li><a href="">交通案内</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
        <div class="peage_header">
            <p class=""><?= htmlspecialchars($categories[$news["category"]] ?? "その他", ENT_QUOTES, "UTF-8") ?></p>
        </div>


    <div class="con_news">

        <main class="main_news">
            <p class="date"><?= date("Y年m月d日", strtotime($news["created_at"])) ?></p>
            <h1 class="news_title"><?= htmlspecialchars($news["title"], ENT_QUOTES) ?></h1><!--文字列にするため　'も変換するように-->
            <div class="img_box <?= empty($news["image_name"]) ? "no_img" : "" ?>">
                <?php if (!empty($news["image_name"])): ?>
                    <img class="img" src="../upload/<?= $news["image_name"] ?>" alt="">
                <?php endif; ?>
            </div>
            <p class="message"><?= nl2br(htmlspecialchars($news["comment"], ENT_QUOTES, "UTF-8")) ?></p>

            <div class="page_button">
                <?php if ($back): ?>
                    <a class="turn_button" href="news_detail.php?id=<?= $back["id"] ?>">前の記事へ</a>
                <?php endif; ?>
                <a class="list_button" href="news_list.php">一覧に戻る</a>
                <?php if ($next): ?>
                    <a class="turn_button" href="news_detail.php?id=<?= $next["id"] ?>">次の記事へ</a>
                <?php endif; ?>
        </main>

        <aside class="category_list">
            <?php foreach ($categories as $kay => $label): ?>
                <a class="category" href="?category=<?= htmlspecialchars($kay) ?>">
                    <?= htmlspecialchars($label) ?>
                    (<?= htmlspecialchars($categoryCounts[$kay]?? "0" )?>)
                </a>
            <?php endforeach; ?>
        </aside>
    </div>
</body>

</html>