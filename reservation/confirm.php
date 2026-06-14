<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: display.php");
    exit;
}

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=konsent_onsen',
        "konsent_onsen",
        "Tika0724",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    echo $e->getMessage();
    exit("DB接続エラー");
}

$_SESSION["reservation"] = [
"name" => $_POST["name"] ?? "",
"tel" => $_POST["tel"] ?? "",
"email" => $_POST["email"] ?? "",
"message" => $_POST["message"] ?? "",
"checkin" => $_POST["checkin"] ?? "",
"checkout" => $_POST["checkout"] ?? "",
"adult" => $_POST["adult"] ?? "",
"children" => $_POST["children"] ?? "",
"plan" => $_POST["plan"] ?? "",
"total_price" => $_POST["total_price"] ?? "",
"zipcode" => $_POST["zipcode"] ?? "",
"address1" => $_POST["address1"] ?? "",
"address2" => $_POST["address2"] ?? "",
"address3" => $_POST["address3"] ?? "",
"address4" => $_POST["address4"] ?? "",
];

$name = $_SESSION["reservation"]["name"];
$tel = $_SESSION["reservation"]["tel"];
$email = $_SESSION["reservation"]["email"];
$message = $_SESSION["reservation"]["message"];
$checkin = $_SESSION["reservation"]["checkin"];
$checkout = $_SESSION["reservation"]["checkout"];
$adult = $_SESSION["reservation"]["adult"];
$children = $_SESSION["reservation"]["children"];
$plan = $_SESSION["reservation"]["plan"];
$total_price = $_SESSION["reservation"]["total_price"];
$zipcode = $_SESSION["reservation"]["zipcode"];
$address1 = $_SESSION["reservation"]["address1"];
$address2 = $_SESSION["reservation"]["address2"];
$address3 = $_SESSION["reservation"]["address3"];
$address4 = $_SESSION["reservation"]["address4"];

$plan_names = [
    "sudomari" => "素泊まりプラン",
    "standard" => "スタンダードプラン",
    "premium" => "プレミアムプラン"
];

$sql = "INSERT INTO reservation(`name`, `tel`, `email`, `message`, `checkin`, `checkout`, `adult`, `children`, `plan`, `total_price`, `zipcode`, `address1`,`address2`, `address3`, `address4`) VALUES(:name, :tel, :email, :message, :checkin, :checkout, :adult, :children, :plan, :total_price, :zipcode, :address1, :address2, :address3, :address4)";
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
    ":zipcode" => $zipcode,
    ":address1" => $address1,
    ":address2" => $address2,
    ":address3" => $address3,
    ":address4" => $address4
]);

//mail送信
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../mailer/src/Exception.php';
require __DIR__ . '/../mailer/src/PHPMailer.php';
require __DIR__ . '/../mailer/src/SMTP.php';

try {
    //自動返信メール
    $mail2 = new PHPMailer(true);
    $mail2->isSMTP();
    $mail2->Host       = 'smtp.gmail.com';
    $mail2->SMTPAuth   = true;
    $mail2->Username   = 'pokemonn0724@gmail.com';
    $mail2->Password   = 'apgb kshu nihh wdmm';
    $mail2->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail2->Port       = 587;
    $mail2->CharSet    = 'UTF-8';
    $mail2->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ]
    ];

    $mail2->setFrom('pokemonn0724@gmail.com');
    $mail2->addAddress($email);
    $mail2->Subject = 'ご予約が確定しました。';
    $mail2->Body    = "{$name} 様\n\nご予約ありがとうございます。\n" .
        "ご予約内容は以下の通りとなります。\n" .
        "チェックイン{$checkin}\n" .
        "チェックアウト{$checkout}\n" .
        "宿泊者代表様名{$name}様\n" .
        "お電話番号{$tel}\n" .
        "宿泊者人数" . (($adult + $children)) . "(大人{$adult}人 こども{$children}人)\n" .
        "プラン{$plan_names[$plan]}\n" .
        "要望・アレルギーなど{$message}\n" .
        "合計金額{$total_price}\n" .

        "お気をつけてお越しくださいませ。";
    $mail2->send();
    echo "メールを送信しました";
} catch (Exception $e) {
    error_log($e->getMessage());
}

header("Location: thanks.php");
exit;
