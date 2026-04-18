<?php
session_start();
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

$limit = 3;

$total_news = $pdo->query("SELECT COUNT(*) FROM onsen_hotel_site_table")->fetchColumn();
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
    <link rel="stylesheet" href="./news_ver1.css">
</head>

<body>

    <a href="html/index.html">鳥沢温泉</a>
    <a href="./news_form.php">ニュースホーム</a>
    <a href="./user_ registration.php">ユーザー登録</a>
    <a href="./login.php">ログイン</a>
    <a href="./logout.php">ログアウト</a>


    <main>
        <div class="news">
            <ul class="news_box">
                <?php foreach ($news_array as $news) : ?>

                    <li><a href="news_detail.php?id=<?= $news["id"] ?>">
                            <?php if (!empty($news["image_name"])): ?>
                                <div class="news_box_img"><img src="upload/<?= $news["image_name"] ?>" alt="">
                                </div>
                            <?php endif ?>
                            <div class="news_box_text">
                                <time class="created_at"><?= $news["created_at"]; ?></time>
                                <p class="title"><?= htmlspecialchars($news["title"], ENT_QUOTES) ?></p>
                            </div>
                        </a>
                        <?php if (isset($_SESSION["user_id"])): ?>
                            <a href="news_edit.php?id=<?=$news["id"] ?>">編集</a>
                            <a href="news_delete.php?id=<?= $news["id"] ?>">削除</a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!--ページネーション-->
        <div class="pagenation">

            <!--前へ-->
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">前へ</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <?php if ($i == $page) : ?>
                    <strong><?= $i ?></strong>
                <?php else : ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <!--次へ-->
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>">次へ</a>
            <?php endif; ?>
        </div>
    </main>

</body>

</html>