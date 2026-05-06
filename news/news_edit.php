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



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // =====================
    // 更新処理（POST）
    // =====================
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    if ($id === false || $id === null || $id <= 0 || $id >= 1000) {
        exit("不正なidです");
    }

    $title = $_POST["title"];
    $comment = $_POST["comment"];

    if (!empty($_FILES["img"]["name"])) {
        $image_name = time() . "_" . $_FILES["img"]["name"];
        $tmp_path = $_FILES["img"]["tmp_name"];
        move_uploaded_file($tmp_path, "upload/" . $image_name);
    } else {
        $image_name = $_POST["old_image"];
    }

    $stmt = $pdo->prepare("UPDATE onsen_hotel_site_table SET title=?, comment=?, image_name=? WHERE id=?");
    $stmt->execute([$title, $comment, $image_name, $id]);

    header("LOCATION: news_list.php");
    exit;
} else {

    // =====================
    // 初回表示（GET）
    // =====================
    $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    if (!$id) {
        exit("不正なidです");
    }

    $stmt = $pdo->prepare("SELECT * FROM onsen_hotel_site_table WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $news = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$news) {
        exit("データがありません");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./news_edit.css">
</head>

<body>
    <h2>編集画面</h2>
    <p>編集画面の追加</p>

    <form action="news_edit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $news["id"] ?>">

        <label for="title">タイトル</label>
        <input type="text" id="title" name="title" value="<?= $news["title"] ?>">

        <label for="comment">コメント</label>
        <input type="text" name="comment" id="comment" value="<?= $news["comment"] ?>">

        <label for="img"> 画像</label>
        <input type="hidden" name="old_image" value="<?= $news["image_name"] ?>">
        <img id="preview" class="news_box_img" src="upload/<?= htmlspecialchars($news["image_name"] ?? "") ?>">
        <input type="file" name="img" id="img">

        <button type="submit">更新する</button>

    </form>
</body>

<script>
    document.getElementById("img").addEventListener("change", function(event) { //#imgを取得→チェンジイベント起こるたびに登録した処理{}を実行
        const file = event.target.files[0]; //inputのfileプロパティ(type=file)の1番目を取り出す

        if (file) { //ファイルが選択されていれば
            const reader = new FileReader(); //読み込み準備

            reader.onload = function(e) { //読み込みが完了したときに実行
                document.getElementById("preview").src = e.target.result; //読み込んだ画像データをpreviewのsrcに設定
            }

            reader.readAsDataURL(file); //表示できる形式に変換(DataURL形式（base64）)
        }
    });
</script>

</html>