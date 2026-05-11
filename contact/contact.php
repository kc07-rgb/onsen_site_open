<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "src/Exception.php";
require "src/PHPMailer.php";
require "src/SMTP.php";

$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

$mail = new PHPMailer(true);

try {
    // サーバの設定
    $mail->isSMTP();                                            // SMTPを使用
    //サーバーにアップ時は下記は削除 
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ]
    ];
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
    $mail2->Subject = 'お問い合わせありがとうございます';
    $mail2->Body    = "{$name} 様\n\nお問い合わせありがとうございます。\n以下の内容でお問い合わせを受け付けました。\n\n{$message}\n\n折り返しご連絡いたします。";
    $mail2->send(); 
    echo "メールを送信しました";
} catch (Exception $e) {
    echo "メールを送信できませんでした" . $mail->ErrorInfo;
}

?>