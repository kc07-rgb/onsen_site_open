<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../mailer/src/Exception.php';
require __DIR__ . '/../mailer/src/PHPMailer.php';
require __DIR__ . '/../mailer/src/SMTP.php';

$name = trim($_POST["name"]);
$kana = trim($_POST["kana"]);
$email = trim($_POST["email"]);
$tel = trim($_POST["tel"]);
$message = trim($_POST["message"]);

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
    $mail->Body = "お名前: {$name}({$kana}) 様\nお電話番号： {$tel}\nメール: {$email}\n\n{$message}";

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
    header('Location: contact_thanks.php');
    exit;
} catch (Exception $e) {
    echo "メールを送信できませんでした。<br>もう一度お試しください。<br>お電話でのご連絡も承っております。<br>tel:xxx-xxx-xxxx" . $mail->ErrorInfo;
}

?>