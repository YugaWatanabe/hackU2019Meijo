<?php
session_start();
require('../dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();

  header('Location: ../index.php');
  exit();
}

if ($_COOKIE['email'] !== '') {
  $email = $_COOKIE['email'];
}

if (!empty($_POST)) {
  $email = $_POST['email'];

  if ($_POST['email'] !== '' && $_POST['password'] !== '') {
    $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    $login->execute(array($_POST['email'], sha1($_POST['password'])));

    $member = $login->fetch();
    if ($member) {
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      if ($_POST['save'] === 'on') {
        setcookie('email', $_POST['email'], time() + 60 * 60 * 24 * 14);
      }

      header('Location: ../index.php');
      exit();
    } else {
      $error['login'] = 'failed';
    }
  } else {
    $error['login'] = 'blank';
  }
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>login page</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="../style8.css">

  <script src="//code.jquery.com/jquery-1.12.1.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">


  <style>
    .form-control2 {
      width: 75%;
      min-height: 4%;
      margin-right: 10px;
      border-radius: 5px;
      border: 2px solid #ccc;
    }

    @media screen and (min-width: 767px) {
      .form-control2 {
        width: 33%;
      }
    }

    @media screen and (max-width: 479px) {
      .form-control2 {
        width: 90%;
      }
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
        <a class="nav-item nav-link active" href="../index.php">ホーム<span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link" href="../project/joinproject.php">プロジェクトを探す</a>
        <?php if (!$loginflag) : ?>
          <a class="nav-item nav-link" href="login.php">ログイン</a>
        <?php endif; ?>

        <?php if ($loginflag) : ?>
          <a class="nav-item nav-link" href="../project/createpro.php">プロジェクト作成</a>
          <a class="nav-item nav-link" href="logout.php">ログアウト</a>
        <?php endif; ?>

        <form class="form-inline my-2 my-lg-0" action="project/searchproject.php" method="get">
          <input class="search_form2 mr-sm-1" id="search" name="search" type="text" placeholder="フリーワードを入力" />
          <button class="btn_form2" type="submit" id="sbtn2"><i class="fas fa-search"></i></button>
        </form>
      </div>
    </div>
    <form class="form-inline my-2 my-lg-0" action="project/searchproject.php" method="get">
      <input class="form-control mr-sm-1" id="search" name="search" type="text" placeholder="フリーワードを入力" />
      <input type="hidden" name="page" value="1">
      <button class="search_btn" type="submit" id="sbtn2"><i class="fas fa-search"></i></button>
    </form>
  </nav>

  <br>
  <div class="container">
    <?php if ($error) : ?>
      <div style="color: #ff0000; background-color: transparent">
        <h6 style="color=red;">正しい入力ができてないです<br>やりなおしてください</h6>
      </div>
      <br>
    <?php endif; ?>
    <form action="" method="post" onSubmit="return resister()" enctype="multipart/form-data">
      <h1>ログイン</h1>
      <br>
      <div class="form-group">
        <label for="exampleInputEmail1">メールアドレス</label>
        <br>
        <input type="text" name="email" class="form-control2" size="35" maxlength="255" value="" id="email1" aria-describedby="emailHelp" placeholder=" Enter email">
        <small id="emailHelp" class="form-text text-muted">メールアドレスは誰かとシェアしてはいけませんよ</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">パスワード</label>
        <br>
        <input type="password" name="password" size="35" maxlength="255" value="" class="form-control2" id="password1" placeholder=" Password">
      </div>
      <button type="submit" class="btn btn-primary">送信</button>
    </form>
    <br>
    <h4><a href="../join/join.php">アカウント作成へ</a></h4>
  </div>

</body>

</html>