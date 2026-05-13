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

//検索
$checkin = $_POST["checkin"];
$checkout = $_POST["checkout"];
$plan = $_POST["plan"];

//在庫
$stocks = [
    "sudomari" => 3,
    "standard" => 3,
    "premium" => 2
];

$stock = $stocks[$plan];

//重複確認


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./reservation.css">
    <title>鳥沢温泉 | 予約</title>
</head>

<body>

    <form action="display.php" method="POST">
        <div class="day_people">
            <label for="checkin">チェックイン</label>
            <input type="date" name="checkin" id="checkin" required>

            <label for="checkout">チェックアウト</label>
            <input type="date" name="checkout" id="checkout" required>
        </div>

        <div class="people">
            <label for="adult">大人</label>
            <select name="adult" id="adult">
                <option value="1">1名</option>
                <option value="2">2名</option>
                <option value="3">3名</option>
                <option value="4">4名</option>
                <option value="5">5名</option>
            </select>

            <label for="children">子ども</label>
            <select name="children" id="children">
                <option value="0">0名</option>
                <option value="1">1名</option>
                <option value="2">2名</option>
                <option value="3">3名</option>
                <option value="4">4名</option>
                <option value="5">5名</option>
            </select>
        </div>

        <div class="plan">
            <label class="plan_card">
                <input type="radio" name="plan" value="sudomari" checked>
                <div>
                    <p>素泊まりプラン</p>
                    <p>夕食・朝食なし ￥6,000~/人</p>
                </div>
            </label>
            <label class="plan_card">
                <input type="radio" name="plan" value="standard">
                <div>
                    <p>スタンダードプラン</p>
                    <p>夕食・朝食付き ￥18,000~/人</p>
                </div>
            </label>
            <label class="plan_card">
                <input type="radio" name="plan" value="premium">
                <div>
                    <p>プレミアムプラン</p>
                    <p>個室料理・個室露天風呂付き ￥32,000~/人</p>
                </div>
            </label>

            <div class="total">
                <p>合計金額</p>
                <p id="total_price">￥0</p>
            </div>
            <input type="hidden" name="total_price" id="hidden_total_price">
        </div>


        <label for="name">お名前</label>
        <input type="text" name="name" id="name" required>
        <label for="tel">お電話番号</label>
        <input type="tel" name="tel" id="tel" required>
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email" required>
        <label for="message">ご要望・アレルギーなど</label>
        <textarea name="message" id="message" cols="50" rows="20"></textarea>

        <button type="submit" name="submit">予約内容を確認</button>
    </form>
</body>

<script>
    //カレンダー設定
    const checkin = document.getElementById("checkin");
    const checkout = document.getElementById("checkout");
    let night = 0;

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
    });


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

    function updateTotal() {
        const plan = document.querySelector('input[name="plan"]:checked');
        const adult = parseInt(document.getElementById("adult").value);
        const children = parseInt(document.getElementById("children").value);
        const total = (prices[plan.value].adult * adult + prices[plan.value].children * children) * night;
        document.getElementById("total_price").textContent = "￥" + total.toLocaleString();
        document.getElementById("hidden_total_price").value = total;
    }
    document.querySelectorAll('input[name="plan"]').forEach(radio => {
        radio.addEventListener("change", updateTotal);
    });
    document.getElementById("adult").addEventListener("change", updateTotal);
    document.getElementById("children").addEventListener("change", updateTotal);

    updateTotal();
</script>