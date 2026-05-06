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
    $username = $_POST["username"] ?? "";
    $password =  ($_POST["password"] ?? "");
    $year = !empty($_POST["year"]) ? $_POST["year"] : null;
    $month = !empty($_POST["month"]) ? $_POST["month"] : null;
    $day = !empty($_POST["day"]) ? $_POST["day"] : null;
    $error = "";

    if ($year && $month && $day) {
        $month = str_pad($month, 2, 0, STR_PAD_LEFT);
        $day = str_pad($day, 2, 0, STR_PAD_LEFT);
        $birthday = $year . "-" . $month . "-" . $day;
    } else {
        $birthday = null;
    }

    if (empty($_POST["username"])) {
        $error =  "ユーザーネームを入力してください";
    } elseif (empty($_POST["password"])) {
        $error = "パスワードを入力してください";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}+$/", $password)) {
        $error = "パスワードは大文字・小文字・数字を含む英数字で入力してください";
    }

    if (empty($error)) {
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    }

    if (empty($error)) {
        try {
            $sql = "INSERT INTO users (username, password, birthday) VALUES (:username, :password, :birthday)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":birthday", $birthday);
            $stmt->execute();

            echo "登録が完了しました";
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                $error = "このユーザー名は既に使用されています";
            } else {
                $error = "登録に失敗しました";
            }
        }
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
    <a href="/温泉/news/news_list.php">戻る</a>
    <form method="POST">
        <label for="username">ユーザーネーム</label>
        <input type="text" name="username" id="username">

        <label for="password">パスワード8文字以上</label>
        <input type="password" name="password" id="password">

        <select name="year" id="year">
            <option value="" disabled selected>年</option>
        </select>
        <select name="month" id="month">
            <option value="" disabled selected>月</option>
        </select>
        <select name="day" id="day">
            <option value="" disabled selected>日</option>
        </select>

        <button type="submit" name="submit">登録</button>

        <?php if (!empty($error)): ?>
            <p><?= $error; ?></p>
        <?php endif; ?>

    </form>

    <script>
        const yearSelect = document.getElementById("year");
        const monthSelect = document.getElementById("month");
        const daySelect = document.getElementById("day");

        for (let i = 2026; i >= 1900; i--) {
            let option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            yearSelect.appendChild(option);
        }

        for (let i = 1; i <= 12; i++) {
            let option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            monthSelect.appendChild(option);
        }

        function updateDays() {
            const year = yearSelect.value;
            const month = monthSelect.value;

            daySelect.innerHTML = `<option value="" disabled selected>日</option>`;

            if (!year || !month) return;
            let days;

            if (month == 2) {
                if ((year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0)) {
                    days = 29;
                } else {
                    days = 28;
                }
            } else if ([4, 6, 9, 11].includes(Number(month))) {
                days = 30;
            } else {
                days = 31;
            }

            for (let i = 1; i <= days; i++) {
                let option = document.createElement("option");
                option.value = i;
                option.textContent = i;
                daySelect.appendChild(option);
            }
        }
        yearSelect.addEventListener("change", updateDays);
        monthSelect.addEventListener("change", updateDays);
    </script>
</body>

</html>