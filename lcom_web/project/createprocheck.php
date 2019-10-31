<?php
session_start();
require('../dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();

    $members = $db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();
    $loginflag = true;
} else {
    $loginflag = false;
    header('Location: ../login/login.php');
    exit();
}

if (!isset($_SESSION['join'])) {
    header('Location: ../login/login.php');
    exit();
}

if (!empty($_POST)) {
    $statement = $db->prepare('INSERT INTO projects SET project_name=?, message=?, member_id=?, picture=?, open_year=?, open_month=?, open_date=?, open_time=?, created=NOW()');
    $statement->execute(array($_SESSION['join']['project_name'],$_SESSION['join']['message'], $_SESSION['join']['id'],$_SESSION['join']['image'],$_SESSION['join']['open_year'],$_SESSION['join']['open_month'],$_SESSION['join']['open_date'],$_SESSION['join']['open_time']));
    unset($_SESSION['join']);

    header('Location: ../thankspro.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>プロジェクトチェック</title>
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <input type="hidden" name="action" value="submit" />
            <h1>プロジェクト名</h1>
            <h5><?php print(htmlspecialchars($_SESSION['join']['project_name'], ENT_QUOTES)); ?></h5>
            <h3>概要メッセージ</h3>
            <h5><?php print(htmlspecialchars($_SESSION['join']['message'], ENT_QUOTES)); ?></h5>

            <h3>開催地域</h3>
            <h5><?php print(htmlspecialchars($_SESSION['join']['place'], ENT_QUOTES)); ?></h5>
            <h3>日時</h3>
            <h5><?php print(htmlspecialchars($_SESSION['join']['open_year'] . "/" . $_SESSION['join']['open_month'] . "/" . $_SESSION['join']['open_date'] . " " . $_SESSION['join']['open_time'] . ":00", ENT_QUOTES)); ?></h5>
            <h4>サムネイル写真</h4>


            <figure class="figure">
                <?php if ($_SESSION['join']['image'] != '') : ?>
                    <img src="../image/project/<?php print(htmlspecialchars($_SESSION['join']['image'], ENT_QUOTES)); ?>" class="figure-img img-fluid rounded" alt="...">
                <?php endif; ?>
                <figcaption class="figure-caption">A caption for the above image.</figcaption>
            </figure>
            <div><a href="createpro.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>

    </div>


</body>

</html>