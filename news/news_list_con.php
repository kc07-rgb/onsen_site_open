<?php
session_start();
require "news_category.php";
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

//category
$categories = [
    "all" => "すべて",
    "info" => "お知らせ",
    "event" => "イベント",
    "facility" => "施設情報",
    "campaign" => "キャンペーン"
];

$current = $_GET["category"] ?? "all";
if (!array_key_exists($current, $categories)) {
    $current =  "all";
}

if ($current === "all") {
    $where = "";
} else {
    $where = "where category  = " . $pdo->quote($current);
}



$limit = 5;

$total_news = $pdo->query("SELECT COUNT(*) FROM onsen_hotel_site_table $where")->fetchColumn();
//$pdo->query("sql") sqlを実行する 
//COUNT(*)件数を数える
//->fetchColumn()　結果の一列目だけ取り出す　->$オブジェクト->の中の機能(メソッド)を使う記号
$total_pages = ceil($total_news / $limit);
//ceil切り上げ


// 今何ページ目か取得（URLから）
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; //?条件式 urlにpageがあるか　ある場合は数字:なければ1
//issetその変数が存在していて、nullではないかを確認する関数
//(int)$_GET['page']送らて来たurlを整数に変換(GETは文字列として送られてくる)
// マイナス防止
if ($page < 1) $page = 1;

// 何件飛ばすか計算
$offset = ($page - 1) * $limit;

$sql = "
    SELECT id, image_name, comment, created_at, title, category
    FROM onsen_hotel_site_table
    $where
    ORDER BY created_at DESC
    LIMIT $limit OFFSET $offset 
";
// LIMIT $limit OFFSET $offset  OFFSET数飛ばして 次のLIMIT数取得する

$news_array = $pdo->query($sql); //sql は温泉のデータベース　$news_arrayを変数名にして、下で配列を取り出すようにする。

$pdo = null;

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
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./news_list2.css">
    <link rel="stylesheet" href="../css/page_footer.css">
</head>

<body>
    <!--header-->
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
            <a href="../header.php" class="main-logo">鳥沢温泉</a>
            <nav class="header-nav">
                <ul class="header-nav-list">
                    <li><a href="../header.php#spa">温泉</a></li>
                    <li><a href="">お部屋</a></li>
                    <li><a href="">お食事</a></li>
                    <li><a href="">交通案内</a></li>
                </ul>
            </nav>
        </div>

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
        <h2><a href="../header.php">鳥沢温泉</a></h2>
        <nav class="hamburger-nav">
            <ul class="hamburger-nav-list left">
                <li><a href="">温泉</a></li>
                <li><a href="">お部屋</a></li>
                <li><a href="">お食事</a></li>
                <li><a href="">交通案内</a></li>
            </ul>
            <ul class="hamburger-nav-list right">
                <li><a href="/温泉/news/news_list.php">お知らせ</a></li>
                <li><a href="">よくあるご質問</a></li>
                <li><a href="/温泉/contact/contact.html">お問い合わせ</a></li>
                <li><a href="/温泉/reservation/reservation.php">ご予約</a></li>
                <li><a href=""><i class='bx  bx-camera-alt' style='color:#fff'></i> </a></li>
            </ul>
        </nav>
    </div>


    <div class="nav">
        <nav>
            <a href="../header.php">鳥沢温泉</a>
            <a href="./news_form.php">ニュースフォーム</a>
            <a href="/温泉/users/user_ registration.php">ユーザー登録</a>
            <a href="../users/login.php">ログイン</a>
            <a href="/温泉/users/logout.php">ログアウト</a>
        </nav>
    </div>



    <div class="news_list">
        <ul class="category">
            <?php foreach ($categories as $key => $label): ?>
                <li>
                    <a href="?category=<?= htmlspecialchars($key) ?>"
                        class="<?= $current === $key ? 'active' : '' ?>">
                        <?= htmlspecialchars($label) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="fresh_news">
            <div class="news">
                <ul class="news_box">
                    <?php foreach ($news_array as $news) : ?>

                        <div class="news_line">
                            <li><a class="news_pieces" href="news_detail.php?id=<?= $news["id"] ?>">
                                    <div class="no_img">
                                        <?php if (!empty($news["image_name"])): ?>
                                            <div class="news_box_img"><img src="../upload/<?= $news["image_name"] ?>" alt="">
                                            </div>
                                        <?php endif ?>
                                    </div>

                                    <div class="news_box_text">
                                        <div class="day_category">
                                            <time class="created_at"><?= date("Y.m.d", strtotime($news["created_at"])); ?></time>
                                            <p class="current_category <?= htmlspecialchars($news["category"]) ?>">
                                                <?= htmlspecialchars($categories[$news["category"]]) ?? "" ?>
                                            </p>
                                        </div>
                                        <p class="title"><?= htmlspecialchars($news["title"], ENT_QUOTES) ?></p>
                                    </div>
                                    <svg class="icon_arrow" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="width: 32px; height: 32px; opacity: 1;" xml:space="preserve">
                                        <polygon class="st0" points="419.916,71.821 348.084,0 92.084,256.005 348.084,512 419.916,440.178 235.742,256.005"></polygon>
                                    </svg>
                                </a>
                                <div class="edit">
                                    <?php if (isset($_SESSION["user_id"])): ?>
                                        <a href="news_edit.php?id=<?= $news["id"] ?>">編集</a>
                                        <a href="news_delete.php?id=<?= $news["id"] ?>">削除</a>
                                    <?php endif; ?>
                                </div>
                            </li>
                        </div>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!--ページネーション-->
        <div class="pagenation">

            <!--前へ-->
            <?php if ($page > 1): ?>
                <a class="page_move" href="?page=<?= $page - 1 ?>&category=<?= htmlspecialchars($current) ?>">前へ</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a class="<?= ($page == $i) ? "active" : "" ?>" href="?page=<?= $i ?>&category=<?= htmlspecialchars($current) ?>"><?= $i ?></a>
            <?php endfor; ?>

            <!--次へ-->
            <?php if ($page < $total_pages): ?>
                <a class="page_move" href="?page=<?= $page + 1 ?>&category=<?= htmlspecialchars($current) ?>">次へ</a>
            <?php endif; ?>
        </div>
    </div>

    <footer id="page_footer">
        <div id="page_footer_info_box">
            <div class="page_footer_info">
                <p class="main-logo"><a href="../header.php">鳥沢温泉</a></p>
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
                        <li><a href="">よくある質問</a></li>
                        <li><a href="../contact/contact.html">お問い合わせ</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </footer>

<script src="../app.js"></script>
</body>
</html>