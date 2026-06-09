<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/page_header.css">
    <link rel="stylesheet" href="../news/news_list2.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./contact.css">
    <link rel="stylesheet" href="../css/page_footer.css">
    <link rel="stylesheet" href="./contact_thanks.css">
</head>

<body>
    <!--header-->
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

        <div id="page">
            <div class="page_tatile">
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


    <section class="thanks">
        <h2>お問い合わせありがとうございました</h2>
        <p>
            このたびは当館へお問い合わせいただき、誠にありがとうございます。<br>
            ご入力いただいたメールアドレス宛に受付確認メールを送信いたしました。<br>
            内容を確認のうえ、担当者よりご連絡させていただきますので、今しばらくお待ちください。
        </p>
        <a href="../header.php">トップページへ戻る</a>
    </section>

    <div id="footer-intro">
    </div>


    <footer id="footer">

        <div id="footer_info">
            <div class="footer_info">
                <p class="main-logo"><a href="../header.php">鳥沢温泉</a></p>
                <address>
                    <p>〒×××-×××× 岩手県小鳥市11-111</p>
                    <p>tel.0000-00-0000/9:00~18:00</p>
                </address>
            </div>

            <nav id="nav">
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