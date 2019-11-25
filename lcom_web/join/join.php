<?php
session_start();
require('../dbconnect.php');

if (!empty($_POST)) {
  if ($_POST['name'] === '') {
    $error['name'] = 'blank';
  }

  if ($_POST['email'] === '') {
    $error['email'] = 'blank';
  }

  if (strlen($_POST['password']) < 4) {
    $error['password'] = 'length';
  }

  if ($_POST['password'] === '') {
    $error['password'] = 'blank';
  }
  $fileName = $_FILES['image']['name'];
  if (!empty($fileName)) {
    $ext = substr($fileName, -3);
    if ($ext != 'jpg' && $ext != 'png' && $ext != 'gif') {
      $error['image'] = 'type';
    }
  }

  //アカウント重複チェック
  if (empty($error)) {
    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
    $member->execute(array($_POST['email']));
    $record = $member->fetch();
    if ($record['cnt'] > 0) {
      $error['email'] = 'duplicate';
    }
  }

  if (empty($error)) {
    $image = date('YmdHis') . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], '../image/icon/' . $image);
    $_SESSION['join'] = $_POST;
    $_SESSION['join']['image'] = $image;
    header('Location: check.php');
    exit();
  }
}

if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
  $_POST = $_SESSION['join'];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>login page</title>

  <link rel="stylesheet" href="../style4.css">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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
        <a class="nav-item nav-link" href="../project/joinproject.php">プロジェクトを探す</a>
        <a class="nav-item nav-link active" href="#">ログイン<span class="sr-only">(current)</span></a>
      </div>
    </div>
  </nav>



  <br>
  <div class="container">
    <?php if ($error) : ?>
      <div style="color: #ff0000; background-color: transparent">
        <h6 style="color=red;">正しい入力ができてないです<br>やりなおしてください</h6>
      </div>
      <br>
    <?php endif; ?>
    <form action="" method="post" enctype="multipart/form-data">
      <h1>アカウント作成</h1>
      <br>
      <div class="form-group">
        <label for="exampleInputEmail1">ニックネーム</label>
        <input type="text" name="name" class="form-control" size="35" maxlength="255" value="" id="name1" placeholder="Enter your nickname">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">メールアドレス</label>
        <input type="text" name="email" class="form-control" size="35" maxlength="255" value="" id="email1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">メールアドレスは誰かとシェアしてはいけませんよ</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">パスワード</label>
        <input type="password" name="password" size="35" maxlength="255" value="" class="form-control" id="password1" placeholder="Password">
      </div>
      <div class="form-group">
        <input type="file" name="image" value="" id="image1">
      </div>
      <button type="submit" class="btn btn-primary">送信</button>
    </form>
    <br>
    <h4><a href="../login/login.php">ログイン画面へ戻る</a></h4>
  </div>

</body>

</html>