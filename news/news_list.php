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
$category = [
    "all" => "すべて",
    "news" => "お知らせ",
    "event" => "イベント",
    "facility" => "施設情報",
    "campaign" => "キャンペーン"
];

$current = $_GET["category"] ?? "all";
if (!array_key_exists($current, $category)) {
    $current =  "all";
}

if ($current === "all") {
    $where = "";
} else {
    $where = "where category  = " . $pdo->quote($current);
}

$limit = 3;

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
    SELECT id, image_name, comment, created_at, title
    FROM onsen_hotel_site_table
    $where
    ORDER BY created_at DESC
    LIMIT $limit OFFSET $offset 
";
// LIMIT $limit OFFSET $offset  OFFSET数飛ばして 次のLIMIT数取得する

$news_array = $pdo->query($sql); //sql は温泉のデータベース　$news_arrayを変数名にして、下で配列を取り出すようにする。


//$news_list = getNews($pdo, $current);
//function GetNews(PDO $pdo, string $category = "all"): array
//{
//    if ($category === "all") {
//        $stmt = $pdo->prepare("SELECT * FROM onsen_hotel_site_table ORDER BY created_at DESC");
//        $stmt->execute();
//    } else {
//        $stmt = $pdo->prepare("SELECT * FROM onsen_hotel_site_table WHERE category = ? ORDER BY created_at DESC");
//        $stmt->execute([$category]);
//    }
//    return $stmt->fetchAll(PDO::FETCH_ASSOC);
//}



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
    <link rel="stylesheet" href="./news_list2.css">
</head>

<body>

    <a href="../header.php">鳥沢温泉</a>
    <a href="./news_form.php">ニュースフォーム</a>
    <a href="/温泉/users/user_ registration.php">ユーザー登録</a>
    <a href="/温泉/users/login.php">ログイン</a>
    <a href="/温泉/users/logout.php">ログアウト</a>


    <div class="news_list">
        <div class="fresh_news">
            <div class="news">
                <ul class="news_box">
                    <?php foreach ($news_array as $news) : ?>

                        <div class="news_line">
                            <li><a class="news_pieces" href="news_detail.php?id=<?= $news["id"] ?>">
                                    <?php if (!empty($news["image_name"])): ?>
                                        <div class="news_box_img"><img src="../upload/<?= $news["image_name"] ?>" alt="">
                                        </div>
                                    <?php endif ?>
                                    <div class="news_box_text">
                                        <time class="created_at"><?= $news["created_at"]; ?></time>
                                        <p class="title"><?= htmlspecialchars($news["title"], ENT_QUOTES) ?></p>
                                    </div>
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

            <!--ページネーション-->
            <div class="pagenation">

                <!--前へ-->
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>&category=<?= htmlspecialchars($current) ?>">前へ</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <?php if ($i == $page) : ?>
                        <strong><?= $i ?></strong>
                    <?php else : ?>
                        <a href="?page=<?= $i ?>&category=<?= htmlspecialchars($current) ?>"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <!--次へ-->
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?= $page + 1 ?>&category=<?= htmlspecialchars($current) ?>">次へ</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="category">
            <?php foreach ($category as $key => $label): ?>
                <a href="?category=<?= htmlspecialchars($key) ?>"
                    class="<?= $current === $key ? 'active' : '' ?>">
                    <?= htmlspecialchars($label) ?>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</body>

</html>