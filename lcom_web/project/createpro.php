<?php
session_start();
require('../dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();

  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();
} else {
  header('Location: ../login/login.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">メニュー</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="../index.php">Home </a>
      <a class="nav-item nav-link" href="../login/login.php">ログイン</a>
      <a class="nav-item nav-link active" href="#">プロジェクト参加<span class="sr-only">(current)</span></a>
    </div>
  </div>
</nav>
    
<br>
    <div class="container">
        <form action="http://localhost:8888/mini_bbs/join/" method="post" onSubmit="return resister()" enctype="multipart/form-data">
            <h1>プロジェクト作成</h1>
            <br>
            <div class="form-group">
                <label for="exampleInputEmail1">プロジェクト名</label>
                <input type="text" name="name" class="form-control" size="35" maxlength="255" value="" id="name1" placeholder="Enter your projectname">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">概要メッセージ</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="800" placeholder="800文字以内で入力してください"></textarea>
            </div>
            <div class="form-group">
                <br>
                <label for="image1">サムネイル画像</label>
                <br>
                <input type="file" name="image" value="" id="image1">
            </div>
            <button type="submit" class="btn btn-primary">送信</button>
        </form>
        <br>
        <a href="../index.php">トップに戻る</a>
        <div style="text-align: right"><a href="../login/logout.php">ログアウト</a></div>
    </div>


   
</body>
</html>