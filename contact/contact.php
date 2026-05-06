<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "src/Exception.php";
require "src/PHPMailer.php";
require "src/SMTP.php";

$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

$mail = new PHPMailer(true);

tyr{
        // サーバの設定
    $mail->isSMTP();                                            // SMTPを使用
    $mail->Host       = 'smtp.gmail.com';                       // SMTPサーバを設定
    $mail->SMTPAuth   = true;                                   // SMTP認証を有効に
    $mail->Username   = 'pokemonn0724@gmail.com';                 // Gmailアカウント
    $mail->Password   = 'apgb kshu nihh wdmm';                  // Gmailパスワード
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // 暗号化を有効に（TLS）
    $mail->Port       = 587;                                    // TCPポートを設定
    $mail->CharSet    = 'UTF-8';

    // 受信者情報
    $mail->setFrom('pokemonn0724@gmail.com');
    $mail->addAddress('pokemonn0724@gmail.com');   // 受信者を追加

    $mail->Subject = "お問い合わせが届きました";
    $mail->Body = "お名前: {$name}\nメール: {$email}\n\n{$message}";

    $mail->send();
    echo "メールを送信しました";

}

?>