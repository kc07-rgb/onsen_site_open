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
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    try {
        $sql = "INSERT INTO `users`(`username`, `password`) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();

        echo "登録が完了しました";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録画面</title>
</head>

<body>
    <form method="POST">
        <label for="">ユーザーネーム</label>
        <input type="text" name="username" required>

        <label for="">パスワード</label>
        <input type="password" name="password" required>

        <button type="submit" name="submit">登録</button>
    </form>
</body>

</html>