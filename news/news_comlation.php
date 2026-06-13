<?php
session_start();

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

    <link rel="stylesheet" href="./news_detail.css">
    <link rel="stylesheet" href="./news_form.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./news_list2.css">
    <link rel="stylesheet" href="./news_comlation.css">
    <link rel="stylesheet" href="../css/page_footer.css">
</head>

<body>

    <?php if (isset($_SESSION["user_id"])): ?>
        <div class="admin_header">
            <p>鳥沢温泉/管理画面</p>
            <nav>
                <ul>
                    <li><a href="./news_list.php">ニュースリストへ</a></li>
                    <li><a href="/温泉/users/logout.php">ログアウト</a></li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>

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

        <div id="header-vew" class="<?= isset($_SESSION["user_id"]) ? "admin" : "" ?>">
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

    <h2>投稿が完了しました</h2>

    <a href="./news_list.php">ニュースリストへ</a>


</body>