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
    <title>鳥沢温泉 | 予約確認</title>
</head>

<body>
    <div>
        <p>大人：<?= htmlspecialchars($adult, ENT_QUOTES, 'UTF-8') ?></p>
        <p>子ども：<?= htmlspecialchars($children, ENT_QUOTES, 'UTF-8') ?></p>
        <p>チェックイン：<?= htmlspecialchars($checkin, ENT_QUOTES, 'UTF-8') ?></p>
        <p>チェックアウト：<?= htmlspecialchars($checkout, ENT_QUOTES, 'UTF-8') ?></p>
        <p>プラン：<?= htmlspecialchars($plan_names[$plan], ENT_QUOTES, 'UTF-8') ?></p>
        <p>合計金額：<?= htmlspecialchars(number_format($total_price), ENT_QUOTES, 'UTF-8') ?>円</p>
    </div>

    <form action="confirm.php" method="POST">
        <div>
            <p>お客様情報</p>

            <label for="name">お名前</label>
            <input type="text" name="name" id="name" required>

            <label for="tel">お電話番号</label>
            <input type="tel" name="tel" id="tel" required>

            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" required>

            <label for="zipcode">郵便番号</label>
            <input type="text" name="zipcode" id="zipcode" placeholder="1000001">
            <button type="button" id="searchBtn">住所検索</button>
            <label for="address1">都道府県</label>
            <input type="text" name="address1" id="address1">
            <label for="address2">市区町村</label>
            <input type="text" name="address2" id="address2">
            <label for="address3">番地</label>
            <input type="text" name="address3" id="address3">
            <label for="address4">その他</label>
            <input type="text" name="address4" id="address4">

            <label for="message">ご要望・アレルギーなど</label>
            <textarea name="message" id="message" rows="5" cols="30"></textarea>
        </div>

        <button type="submit">予約を確定する</button>
    </form>

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