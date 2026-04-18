    <?php

    $image = $_FILES["image"]["name"];
    $tmp = $_FILES["image"]["tmp_name"];
    if(move_uploaded_file($tmp , "upload/" . $image)){
        echo "アップロード成功";
    }

    $title = $_POST['title'];
    $comment = $_POST['comment'];

    try {
        $pdo = new PDO(
        'mysql:host=localhost;dbname=onsen_hotel_site',
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    } catch(PDOException $e) {
    echo $e -> getMessage();
    exit("DB接続エラー");
    }


    if(!empty($_POST["submitbtn"])){
    try{
        $sql = "INSERT INTO onsen_hotel_site_table(title, comment, image_name)VALUES(:title, :comment, :image_name)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':image_name', $image);

    $stmt->execute();
    }catch(PDOException $e){
        echo $e -> getMessage();
    }
    }

    $sql = "SELECT `id`, `image_name`, `comment`, `created_at`, `title` FROM `onsen_hotel_site_table`";
    $news_array = $pdo->query($sql);

    $pdo = null;

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <a href="./header.php">ホームへ戻る</a>
    </body>
    </html>