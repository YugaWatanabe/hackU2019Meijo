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



if (!empty($_POST)) {
  $_POST['id'] = $member['id'];

  if ($_POST['message'] === '') {
    $error['message'] = 'blank';
  }

  if (strlen($_POST['message']) < 20) {
    $error['project_name'] = 'length';
  }

  if ($_POST['open_year'] === '') {
    $error['open_year'] = 'blank';
  }

  if ($_POST['open_month'] === '') {
    $error['open_month'] = 'blank';
  }

  if ($_POST['open_date'] === '') {
    $error['open_date'] = 'blank';
  }

  if ($_POST['open_time'] === '') {
    $error['open_time'] = 'blank';
  }

  if ($_POST['place_id'] === '') {
    $error['place_id'] = 'blank';
  }


  $fileName = $_FILES['image']['project_name'];
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
    move_uploaded_file($_FILES['image']['tmp_name'], '../image/project/' . $image);
    $_SESSION['join'] = $_POST;
    $_SESSION['join']['image'] = $image;
    header('Location: createprocheck.php');
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
  <title>プロジェクト作成</title>

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
        <a class="nav-item nav-link" href="joinproject.php">プロジェクトを探す</a>
        <?php if (!$loginflag) : ?>
          <a class="nav-item nav-link" href="../login/login.php">ログイン</a>
        <?php endif; ?>

        <?php if ($loginflag) : ?>
          <a class="nav-item nav-link active" href="">プロジェクト作成<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="../login/logout.php">ログアウト</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <br>
  <div class="container">
    <form action="" method="post" enctype="multipart/form-data">
      <h1>プロジェクト作成</h1>
      <br>

      <?php if ($error) : ?>
          <div style="color: #ff0000; background-color: transparent"><h6 style="color=red;">正しい入力ができてないです<br>やりなおしてください</h6></div>
          <br>
        <?php endif; ?>
      <div class="form-group">
        <label for="exampleInputEmail1">プロジェクト名</label>
        <input type="text" name="project_name" class="form-control" size="35" maxlength="255" value="" id="name1" placeholder="Enter your projectname">

        <?php if ($error['project_name'] === 'blank') : ?>
          <p class="error">プロジェクト名を入力してください</p>
        <?php endif; ?>

      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">概要メッセージ</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="3" maxlength="800" placeholder="20文字以上, 800文字以内で入力してください"></textarea>

        <?php if ($error['message'] === 'length') : ?>
          <p class="error">20文字以上を入力してください</p>
        <?php endif; ?>
        <?php if ($error['password'] === 'blank') : ?>
          <p class="error">概要メッセージを入力してください</p>
        <?php endif; ?>

        <br>

        <label for="custom-select-1b">開催地域(仮):</label>
        <select id="custom-select-1b" class="custom-select" name="place_id">
          <option value="">-</option>
          <option value="1">東京都</option>
          <option value="2">神奈川県</option>
          <option value="3">大阪府</option>
          <option value="4">愛知県</option>
        </select>

    
        <label for="custom-select-1b">開始年:</label>
        <select id="custom-select-1b" class="custom-select" name="open_year">
          <option value="">-</option>
          <option value="2019">2019年</option>
          <option value="2020">2020年</option>
          <option value="2021">2021年</option>
          <option value="2022">2022年</option>
          <option value="2023">2023年</option>
          <option value="2024">2024年</option>
          <option value="2025">2025年</option>
          <option value="2026">2026年</option>
          <option value="2027">2027年</option>
          <option value="2028">2028年</option>
          <option value="2029">2029年</option>
          <option value="2030">2030年</option>
        </select>

        <label for="custom-select-1b">開始月:</label>
        <select id="custom-select-1b" class="custom-select" name="open_month">
          <option value="">-</option>
          <option value="1">1月</option>
          <option value="2">2月</option>
          <option value="3">3月</option>
          <option value="4">4月</option>
          <option value="5">5月</option>
          <option value="6">6月</option>
          <option value="7">7月</option>
          <option value="8">8月</option>
          <option value="9">9月</option>
          <option value="10">10月</option>
          <option value="11">11月</option>
          <option value="12">12月</option>
        </select>

        <label for="custom-select-1b">開始日:</label>
        <select id="custom-select-1b" class="custom-select" name="open_date">
          <option value="">-</option>
          <option value="1">1日</option>
          <option value="2">2日</option>
          <option value="3">3日</option>
          <option value="4">4日</option>
          <option value="5">5日</option>
          <option value="6">6日</option>
          <option value="7">7日</option>
          <option value="8">8日</option>
          <option value="9">9日</option>
          <option value="10">10日</option>
          <option value="11">11日</option>
          <option value="12">12日</option>
          <option value="13">13日</option>
          <option value="14">14日</option>
          <option value="15">15日</option>
          <option value="16">16日</option>
          <option value="17">17日</option>
          <option value="18">18日</option>
          <option value="19">19日</option>
          <option value="20">20日</option>
          <option value="21">21日</option>
          <option value="22">22日</option>
          <option value="23">23日</option>
          <option value="24">24日</option>
          <option value="25">25日</option>
          <option value="26">26日</option>
          <option value="27">27日</option>
          <option value="28">28日</option>
          <option value="29">29日</option>
          <option value="30">30日</option>
          <option value="31">31日</option>
        </select>

        <label for="custom-select-1b">開始時刻:</label>
        <select id="custom-select-1b" class="custom-select" name="open_time">
          <option value="">-</option>
          <option value="1">午前1:00</option>
          <option value="2">午前2:00</option>
          <option value="3">午前3:00</option>
          <option value="4">午前4:00</option>
          <option value="5">午前5:00</option>
          <option value="6">午前6:00</option>
          <option value="7">午前7:00</option>
          <option value="8">午前8:00</option>
          <option value="9">午前9:00</option>
          <option value="10">午前10:00</option>
          <option value="11">午前11:00</option>
          <option value="12">午後12:00</option>
          <option value="13">午後1:00</option>
          <option value="14">午後2:00</option>
          <option value="15">午後3:00</option>
          <option value="16">午後4:00</option>
          <option value="17">午後5:00</option>
          <option value="18">午後6:00</option>
          <option value="19">午後7:00</option>
          <option value="20">午後8:00</option>
          <option value="21">午後9:00</option>
          <option value="22">午後10:00</option>
          <option value="23">午後11:00</option>
          <option value="0">午前12:00</option>
        </select>

      </div>
      <div class="form-group">
        <br>
        <label for="image1">サムネイル画像</label>
        <br>

        <?php if ($error['image'] === 'type') : ?>
          <p class="error">写真などはpng,gif,jpgで指定してください</p>
        <?php endif; ?>

        <input type="file" name="image" value="" id="image1">
      </div>
      <button type="submit" class="btn btn-primary">送信</button>
    </form>
    <br>
    <a href="../index.php">トップに戻る</a>
    <br>
    いまログイン中は<?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>さん
  </div>



</body>

</html>