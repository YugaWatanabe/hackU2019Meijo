<?php
session_start();
require('../dbconnect.php');
require('../prefacture.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();
    $loginflag = true;
} else {
    $loginflag = false;
}


$procards = $db->prepare('SELECT * FROM projects WHERE id=?');
$procards->execute(array($_REQUEST['id']));
$procard = $procards->fetch();

$members = $db->prepare('SELECT * FROM members WHERE id=?');
$members->execute(array($procard['member_id']));
$member = $members->fetch();

$prefacture = refer_prefecture($procard['place_id']);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="../style.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>詳細画面</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">メニュー</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="../index.php">ホーム</a>
                <a class="nav-item nav-link active" href="joinproject.php">プロジェクトを探す<span class="sr-only">(current)</span></a>
                <?php if (!$loginflag) : ?>
                    <a class="nav-item nav-link" href="../login/login.php">ログイン</a>
                <?php endif; ?>

                <?php if ($loginflag) : ?>
                    <a class="nav-item nav-link" href="createpro.php">プロジェクト作成</a>
                    <a class="nav-item nav-link" href="../login/logout.php">ログアウト</a>
                <?php endif; ?>

            </div>
        </div>
    </nav>

    <div class="container">
        <img src="../image/project/<?php print(htmlspecialchars($procard['project_picture'], ENT_QUOTES)); ?>" class="content-img mb-3" ; alt="...">
        </figure>

        <div class="kakomi">
            <h4>概要メッセージ</h4>
            <h6><?php print(htmlspecialchars($procard['message'], ENT_QUOTES)); ?></h6>
            <small>開始: <?php print(htmlspecialchars($procard['open_year'] . "/" . $procard['open_month'] . "/" . $procard['open_date'] . " " . $procard['open_time'] . ":00", ENT_QUOTES)); ?> <?php print(htmlspecialchars($prefacture, ENT_QUOTES)); ?> にて開催</small>
            <br>

            <nav class="inline-block">
                <ul>
                    <li>
                        <div class="content-icon">
                            <img src="../image/icon/<?php print(htmlspecialchars($member['picture'], ENT_QUOTES)); ?>" class="content-icon" alt="写真">
                        </div>
                    </li>
                    <li><small><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>さんの投稿</small></li>
                </ul>
            </nav>

        </div>

    </div>

</body>

</html>