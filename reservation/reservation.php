<?php
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=onsen_hotel_site',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    exit("DB接続エラー");
}
$remaining = null;
$error = "";
$availablePlans = [];

//検索
$checkin = $_GET["checkin"] ?? "";
$checkout = $_GET["checkout"] ?? "";
$plan = $_GET["plan"] ?? "sudomari";


//在庫
$stocks = [
    "sudomari" => 3,
    "standard" => 3,
    "premium" => 2
];

//人数
$adult = (int)($_GET["adult"] ?? 1);
$children = (int)($_GET["children"] ?? 0);
$totalPeople = $adult + $children;
$capacity = [
    "sudomari" => 5,
    "standard" => 5,
    "premium" => 4
];

foreach ($stocks as $planName => $stock) {
    //人数制限
    $maxPeople = $capacity[$planName];

    if ($totalPeople > $maxPeople) {
        continue;
    }

    //重複確認
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM reservation WHERE plan = ? AND checkin < ? AND checkout > ?");
    $stmt->execute([
        $planName,
        $checkout,
        $checkin
    ]);


    $reserved = $stmt->fetchColumn();

    //残客室数
    $remaining =  $stock - $reserved;

    if ($remaining > 0) {
        $availablePlans[] = [
            "plan" => $planName,
            "remaining" => $remaining
        ];
    }
}

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

    <link rel="stylesheet" href="./reservation.css">
    <link rel="stylesheet" href="../css/page_header.css">
    <link rel="stylesheet" href="../css/page_footer.css">
    <title>鳥沢温泉 | 予約</title>
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

    <form method="GET">
        <div class="day_people">
            <label for="checkin">チェックイン</label>
            <input type="date" name="checkin" id="checkin" value="<?= htmlspecialchars($_GET["checkin"] ?? "",  ENT_QUOTES, "UTF-8") ?>" required>

            <label for="checkout">チェックアウト</label>
            <input type="date" name="checkout" id="checkout" value="<?= htmlspecialchars($_GET["checkout"] ?? "", ENT_QUOTES, "UTF-8") ?>" required>
        </div>

        <div class="people">
            <label for="adult">大人</label>
            <select name="adult" id="adult">
                <option value="1" <?= (($_GET["adult"] ?? "") == 1) ? "selected" : "" ?>>1名</option>
                <option value="2" <?= (($_GET["adult"] ?? "") == 2) ? "selected" : "" ?>>2名</option>
                <option value="3" <?= (($_GET["adult"] ?? "") == 3) ? "selected" : "" ?>>3名</option>
                <option value="4" <?= (($_GET["adult"] ?? "") == 4) ? "selected" : "" ?>>4名</option>
                <option value="5" <?= (($_GET["adult"] ?? "") == 5) ? "selected" : "" ?>>5名</option>
            </select>

            <label for="children">子ども</label>
            <select name="children" id="children">
                <option value="0" <?= (($_GET["children"] ?? "") == 0) ? "selected" : "" ?>>0名</option>
                <option value="1" <?= (($_GET["children"] ?? "") == 1) ? "selected" : "" ?>>1名</option>
                <option value="2" <?= (($_GET["children"] ?? "") == 2) ? "selected" : "" ?>>2名</option>
                <option value="3" <?= (($_GET["children"] ?? "") == 3) ? "selected" : "" ?>>3名</option>
                <option value="4" <?= (($_GET["children"] ?? "") == 4) ? "selected" : "" ?>>4名</option>
                <option value="5" <?= (($_GET["children"] ?? "") == 5) ? "selected" : "" ?>>5名</option>
            </select>
        </div>

        <button type="submit" name="submit">空室確認</button>
    </form>

    <div class="plan">
        <?php foreach ($availablePlans as $room): ?>
            <?php if ($room["plan"] == "sudomari"): ?>
                <div class="plan_type">
                    <form action="display.php" method="POST">
                        <div>
                            <p>素泊まりプラン</p>
                            <p>夕食・朝食なし ￥6,000~/人</p>

                            <?php if (isset($_GET["submit"])): ?>
                                <div class="available">
                                    <p>空室あり:残り<?= htmlspecialchars($room["remaining"],  ENT_QUOTES, "UTF-8") ?>室</p>
                                    <div class="total">
                                        <p>合計金額</p>
                                        <p class="total_price" data-plan="sudomari">￥<?= number_format((int)($_GET["total_price"] ?? 0)) ?></p>
                                    </div>

                                </div>
                            <?php endif ?>
                        </div>

                        <input type="hidden" name="plan" value="sudomari">
                        <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin, ENT_QUOTES, "UTF-8") ?>">
                        <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout, ENT_QUOTES, "UTF-8") ?>">
                        <input type="hidden" name="adult" value="<?= htmlspecialchars($adult, ENT_QUOTES, "UTF-8") ?>">
                        <input type="hidden" name="children" value="<?= htmlspecialchars($children, ENT_QUOTES, "UTF-8") ?>">
                        <input type="hidden" name="total_price" class="hidden_total_price" data-plan="sudomari">

                        <button class="plan_card" type="submit" name="plan" value="sudomari">予約する</button>
                    </form>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>



    <?php foreach ($availablePlans as $room): ?>
        <?php if ($room["plan"] == "standard"): ?>
            <div class="plan_type">
                <form action="display.php" method="POST">
                    <div>
                        <p>スタンダードプラン</p>
                        <p>夕食・朝食付き ￥18,000~/人</p>

                        <?php if (isset($_GET["submit"])): ?>
                            <div class="available">
                                <p>空室あり:残り<?= htmlspecialchars($room["remaining"],  ENT_QUOTES, "UTF-8") ?>室</p>
                                <div class="total">
                                    <p>合計金額</p>
                                    <p class="total_price" data-plan="standard">￥<?= number_format((int)($_GET["total_price"] ?? 0)) ?></p>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>

                    <input type="hidden" name="plan" value="standard">
                    <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin, ENT_QUOTES, "UTF-8") ?>">
                    <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout, ENT_QUOTES, "UTF-8") ?>">
                    <input type="hidden" name="adult" value="<?= htmlspecialchars($adult, ENT_QUOTES, "UTF-8") ?>">
                    <input type="hidden" name="children" value="<?= htmlspecialchars($children, ENT_QUOTES, "UTF-8") ?>">
                    <input type="hidden" name="total_price" class="hidden_total_price" data-plan="standard">

                    <button class="plan_card" type="submit" name="plan" value="standard">予約する</button>
                </form>
            </div>
        <?php endif ?>
    <?php endforeach ?>

    <?php foreach ($availablePlans as $room): ?>
        <?php if ($room["plan"] == "premium"): ?>
            <div class="plan_type">
                <form action="display.php" method="POST">
                    <div>
                        <p>プレミアムプラン</p>
                        <p>個室料理・個室露天風呂付き ￥32,000~/人</p>

                        <?php if (isset($_GET["submit"])): ?>
                            <div class="available">
                                <p>空室あり:残り<?= htmlspecialchars($room["remaining"],  ENT_QUOTES, "UTF-8") ?>室</p>
                                <div class="total">
                                    <p>合計金額</p>
                                    <p class="total_price" data-plan="premium">￥<?= number_format((int)($_GET["total_price"] ?? 0)) ?></p>
                                </div>
                            </div>
                        <?php endif ?>

                        <input type="hidden" name="plan" value="premium">
                        <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin, ENT_QUOTES, "UTF-8") ?>">
                        <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout, ENT_QUOTES, "UTF-8") ?>">
                        <input type="hidden" name="adult" value="<?= htmlspecialchars($adult, ENT_QUOTES, "UTF-8") ?>">
                        <input type="hidden" name="children" value="<?= htmlspecialchars($children, ENT_QUOTES, "UTF-8") ?>">
                        <input type="hidden" name="total_price" class="hidden_total_price" data-plan="premium">

                        <button class="plan_card" type="submit" name="plan" value="premium">予約する</button>
                    </div>
                </form>
            </div>
        <?php endif ?>
    <?php endforeach ?>

    <footer id="page_footer">
        <div id="page_footer_info">
            <div class="page_footer_info">
                <p class="main-logo">鳥沢温泉</p>
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
                        <li><a href="">お問い合わせ</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </footer>

</body>


<script>
    //プラン表示    
    document.querySelectorAll('input[name="plan"]').forEach(radio => {
        radio.addEventListener("change", () => {
            const plan = document.querySelector('input[name="plan"]:checked');
            console.log(plan.value);
        })
    });

    //合計金額表示
    const prices = {
        sudomari: {
            adult: 6000,
            children: 3000
        },
        standard: {
            adult: 10000,
            children: 7000
        },
        premium: {
            adult: 20000,
            children: 15000
        },
    };

    //カレンダー設定
    const checkin = document.getElementById("checkin");
    const checkout = document.getElementById("checkout");
    let night = 0;
    if (checkin.value && checkout.value) {

        const cin = new Date(checkin.value);
        const cout = new Date(checkout.value);

        night = Math.floor((cout - cin) / 86400000);
    }

    //Dateオブジェクトを使う
    const date = new Date();

    //時間を深夜0時に揃える
    date.setHours(0, 0, 0, 0);

    //Dateオブジェクトの時間を使用しない
    const dateStr = date.toISOString().split("T")[0];

    //チェックインとチェックアウトの最小日数を今日にする
    checkin.min = dateStr;
    checkout.min = dateStr;


    //チェックアウトの最小値をチェックインの翌日にする
    checkin.addEventListener("change", () => {
        //チェックアウトの値を空にする
        checkout.value = "";

        //チェックインに値が入っている場合のオブジェクトを定義(cinDate)
        const cinDate = new Date(checkin.value);

        //cinDateをコピー(next)
        const next = new Date(cinDate);

        //nextの日付を取得した日付に1足す
        next.setDate(next.getDate() + 1);

        //チェックアウトの最小日を定義
        checkout.min = next.toISOString().split("T")[0];

    });

    //金額計算
    function updateTotal() {
        if (night <= 0) {
            document.querySelectorAll(".total_price").forEach(price => {
                price.textContent = "￥0";
            });
            return;
        }

        const adult = parseInt(document.getElementById("adult").value);
        const children = parseInt(document.getElementById("children").value);

        document.querySelectorAll(".total_price").forEach(priceElement => {
            const plan = priceElement.dataset.plan;

            const total = (prices[plan].adult * adult + prices[plan].children * children) * night;

            priceElement.textContent = "￥" + total.toLocaleString();

            const hiddenInput = document.querySelector(
                `.hidden_total_price[data-plan="${plan}"]`
            );

            hiddenInput.value = total;
        });
    }

    //日数
    checkout.addEventListener("change", () => {
        const cin = new Date(checkin.value);
        const cout = new Date(checkout.value);
        night = Math.round((cout - cin) / 86400000); //Dateを引き算するとミリ秒で求められる 1日の86400000秒で割ることで何日になるか計算。 Matheは計算のために使うオブジェクト。

        if (night < 1) {
            console.log("日付が正しくありません");
        } else if (night > 30) {
            console.log("最大宿泊可能日数を超えています");
        } else {
            console.log(night);
        }
        if (checkin.value && checkout.value) {

            const cin = new Date(checkin.value);
            const cout = new Date(checkout.value);

            night = Math.floor((cout - cin) / 86400000);
        }

        updateTotal();
    })

    document.getElementById("adult").addEventListener("change", updateTotal);
    document.getElementById("children").addEventListener("change", updateTotal);
    updateTotal();
</script>

</html>