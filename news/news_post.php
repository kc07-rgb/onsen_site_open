    <?php
    session_start();
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

    if (!empty($_POST["submitbtn"])) {

        if (empty($_POST["title"])) {
            $_SESSION["error"] = "タイトルを入力してください";
        } elseif(empty($_POST["comment"])){
            $_SESSION["error"] = "コメントを入力してください";
        }

        if(!empty($_SESSION["error"])){
        $_SESSION["old"] = [
                "comment" => $_POST["comment"],
                "title" => $_POST["title"],
                "img" =>  $_FILES["image"]["name"],
                "category" =>  $_POST["category"]
            ];
            header("Location: ./news_form.php");
            exit;
        }


        $image = $_FILES["image"]["name"];
        $tmp = $_FILES["image"]["tmp_name"];
        if (move_uploaded_file($tmp, "../upload/" . $image)) {
            echo "アップロード成功";
        } else{
            echo "アップロード成功";
        }

        $title = $_POST['title'];
        $comment = $_POST['comment'];
        $category = $_POST['category'];


        try {
            $sql = "INSERT INTO onsen_hotel_site_table(title, comment, image_name,  category)VALUES(:title, :comment, :image_name, :category)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':comment', $comment);
            $stmt->bindParam(':image_name', $image);
            $stmt->bindParam(':category', $category);

            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    $sql = "SELECT `id`, `image_name`, `comment`, `created_at`, `title`, `category` FROM `onsen_hotel_site_table`";
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
        <a href="/温泉/header.php">ホームへ戻る</a>
        <a href="/温泉/news/news_list.php">ニュースリストへ</a>
    </body>

    </html>