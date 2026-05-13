<?php
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

$name = $_POST["name"];
$tel = $_POST["tel"];
$email = $_POST["email"];
$message = $_POST["message"];
$checkin = $_POST["checkin"];
$checkout = $_POST["checkout"];
$adult = $_POST["adult"];
$children = $_POST["children"];
$plan = $_POST["plan"];
$total_price = $_POST["total_price"];
$sql = "INSERT INTO reservation(`name`, `tel`, `email`, `message`, `checkin`, `checkout`, `adult`, `children`, `plan`, `total_price`) VALUES(:name, :tel, :email, :message, :checkin, :checkout, :adult, :children, :plan, :total_price)";
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
    ":plan" => $plan,
    ":total_price" => $total_price,
]);

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
    <p>ご予約ありがとうございます。</p>
</body>
</html>