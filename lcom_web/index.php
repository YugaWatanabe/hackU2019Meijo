<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();

  $loginflag = true;
} else {
  $loginflag = false;
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>LCOM TOP</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="style4.css">

  <script src="//code.jquery.com/jquery-1.12.1.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

</head>

<body>

  <!--
    <div class="anime">
        <img src="image/video/lcom_20.gif" />
    </div>
-->

  <div class="mainSite">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="#">ホーム<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="project/joinproject.php">プロジェクトを探す</a>
          <?php if (!$loginflag) : ?>
            <a class="nav-item nav-link" href="login/login.php">ログイン</a>
          <?php endif; ?>

          <?php if ($loginflag) : ?>
            <a class="nav-item nav-link" href="project/createpro.php">プロジェクト作成</a>
            <a class="nav-item nav-link" href="login/logout.php">ログアウト</a>
          <?php endif; ?>

          <form class="form-inline my-2 my-lg-0" action="自分のサイトURL" method="get">
            <input class="search_form2 mr-sm-1" id="search" name="s" type="text" placeholder="フリーワードを入力" />
            <button class="btn_form2" type="submit" id="sbtn2"><i class="fas fa-search"></i></button>
          </form>
        </div>
      </div>
      <form class="form-inline my-2 my-lg-0" action="自分のサイトURL" method="get">
        <input class="form-control mr-sm-1" id="search" name="s" type="text" placeholder="フリーワードを入力" />
        <button class="search_btn" type="submit" id="sbtn2"><i class="fas fa-search"></i></button>
      </form>
    </nav>




    <div class="container">
      <div class="row">
        <img src="image/top/cloud_4.png" class="col-6 img-fluid animated pulse infinite" ; id="cloud_img" ; alt="cloud"><img src="image/top/cloud_5.png" id="cloud_img" ; class="col-6 img-fluid animated pulse infinite" ; alt="cloud">
        <img src="image/top/cloud_7.png" class="col-6 img-fluid animated pulse infinite" ; id="cloud_img" ; alt="cloud"><img src="image/top/cloud_8.png" id="cloud_img" ; class="col-6 img-fluid animated pulse infinite" ; alt="cloud">

        <img src="image/top/lcom_4.png" class="col-12 img-fluid" ; id="lcom_img" ; alt="cloud">

        <div class="kakomi_top">
          <h5>おすすめ : aaaa</h5>
          <h6>最大15文字程度？</h6>
        </div>
        <div class="kakomi_top">
          <h5>おすすめ : aaaa</h5>
          <h6>uuuuuuuuuuuuuuuuuuuuu</h6>
        </div>
      </div>
    </div>




    <!--
        <script>
            $(function() {
                $(".mainSite").css({
                    opacity: '0'
                });
                setTimeout(function() {
                    $(".mainSite").css("display", "block");
                    $(".mainSite").stop().animate({
                        opacity: '1'
                    }, 1000);
                }, 3000);
            });

            $(function() {
                $(".mainSite").css("display", "none");
                setTimeout(function() {
                    $('.anime').fadeOut();
                }, 2500);
            });
        </script>
          -->
</body>

</html>