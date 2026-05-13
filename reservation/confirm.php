<?php
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=reservation',
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    echo $e->getMessage();
    exit("DB接続エラー");
}

$name = $_POST["name"];
$tel = $_POST["tel"];
$email = $_POST["email"];
$message = $_POST["message"];
$checkin = $_POST["checkin"];
$checkout = $_POST["checkout"];
$adult = $_POST["adult"];
$children = $_POST["children"];
$plan = $_POST["plan"];

$sql = "INSERT INTO reservation(`name`, `tel`, `email`, `message`, `checkin`, `checkout`, `adult`, `children`, `plan`) VALUES(:name, :tel, :email, :message, :checkin, :checkout, :adult, :children, :plan)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ":name" => $name,
    ":tel" => $tel,
    ":email" => $email,
    ":message" => $message,
    ":checkin" => $checkin,
    ":checkout" => $checkout,
    ":adult" => $adult,
    ":children" => $children,
    ":plan" => $plan
]);

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
        <p>プラン：<?= htmlspecialchars($plan, ENT_QUOTES, 'UTF-8') ?></p>
    </div>
</body>
</html>