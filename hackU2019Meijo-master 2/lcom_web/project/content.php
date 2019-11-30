<?php
session_start();
require('../dbconnect.php');
require('../prefacture.php');
require('judge_coment.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();
    $useid = $_SESSION['id'];
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

if (!empty($_POST)) {
    if ($_POST['message'] !== '') {
        $dark = dark_word_check($_POST['message']);
        $light = light_word_check($_POST['message']);

        $users = $db->prepare('SELECT * FROM members WHERE id=?');
        $users->execute(array($_SESSION['id']));
        $user = $users->fetch();

        $coment_points = $db->prepare('UPDATE members SET dark_point = ? + ?, light_point = ? + ?,sum_coment = ? + 1 WHERE id = ?');
        $coment_points->execute(array($user['dark_point'], $dark, $user['light_point'], $light, $user['sum_coment'], $useid));
        $coment_point = $coment_points->fetch();

        $message = $db->prepare('INSERT INTO posts SET member_id=?, message=?, reply_project_id=?, reply_message_id=?, created=NOW()');
        $message->execute(array($_SESSION['id'], $_POST['message'], $_POST['reply_project_id'], $_POST['reply_post_id']));



        header('Location: content.php?id=' . htmlspecialchars($_POST['reply_project_id'], ENT_QUOTES));
        exit();
    }
}


//上記の「ポストID」と一致する「memberID」から名前と写真を取得する
$coms = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND reply_project_id=?');
$coms->execute(array($_REQUEST['id']));
$com = $coms->fetch();

$counts = $db->prepare('UPDATE projects SET pro_point = ? + 1 WHERE id = ?');
$counts->execute(array($procard['pro_point'], $_REQUEST['id']));
$count = $counts->fetch();


if (isset($_REQUEST['res'])) {
    //返信の処理
    $response = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=?');
    $response->execute(array($_REQUEST['res']));

    $table = $response->fetch();
    $message = '@' . $table['name'] . ' ' . $table['message'];
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="../style8.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>詳細画面</title>

    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-image: url(../image/top/bgbody.png);
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="../index.php">ホーム</a>
                <a class="nav-item nav-link" href="joinproject.php">プロジェクトを探す</a>
                <?php if (!$loginflag) : ?>
                    <a class="nav-item nav-link" href="../login/login.php">ログイン</a>
                <?php endif; ?>

                <?php if ($loginflag) : ?>
                    <a class="nav-item nav-link" href="createpro.php">プロジェクト作成</a>
                    <a class="nav-item nav-link" href="../login/logout.php">ログアウト</a>
                <?php endif; ?>

                <form class="form-inline my-2 my-lg-0" action="searchproject.php" method="get">
                    <input class="search_form2 mr-sm-1" id="search" name="search" type="text" placeholder="フリーワードを入力" />
                    <button class="btn_form2" type="submit" id="sbtn2"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <form class="form-inline my-2 my-lg-0" action="searchproject.php" method="get">
            <input class="form-control mr-sm-1" id="search" name="search" type="text" placeholder="フリーワードを入力" />
            <input type="hidden" name="page" value="1">
            <button class="search_btn" type="submit" id="sbtn2"><i class="fas fa-search"></i></button>
        </form>
    </nav>

    <div class="container">

        <?php print(htmlspecialchars($user['id'], ENT_QUOTES)); ?>

        <div class="pro_kakoi" style="text-align: center;">
            <div class="pro_inner" style="padding: 15px; text-align: center;">
                <img src="../image/project/<?php print(htmlspecialchars($procard['project_picture'], ENT_QUOTES)); ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h2><?php print(htmlspecialchars($procard['project_name'], ENT_QUOTES)); ?></h2>
                    <h3><?php print(mb_substr(htmlspecialchars($procard['message'], ENT_QUOTES), 0, 800)); ?></h3>
                    <p>開始: <?php print(htmlspecialchars($procard['open_year'] . "/" . $procard['open_month'] . "/" . $procard['open_date'] . " " . $procard['open_time'] . ":00", ENT_QUOTES)); ?></p>
                    <h2><?php print(htmlspecialchars(refer_prefecture($procard['place_id']), ENT_QUOTES)); ?></h2>
                </div>
                <img class="pro_icon" style="vertical-align:top;" src="../image/icon/<?php print(htmlspecialchars($member['picture'], ENT_QUOTES)); ?>" /><span class="pro_icon_text"><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?></span>
            </div>


        </div>


        <?php foreach ($coms as $com) : ?>
            <span class="item-header clearfix">
                <span class="item-user-icon">
                    <img src="../image/icon/<?php print(htmlspecialchars($com['picture'], ENT_QUOTES)); ?>" height="48" width="48" alt="icon" />
                </span>
                <span class="item-user-name">
                    <strong><?php print(htmlspecialchars($com['message'], ENT_QUOTES)); ?></strong>

                </span>
                <span class="item-date">
                    <?php print(htmlspecialchars($com['created'], ENT_QUOTES)); ?>　<?php print(htmlspecialchars($com['name'], ENT_QUOTES)); ?>
                </span>
            </span>
        <?php endforeach; ?>

        <?php if ($loginflag) : ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">コメントエリア</label>

                    <br>
                    <textarea class="comment-text" name="message" cols="50" rows="2"><?php print(htmlspecialchars($message, ENT_QUOTES)); ?></textarea>
                    <button type="submit" class="btn btn-primary mb-2">送信</button>
                    <input type="hidden" name="id" value="<?php print(htmlspecialchars($_REQUEST['id'], ENT_QUOTES)); ?>" />
                    <input type="hidden" name="reply_project_id" value="<?php print(htmlspecialchars($_REQUEST['id'], ENT_QUOTES)); ?>" />
                    <input type="hidden" name="reply_post_id" value="<?php print(htmlspecialchars($_REQUEST['res'], ENT_QUOTES)); ?>" />
                </div>
            </form>
        <?php endif; ?>




    </div>

</body>

</html>