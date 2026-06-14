<?php

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=onsen_hotel_site',
        "konsent_onsen",
        "Tika0724"
    );

    $stmt = $pdo->prepare("SELECT * FROM onsen_hotel_site_table WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $news = $stmt->fetch();
} catch (PDOException $e) {
    echo "エラー：" . $e->getMessage();
}

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if(!$id){
    exit("投稿がありません");
}

$stmt = $pdo->prepare("DELETE FROM onsen_hotel_site_table WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: news_list.php");
exit;

?>