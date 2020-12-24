<?php

session_start();

//ログインしているか判定し、していなかったら新規登録画面を返す
$resul = UserLogic::checkLogin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
</head>
<body>
    <h2>マイページ</h2>
    <p>ログインユーザー：<?php echo h($login_user['name']) ?></p>
    <p>メールアドレス：<?php echo h($login_user['email']) ?></p>
    <form action="logout.php" method="POST">
    <input type="submit" name="logout" value="ログアウト">
    </form>
</body>
</html>
