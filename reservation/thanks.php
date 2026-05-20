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
    <title>鳥沢温泉 | 予約完了</title>
</head>

<body>
    <h1>予約が完了しました。</h1>
    <p><?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?>様</p>
    <p>ご予約内容は下記です。</p>
    <div>
        <p>プラン:<?= htmlspecialchars($plan_names[$plan], ENT_QUOTES, "UTF-8") ?></p>
        <p>大人:<?= (int)$adult ?>名</p>
        <p>こども:<?= (int)$children ?>名</p>
        <p>チェックイン:<?= $checkin ?></p>
        <p>チェックアウト:<?= $checkout ?></p>
        <p>ご要望・アレルギーなど：<?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?></p>
        <p>料金：<?= number_format((int)$total_price) ?>円</p>

        <p>お客様情報</p>
        <p>お名前:<?= htmlspecialchars($name, ENT_QUOTES, "UTF-8") ?></p>
        <p>お電話番号:<?= htmlspecialchars($tel, ENT_QUOTES, "UTF-8") ?></p>
        <p>メールアドレス:<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?></p>
        <p>住所:<?= htmlspecialchars("〒" . $zipcode, ENT_QUOTES, "UTF-8") ?><br>
            <?= htmlspecialchars($address1 . $address2 . $address3 . $address4, ENT_QUOTES, "UTF-8") ?></p>
    </div>

    <a href="/温泉/header.php">ホームへ戻る</a>

</body>

</html>