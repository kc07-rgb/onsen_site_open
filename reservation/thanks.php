<?php
session_start();

$data = $_SESSION["reservation"] ?? null;

if (!$data) {
    header("Location: display.php");
    exit;
}

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

$name = $data["name"] ?? "";
$tel = $data["tel"] ?? "";
$email = $data["email"] ?? "";
$message = $data["message"] ?? "";
$checkin = $data["checkin"] ?? "";
$checkout = $data["checkout"] ?? "";
$adult = $data["adult"] ?? "";
$children = $data["children"] ?? "";
$plan = $data["plan"] ?? "";
$total_price = $data["total_price"] ?? "";
$zipcode = $data["zipcode"] ?? "";
$address1 = $data["address1"] ?? "";
$address2 = $data["address2"] ?? "";
$address3 = $data["address3"] ?? "";
$address4 = $data["address4"] ?? "";

$plan_names = [
    "sudomari" => "素泊まりプラン",
    "standard" => "スタンダードプラン",
    "premium" => "プレミアムプラン"
];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="../css/page_footer.css">
    <link rel="stylesheet" href="./reservation.css">
    <link rel="stylesheet" href="./display.css">
    <link rel="stylesheet" href="./thanks.css">
    <link rel="stylesheet" href="../style.css">

    <title>鳥沢温泉 | 予約完了</title>
</head>

<body>

    <header id="header">
        <div id="header-top">
            <a href="../header.php" class="header-logo">鳥沢温泉</a>

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
            <a href="../header.php" class="header-vew-logo">鳥沢温泉</a>
            <nav class="header-nav">
                <ul class="header-nav-list">
                    <li><a href="../header.php#spa">温泉</a></li>
                    <li><a href="../header.php#room">お部屋</a></li>
                    <li><a href="../header.php#dish">お食事</a></li>
                    <li><a href="../header.php#footer_info">交通案内</a></li>
                </ul>
            </nav>
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
                <li><a href="../header.php#spa">温泉</a></li>
                <li><a href="../header.php#room">お部屋</a></li>
                <li><a href="../header.php#dish">お食事</a></li>
                <li><a href="../header.php#footer">交通案内</a></li>
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




    <div class="reservation">
        <h2 class="re_ja">ご予約が完了しました。</h2>
        <p class="re_text">この度は、鳥沢温泉をご予約いただき、誠にありがとうございます。<br>
            ご予約内容の確認メールをご登録のメールアドレスへお送りいたしました。</p>
    </div>


    <div class="vertical">
        <div class="vertical_group">
            <p class="vertical_title">ご予約内容</p>
            <div class="contents">
                <div class="contens_pieces">
                    <p class="contens_label">プラン</p>
                    <p><?= htmlspecialchars($plan_names[$plan], ENT_QUOTES, "UTF-8") ?></p>
                </div>
                <div class="contens_pieces">
                    <p class="contens_label">大人</p>
                    <p><?= (int)$adult ?>名</p>
                </div>
                <div class="contens_pieces">
                    <p class="contens_label">こども</p>
                    <p><?= (int)$children ?>名</p>
                </div>
                <div class="contens_pieces">
                    <p class="contens_label">チェックイン</p>
                    <p><?= date("Y年m月d日", strtotime($checkin)) ?></p>
                </div>
                <div class="contens_pieces">
                    <p class="contens_label">チェックアウト</p>
                    <p><?= date("Y年m月d日", strtotime($checkout)) ?></p>
                </div>
                <div class="contens_pieces">
                    <p class="contens_label">料金</p>
                    <p class="contens_price"><?= number_format((int)$total_price) ?>円</p>
                </div>
            </div>
        </div>

        <div class="vertical_group_two">
            <p class="vertical_title">お客様情報</p>
            <div class="contents">
                <div class="contens_pieces">
                    <p class="contens_label">お名前</p>
                    <p><?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?>様</p>
                </div>
                <div class="contens_pieces">
                    <p class="contens_label">お電話番号</p>
                    <p><?= htmlspecialchars($tel, ENT_QUOTES, "UTF-8") ?></p>
                </div>
                <div class="contens_pieces">
                    <p class="contens_label">メールアドレス</p>
                    <p><?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?></p>
                </div>
                <div class="contens_pieces">
                    <p class="contens_label">住所</p>
                    <div class="post_number">
                        <p class="pisces_text"><?= htmlspecialchars("〒" . $zipcode, ENT_QUOTES, "UTF-8") ?></p>
                        <p class="pisces_text"><?= htmlspecialchars($address1 . $address2, ENT_QUOTES, "UTF-8") ?></p>
                        <p class="pisces_text"><?= htmlspecialchars($address3, ENT_QUOTES, "UTF-8") ?></p>
                        <p class="pisces_text"><?= htmlspecialchars($address4, ENT_QUOTES, "UTF-8") ?></p>
                    </div>
                </div>
                <div class="contens_pieces_box">
                    <p class="contens_label">ご要望・アレルギーなど</p>
                    <p class="pisces_text"><?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?></p>
                </div>
            </div>
        </div>
    </div>




    <div class="thanks_message">
        <p>ご予約内容の確認メールをお送りしましたので、必ずご確認ください。<br>
            当日は気を付けてお越しくださいませ。スタッフ一同、心よりお待ちしております。</p>
    </div>

    <a class="vertical_button" href="/温泉/header.php">ホームへ戻る</a>

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
                        <li><a href="../header.php">ホーム</a></li>
                        <li><a href="../header.php#spa">温泉</a></li>
                        <li><a href="../header.php#room">お部屋</a></li>
                        <li><a href="../header.php#dish">お食事</a></li>
                        <li><a href="../header.php#footer">交通案内</a></li>
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