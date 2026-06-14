<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=onsen_hotel_site', "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit("接続エラー");
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            echo "ログイン成功";
            header("Location: /温泉/news/news_form.php");
            exit;
        }else{
            echo "ユーザーネームまたはパスワードが違います";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>鳥沢温泉 | ログイン</title>
    <link rel="icon" href="./img/favicon.png"></link>
</head>

<body>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="ユーザーネーム">
        <input type="password" name="password" placeholder="パスワード">
        <button type="submit" name="login">ログイン</button>
    </form>
</body>

</html>