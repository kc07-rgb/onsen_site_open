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
    "info" => "お知らせ",
    "event" => "イベント",
    "facility" => "施設情報",
    "campaign" => "キャンペーン"
];

$categorySql = "SELECT category , COUNT(*) AS count FROM onsen_hotel_site_table GROUP BY category";
$categoryStm = $pdo->query($categorySql);

$categoryCounts = [];

while ($row = $categoryStm->fetch(PDO::FETCH_ASSOC)) {
    $categoryCounts[$row["category"]] = $row["count"];
}
$categoryCounts["all"] = array_sum($categoryCounts);

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
    <link rel="icon" href="./img/favicon.png"></link>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ma+Shan+Zheng&family=Noto+Serif+JP:wght@200..900&family=Yuji+Boku&display=swap"
        rel="stylesheet">
    <link href='https://cdn.boxicons.com/3.0.7/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/3.0.7/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../style.css">

    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./news_list2.css">
    <link rel="stylesheet" href="./news_detail.css">
    <link rel="stylesheet" href="../css/page_footer.css">
</head>

<body>

    <?php if (isset($_SESSION["user_id"])): ?>
        <div class="admin_header">
            <p>鳥沢温泉/管理画面</p>
            <nav>
                <ul>
                    <li><a href="./news_form.php">ニュース投稿</a></li>
                    <li><a href="/onsen/users/logout.php">ログアウト</a></li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>

    <header id="header">
        <!--header-->
        <header id="header">
            <div id="header-top">
                <a href="../index.php" class="header-logo">鳥沢温泉</a>

                <nav class="header-top-nav">
                    <ul class="header-top-list">
                        <li><a href="/onsen/news/news_list.php">お知らせ</a></li>
                        <li><a href="../qa/qa.html">よくあるご質問</a></li>
                        <li><a href="/onsen/contact/contact.html">お問い合わせ</a></li>
                        <li><a href="/onsen/reservation/reservation.php">ご予約</a></li>
                        <li><a href=""><i class='bx  bx-camera-alt' style='color:#fff'></i> </a></li>
                    </ul>
                </nav>
            </div>

            <div id="header-vew">
                <a href="../index.php" class="header-vew-logo">鳥沢温泉</a>
                <nav class="header-nav">
                    <ul class="header-nav-list">
                        <li><a href="../index.php#spa">温泉</a></li>
                        <li><a href="../index.php#room">お部屋</a></li>
                        <li><a href="../index.php#dish">お食事</a></li>
                        <li><a href="../index.php#footer_info">交通案内</a></li>
                    </ul>
                </nav>
            </div>
        </header>


        <!--page-->
        <div id="page">
            <div class="page_tatile">
                <h2 class="jp">お知らせ</h2>
                <p class="em">News</p>
                <p class="description">鳥沢温泉からみなさまへの<br>
                    大切なお知らせをお届けいたします。</p>
            </div>

            <!--wave-->
            <div class="pc_wave custom-shape-divider-bottom-1779276235">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
                </svg>
            </div>
            <div class="smartphon_wave">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                    <path fill="#f4f0e8" d="M0,192L60,202.7C120,213,240,235,360,218.7C480,203,600,149,720,149.3C840,149,960,203,1080,208C1200,213,1320,171,1380,149.3L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
                </svg>
            </div>
        </div>
    </header>

    <!--hamburger-->
    <div class="hamburger">
        <div class="top"></div>
        <div class="middle"></div>
        <div class="bottom"></div>
    </div>

    <div class="hamburger-container">
        <h2><a href="../index.php">鳥沢温泉</a></h2>
        <nav class="hamburger-nav">
            <ul class="hamburger-nav-list left">
                <li><a href="../index.php#spa">温泉</a></li>
                <li><a href="../index.php#room">お部屋</a></li>
                <li><a href="../index.php#dish">お食事</a></li>
                <li><a href="../index.php#footer">交通案内</a></li>
            </ul>
            <ul class="hamburger-nav-list right">
                <li><a href="/onsen/news/news_list.php">お知らせ</a></li>
                <li><a href="">よくあるご質問</a></li>
                <li><a href="/onsen/contact/contact.html">お問い合わせ</a></li>
                <li><a href="/onsen/reservation/reservation.php">ご予約</a></li>
                <li><a href=""><i class='bx  bx-camera-alt' style='color:#fff'></i> </a></li>
            </ul>
        </nav>
    </div>


    <!--con_news-->
    <div class="con_news">

        <main class="main_news">
            <p class="page_category">
                <?= htmlspecialchars($categories[$news["category"]] ?? "お知らせ", ENT_QUOTES, "UTF-8") ?>
            </p>

            <p class="date"><?= date("Y年m月d日", strtotime($news["created_at"])) ?></p>

            <h1 class="news_title"><?= htmlspecialchars($news["title"], ENT_QUOTES) ?></h1>

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

        <div class="aside">
            <p class="aside_title_jp">カテゴリ</p>
            <p class="aside_title_en">category</p>
            <aside class="category_list">
                <ul>
                    <?php foreach ($categories as $kay => $label): ?>
                        <li>
                            <a class="category_link" href="news_list.php?category=<?= htmlspecialchars($kay) ?>">
                                <?= htmlspecialchars($label) ?>
                                (<?= htmlspecialchars($categoryCounts[$kay] ?? "0") ?>)
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>
        </div>
    </div>

    <footer id="page_footer">
        <div id="page_footer_info_box">
            <div class="page_footer_info">
                <p class="main-logo"><a href="../index.php">鳥沢温泉</a></p>
                <address>
                    <p>〒×××-×××× 岩手県小鳥市11-111</p>
                    <p>tel.0000-00-0000/9:00~18:00</p>
                </address>
            </div>

            <nav id="page_footer_nav">
                <div class="nav-v">
                    <ul class="nav-v-list">
                        <li><a href="">ホーム</a></li>
                        <li><a href="">温泉</a></li>
                        <li><a href="">お部屋</a></li>
                        <li><a href="">お食事</a></li>
                        <li><a href="">交通案内</a></li>
                    </ul>
                </div>

                <div class="nav-w">
                    <ul class="nav-w-list">
                        <li><a href="../qa/qa.html">よくあるご質問</a></li>
                        <li><a href="../contact/contact.html">お問い合わせ</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </footer>

    <script src="../app.js"></script>
</body>

</html>