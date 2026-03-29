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

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    exit("不正なIDです");
}

$stmt = $pdo->prepare("SELECT * FROM onsen_hotel_site_table WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$news = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$news) {
    exit("データがありません");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>編集画面</h2>
    <p>編集画面の追加</p>
</body>
</html>