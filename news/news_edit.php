<?php
session_start();
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



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // =====================
    // 更新処理（POST）
    // =====================
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    if ($id === false || $id === null || $id <= 0 || $id >= 1000) {
        exit("不正なidです");
    }

    $title = $_POST["title"];
    $comment = $_POST["comment"];
    $category = $_POST["category"];

    if (!empty($_FILES["img"]["name"])) {
        $image_name = time() . "_" . $_FILES["img"]["name"];
        $tmp_path = $_FILES["img"]["tmp_name"];
        move_uploaded_file($tmp_path, "../upload/" . $image_name);
    } else {
        $image_name = $_POST["old_image"];
    }

    $stmt = $pdo->prepare("UPDATE onsen_hotel_site_table SET title=?, comment=?, image_name=?, category=? WHERE id=?");
    $stmt->execute([$title, $comment, $image_name, $category, $id,]);

    header("LOCATION: news_list.php");
    exit;
} else {

    // =====================
    // 初回表示（GET）
    // =====================
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    if (!$id) {
        exit("不正なidです");
    }

    $stmt = $pdo->prepare("SELECT * FROM onsen_hotel_site_table WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $news = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$news) {
        exit("データがありません");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>鳥沢温泉 | ニュース</title>

    <link rel="stylesheet" href="./news_detail.css">
    <link rel="stylesheet" href="./news_form.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./news_list2.css">
    <link rel="stylesheet" href="../css/page_footer.css">

</head>

<body>

    <?php if (isset($_SESSION["user_id"])): ?>
        <div class="admin_header">
            <p>鳥沢温泉/管理画面</p>
            <nav>
                <ul>
                    <li><a href="./news_list.php">ニュースリストへ</a></li>
                    <li><a href="/onsen/admin/logout.php">ログアウト</a></li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>

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

        <div id="header-vew" class="<?= isset($_SESSION["user_id"]) ? "admin" : "" ?>">
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




    <form action="news_edit.php" method="POST" enctype="multipart/form-data">
        <div class="con_news">
            <main class="main_news">

                <select class="pag_category" name="category" id="category">
                    <option value="" disabled <?= empty($news["category"]) ? "selected" : "" ?>>カテゴリー</option>
                    <option value="all" <?= ($news["category"] ?? "") === "all" ? "selected" : "" ?>>すべて</option>
                    <option value="info" <?= ($news["category"] ?? "") === "info" ? "selected" : "" ?>>お知らせ</option>
                    <option value="event" <?= ($news["category"] ?? "") === "event" ? "selected" : "" ?>>イベント</option>
                    <option value="facility" <?= ($news["category"] ?? "") === "event" ? "selected" : "" ?>>施設情報</option>
                    <option value="campaign" <?= ($news["category"] ?? "") === "category" ? "selected" : "" ?>>キャンペーン</option>
                </select>

                <input type="hidden" name="id" value="<?= $news["id"] ?>">

                <input class="news_title" id="title" name="title" value="<?= $news["title"] ?>">

                <div class="img_box">
                    <input type="hidden" name="old_image" value="<?= $news["image_name"] ?>">
                    <img id="preview" class="news_box_img" src="../upload/<?= htmlspecialchars($news["image_name"] ?? "") ?>">
                    <input type="file" name="img" id="img">
                </div>

                <textarea name="comment" class="message" id="text"><?= $news["comment"] ?></textarea>

                <button class="post_btn" type="submit">更新する</button>
            </main>
        </div>
    </form>

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
                        <li><a href="../index.php">ホーム</a></li>
                        <li><a href="../index.php#spa">温泉</a></li>
                        <li><a href="../index.php#room">お部屋</a></li>
                        <li><a href="../index.php#dish">お食事</a></li>
                        <li><a href="../index.php#footer">交通案内</a></li>
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



</body>

<script src="../app.js"></script>
<script>
    document.getElementById("img").addEventListener("change", function(event) { //#imgを取得→チェンジイベント起こるたびに登録した処理{}を実行
        const file = event.target.files[0]; //inputのfileプロパティ(type=file)の1番目を取り出す

        if (file) { //ファイルが選択されていれば
            const reader = new FileReader(); //読み込み準備

            reader.onload = function(e) { //読み込みが完了したときに実行
                document.getElementById("preview").src = e.target.result; //読み込んだ画像データをpreviewのsrcに設定
            }

            reader.readAsDataURL(file); //表示できる形式に変換(DataURL形式（base64）)
        }
    });

    const textArea = document.getElementById("text");

    function aoutHeight() {
        textArea.style.height = "auto";
        textArea.style.height = textArea.scrollHeight + "px";
    }
    textArea.addEventListener("input", aoutHeight);
    aoutHeight();
</script>

</html>