<?php
$checkin = $_POST["checkin"];
$checkout = $_POST["checkout"];
$adult = $_POST["adult"];
$children = $_POST["children"];
$total_price = $_POST["total_price"];
$plan = $_POST["plan"];
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


    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./reservation.css">
    <link rel="stylesheet" href="./display.css">
    <link rel="stylesheet" href="../css/page_header.css">
    <link rel="stylesheet" href="../css/page_footer.css">

    <title>鳥沢温泉 | 予約確認</title>
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
        <h2 class="re_ja">ご予約内容の確認・お客様情報の入力</h2>
        <p class="re_text">下記内容をご確認のうえ、必要事項をご入力ください。</p>
    </div>

    <form action="confirm.php" method="POST">
        <div class="vertical">

            <div class="vertical_group">
                <p class="vertical_title">ご予約内容</p>
                <div class="contents">
                    <div class="contens_pieces">
                        <p class="contens_label">大人</p>
                        <p><?= (int)$adult ?>名</p>
                        <input type="hidden" name="adult" value="<?= (int)$adult ?>">
                    </div>
                    <div class="contens_pieces">
                        <p class="contens_label">子ども</p>
                        <p><?= (int)$children ?>名</p>
                        <input type="hidden" name="children" value="<?= (int)$children ?>">
                    </div>
                    <div class="contens_pieces">
                        <p class="contens_label">チェックイン</p>
                        <p><?= date("Y年m月d日", strtotime($checkin)) ?></p>
                        <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin, ENT_COMPAT, "UTF-8") ?>">
                    </div>
                    <div class="contens_pieces">
                        <p class="contens_label">チェックアウト</p>
                        <p><?= date("Y年m月d日", strtotime($checkout)) ?></p>
                        <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout, ENT_COMPAT, "UTF-8") ?>">
                    </div>
                    <div class="contens_pieces">
                        <p class="contens_label">プラン</p>
                        <p><?= htmlspecialchars($plan_names[$plan], ENT_QUOTES, 'UTF-8') ?></p>
                        <input type="hidden" name="plan" value="<?= htmlentities($plan, ENT_QUOTES, "UTF-8") ?>">
                    </div>
                    <div class="contens_pieces">
                        <p class="contens_label">合計金額</p>
                        <p class="contens_price">￥<?= htmlspecialchars(number_format($total_price), ENT_QUOTES, 'UTF-8') ?>円</p>
                        <input type="hidden" name="total_price" value="<?= htmlentities($total_price, ENT_QUOTES, "UTF-8") ?>">
                    </div>
                </div>
            </div>

            <div class="vertical_group_two">
                <p class="vertical_title">お客様情報の入力</p>

                <div class="customer_item">
                    <label for="name">お名前<span class="required">必須</span></label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div class="customer_item">
                    <label for="tel">お電話番号<span class="required">必須</span></label>
                    <input type="tel" name="tel" id="tel" required>
                </div>
                <div class="customer_item">
                    <label for="email">メールアドレス<span class="required">必須</span></label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="customer_item">
                    <label for="zipcode">郵便番号<span class="required">必須</span></label>

                    <div class="zipcode_row">
                        <input type="text" name="zipcode" id="zipcode" placeholder="1000001" require>
                        <button class="zippcoe_button" type="button" id="searchBtn">住所検索</button>
                    </div>
                </div>
                <div class="customer_item">
                    <label for="address1">都道府県<span class="required">必須</span></label>
                    <input type="text" name="address1" id="address1" require>
                </div>
                <div class="customer_item">
                    <label for="address2">市区町村<span class="required">必須</span></label>
                    <input type="text" name="address2" id="address2" require>
                </div>
                <div class="customer_item">
                    <label for="address3">番地<span class="required">必須</span></label>
                    <input type="text" name="address3" id="address3" require>
                </div>
                <div class="customer_item">
                    <label for="address4">その他</label>
                    <input type="text" name="address4" id="address4">
                </div>
                <div class="customer_item">
                    <label for="message">ご要望・アレルギーなど</label>
                    <textarea name="message" id="message" rows="5" cols="30"></textarea>
                </div>
            </div>
        </div>
        <button class="vertical_button" type="submit">予約を確定する</button>
    </form>



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
    <script>
        document.getElementById("searchBtn").addEventListener("click", async () => {
            const zipcode = document.getElementById("zipcode").value;

            const response = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${zipcode}`);


            const data = await response.json();

            if (data.results) {
                const result = data.results[0];

                document.getElementById("address1").value =
                    result.address1;
                document.getElementById("address2").value =
                    result.address2 + result.address3;
            }
        });
    </script>
</body>

</html>