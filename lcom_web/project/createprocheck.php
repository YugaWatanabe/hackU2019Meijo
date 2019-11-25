<?php
session_start();
require('../dbconnect.php');
require('../prefacture.php');

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
  $statement = $db->prepare('INSERT INTO projects SET project_name=?, message=?, member_id=?, project_picture=?, open_year=?, open_month=?, open_date=?, open_time=?, place_id=?, created=NOW()');
  $statement->execute(array($_SESSION['join']['project_name'], $_SESSION['join']['message'], $_SESSION['join']['id'], $_SESSION['join']['image'], $_SESSION['join']['open_year'], $_SESSION['join']['open_month'], $_SESSION['join']['open_date'], $_SESSION['join']['open_time'], $_SESSION['join']['place_id']));
  unset($_SESSION['join']);

  $id = $db->lastInsertId();

  /*
  header('Location: content.php?id=' . htmlspecialchars($_POST['reply_project_id'], ENT_QUOTES));
  exit();
  */

  header('Location: thankspro.php?id=' . htmlspecialchars($id, ENT_QUOTES));
  exit();
}

$prefacture = refer_prefecture($_SESSION['join']['place_id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="../style3.css">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <title>プロジェクトチェック</title>
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
        <a class="nav-item nav-link" href="joinproject.php">プロジェクトを探す</a>
        <?php if (!$loginflag) : ?>
          <a class="nav-item nav-link" href="login/login.php">ログイン</a>
        <?php endif; ?>

        <?php if ($loginflag) : ?>
          <a class="nav-item nav-link active" href="#">プロジェクト作成<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="../login/logout.php">ログアウト</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <div class="container">
    <form action="" method="post">
      <input type="hidden" name="action" value="submit" />
      <h1>プロジェクト名</h1>
      <h5><?php print(htmlspecialchars($_SESSION['join']['project_name'], ENT_QUOTES)); ?></h5>
      <h3>概要メッセージ</h3>
      <h5><?php print(htmlspecialchars($_SESSION['join']['message'], ENT_QUOTES)); ?></h5>

      <h3>開催地域</h3>
      <h5><?php print(htmlspecialchars($prefacture, ENT_QUOTES)); ?></h5>
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