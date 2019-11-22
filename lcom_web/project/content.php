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



if (!empty($_POST)) {
    if ($_POST['message'] !== '') {
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

    <link rel="stylesheet" href="../style3.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>詳細画面</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
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
            <h4><?php print(htmlspecialchars($procard['project_name'], ENT_QUOTES)); ?>: 概要メッセージ</h4>
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
        <?php foreach ($coms as $com) : ?>
            <span class="item-header clearfix">
                <span class="item-user-icon">
                    <img src="../image/icon/<?php print(htmlspecialchars($com['picture'], ENT_QUOTES)); ?>" height="48" width="48" alt="icon" />
                </span>
                <span class="item-user-name">
                    <strong><?php print(htmlspecialchars($com['message'], ENT_QUOTES)); ?></strong>
                </span>
                <span class="item-date">
                    2014/08/29 19:00　<?php print(htmlspecialchars($com['name'], ENT_QUOTES)); ?>
                </span>
            </span>
        <?php endforeach; ?>

        <?php if ($loginflag) : ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">コメントエリア</label>
                    <textarea class="form-control" name="message" cols="50" rows="3"><?php print(htmlspecialchars($message, ENT_QUOTES)); ?></textarea>
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