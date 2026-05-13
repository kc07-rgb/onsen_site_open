<?php
$name = $_POST["name"];
$tel = $_POST["tel"];
$email = $_POST["email"];
$message = $_POST["message"];
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
        <p>お名前：<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></p>
        <p>お電話：<?= htmlspecialchars($tel, ENT_QUOTES, 'UTF-8') ?></p>
        <p>メールアドレス：<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></p>
        <p>ご要望・アレルギーなど：<?= nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) ?></p>
        <p>大人：<?= htmlspecialchars($adult, ENT_QUOTES, 'UTF-8') ?></p>
        <p>子ども：<?= htmlspecialchars($children, ENT_QUOTES, 'UTF-8') ?></p>
        <p>チェックイン：<?= htmlspecialchars($checkin, ENT_QUOTES, 'UTF-8') ?></p>
        <p>チェックアウト：<?= htmlspecialchars($checkout, ENT_QUOTES, 'UTF-8') ?></p>
        <p>プラン：<?= htmlspecialchars($plan_names[$plan], ENT_QUOTES, 'UTF-8') ?></p>
        <p>合計金額：<?= htmlspecialchars(number_format($total_price), ENT_QUOTES, 'UTF-8') ?>円</p>
    </div>

    <form action="confirm.php" method="POST">
        <input type="hidden" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="tel" value="<?= htmlspecialchars($tel, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="message" value="<?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="adult" value="<?= htmlspecialchars($adult, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="children" value="<?= htmlspecialchars($children, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="checkin" value="<?= htmlspecialchars($checkin, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="checkout" value="<?= htmlspecialchars($checkout, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="plan" value="<?= htmlspecialchars($plan_names[$plan], ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="total_price" value="<?= htmlspecialchars(number_format($total_price), ENT_QUOTES, 'UTF-8') ?>">

        <button type="submit">予約を確定する</button>
    </form>
</body>
</html>