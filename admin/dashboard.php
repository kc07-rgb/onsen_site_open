<?php
session_start();

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=konsent_onsen',
        "konsent_onsen",
        "Tika0724",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
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
        header("Location:../news/news_list.php");
        exit;
    } else {
        $error = "ユーザーネームまたはパスワードが違います";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>鳥沢温泉 | 管理画面</title>
    <link rel="icon" href="./img/favicon.png">
    </link>

    <link rel="stylesheet" href="./dashboard.css">
</head>

<body>

    <h1>鳥沢温泉/管理画面</h1>
    <div class="dashboard">
        <form action="dashboard.php" method="POST" class="logion">
            <label for="username">ユーザーネーム</label>
            <input type="text" name="username" id="username" placeholder="ユーザーネーム">
            <label for="passwarod">パスワード</label>
            <input type="password" name="password" id="password" placeholder="パスワード">
            <button type="submit" name="login">ログイン</button>
            <?php if (!empty($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>

        </form>
        <div class="reg">
            <a href="./user_ registration.php">ユーザー登録</a>
        </div>
    </div>


</body>