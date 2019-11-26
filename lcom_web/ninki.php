<?php
session_start();
require('dbconnect.php');
require('prefacture.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();
    $loginflag = true;
} else {
    $loginflag = false;
}

$page = $_GET['page'];

if ($page == '') {
    $page = 1;
}
$page = max($page, 1);

$counts = $db->query('SELECT COUNT(*) AS cnt FROM projects');
$cnt = $counts->fetch();

$maxPage = ceil($cnt['cnt'] / 6);
$page = min($page, $maxPage);

$start = ($page - 1) * 6;

// 今後はデータベースに地方IDを作ってそれでやるように改良するか、この画面で都道府県を絞り込めるようにする
// ここを受け取った値で絞り込む
$procards = $db->prepare('SELECT m.name, m.picture, p.* FROM members m, projects p WHERE m.id=p.member_id ORDER BY p.pro_point DESC LIMIT ?, 6');
$procards->bindParam(1, $start, PDO::PARAM_INT);
$procards->execute();

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LCOM プロジェクト</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="style8.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <style>
        @import url('https://fonts.googleapis.com/css?family=Noto+Sans+JP');

        .paging {
            margin: 5%;
            margin-left: 0%;
            font-family: 'Noto Sans JP', sans-serif;
        }

        .paging li {
            display: inline;
            list-style: none;
        }

        @media screen and (max-width: 479px) {
            .paging {
                margin-top: 10%;
                margin-bottom: 10%;
                margin-left: 0%;
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
                <a class="nav-item nav-link active" href="index.php">ホーム<span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="project/joinproject.php">プロジェクトを探す</a>
                <?php if (!$loginflag) : ?>
                    <a class="nav-item nav-link" href="login/login.php">ログイン</a>
                <?php endif; ?>

                <?php if ($loginflag) : ?>
                    <a class="nav-item nav-link" href="project/createpro.php">プロジェクト作成</a>
                    <a class="nav-item nav-link" href="login/logout.php">ログアウト</a>
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



    <div class="container">
        <br>
        <?php foreach ($procards as $procard) : ?>
            <a href="project/content.php?id=<?php print(htmlspecialchars($procard['id'], ENT_QUOTES)); ?>">
                <div class="pro_kakoi animated bounceInDown" style="text-align: center;">
                    <div class="pro_inner" style="padding: 15px; text-align: center;">

                        <img src="image/project/<?php print(htmlspecialchars($procard['project_picture'], ENT_QUOTES)); ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h2><?php print(htmlspecialchars($procard['project_name'], ENT_QUOTES)); ?></h2>
                            <h3><?php print(mb_substr(htmlspecialchars($procard['message'], ENT_QUOTES), 0, 25)); ?></h3>
                            <p>開始: <?php print(htmlspecialchars($procard['open_year'] . "/" . $procard['open_month'] . "/" . $procard['open_date'] . " " . $procard['open_time'] . ":00", ENT_QUOTES)); ?></p>
                            <h2><?php print(htmlspecialchars(refer_prefecture($procard['place_id']), ENT_QUOTES)); ?></h2>

                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
        <ul class="paging">
            <?php if ($page > 1) : ?>
                <li><a href="ninki.php?page=<?php print($page - 1); ?>">前のページへ</a></li>
            <?php else : ?>
                <li>前のページへ</a></li>
            <?php endif; ?>

            <?php if ($page < $maxPage) : ?>
                <li><a href="ninki.php?page=<?php print($page + 1); ?>">次のページへ</a></li>
            <?php else : ?>
                <li>次のページへ</a></li>
            <?php endif; ?>
        </ul>

    </div>



</body>

</html>