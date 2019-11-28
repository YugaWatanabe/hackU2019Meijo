<?php
session_start();
require('dbconnect.php');
require('prefacture.php');
require('l_coment.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    $_SESSION['time'] = time();

    $loginflag = true;

    $members = $db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();
} else {
    $loginflag = false;
}
$page = $_GET['page'];

$personal = array(0, "0");

if ($loginflag) {
    $personal = refer_personal($member['dark_point'], $member['light_point'], $member['sum_coment']);
} else {
    if ($page == '') {
        $page = 1;
    }
    $page = max($page, 1);


    $maxPage = ceil($cnt['cnt'] / 6);
    $page = min($page, $maxPage);

    $start = ($page - 1) * 6;

    // 今後はデータベースに地方IDを作ってそれでやるように改良するか、この画面で都道府県を絞り込めるようにする
    // ここを受け取った値で絞り込む
    $procards = $db->prepare('SELECT * FROM projects ORDER BY pro_point DESC LIMIT 0, 1');
    $procards->execute(array($_REQUEST['id']));
    $procard = $procards->fetch();
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

    <link rel="stylesheet" href="style8.css">

    <script src="//code.jquery.com/jquery-1.12.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

    <style>
        .hot_img {
            position: absolute;
            top: 90%;
            right: 40%;
            box-shadow: 0.2px 0.4px 0.6px #ccc;
        }

        .top_kakoi {
            position: relative;
            font-family: TanukiFont;
            background: #fff;
            padding-top: 1%;
            padding-bottom: 0;
            width: 80%;
            height: 10%;
            max-height: 40%;
            margin: 3% auto;
            border: solid 7px #1d4293;
            border-radius: 15%;
            box-shadow: 5px 5px 20px 5px rgba(0, 0, 0, 0.7);
        }

        .top_inner {
            position: relative;
            border-radius: 20%;

            background-size: 2px 100%, 100% 2em;
        }

        .top_inner p,
        h2 {
            font-size: 30px;
            color: #011936;
        }

        .top_inner img {
            text-align: center;
            width: 50%;
            left: 20%;
        }

        #lcomtyan_img {
            -webkit-filter: drop-shadow(3px 0 2px #222222);
            width: auto;
            max-width: 30vw;
            height: auto;
            max-height: 30vw;
            margin: 0 auto;
        }

        @media screen and (max-width: 479px) {
            .hot_img {
                position: absolute;
                top: -15%;
                right: -20%;
                border-style:none;

            }

            .top_kakoi {
                position: relative;
                font-family: TanukiFont;
                background: #fff;
                padding-top: 1.5%;
                padding-bottom: 0;
                width: 80%;
                height: 10%;
                max-height: 40%;
                margin: 3% auto;
                border: solid 7px #1d4293;
                border-radius: 15%;
                box-shadow: 5px 5px 20px 5px rgba(0, 0, 0, 0.7);
            }

            .top_inner {
                position: relative;
                border-radius: 20%;

                background-size: 2px 100%, 100% 2em;
            }

            .top_inner p,
            h2 {
                font-size: 25px;
                font-weight: bold;
            }

            .top_inner img {
                text-align: center;
                width: 50%;
                left: 20%;
            }
        }
    </style>

</head>

<body>

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
            <div class="row">
                <nobr><a href="ninki.php"><img src="image/top/cloud_4.png" class="col-6 img-fluid animated pulse infinite" ; id="cloud_img" ; alt="cloud"></a><a href="place_date.php"><img src="image/top/cloud_5.png" id="cloud_img" ; class="col-6 img-fluid animated pulse infinite" ; alt="cloud"></a></nobr>
                <nobr><a href="japanmap.php"><img src="image/top/cloud_7.png" class="col-6 img-fluid animated pulse infinite" ; id="cloud_img" ; alt="cloud"></a><a href="keyword.php"><img src="image/top/cloud_8.png" id="cloud_img" ; class="col-6 img-fluid animated pulse infinite" ; alt="cloud"></a></nobr>
                <br>

                <?php if (!$loginflag) : ?>
                    <img src="image/lcom/lcom_6.png" class="col-12 img-fluid" ; id="lcomtyan_img" ; alt="cloud">
                <?php endif; ?>

                <?php if ($loginflag and $personal["1"] == 'waru') : ?>
                    <img src="image/lcom/lcom_25.png" class="col-12 img-fluid" ; id="lcomtyan_img" ; alt="cloud">
                <?php endif; ?>
                <?php if ($loginflag and $personal["1"] == 'warusugi') : ?>
                    <img src="image/lcom/lcom_26.png" class="col-12 img-fluid" ; id="lcomtyan_img" ; alt="cloud">
                <?php endif; ?>
                <?php if ($loginflag and $personal["1"] == 'yosage') : ?>
                    <img src="image/lcom/lcom_27.png" class="col-12 img-fluid" ; id="lcomtyan_img" ; alt="cloud">
                <?php endif; ?>
                <?php if ($loginflag and $personal["1"] == 'tenshi') : ?>
                    <img src="image/lcom/lcom_28.png" class="col-12 img-fluid" ; id="lcomtyan_img" ; alt="cloud">
                <?php endif; ?>
                <?php if ($loginflag and $personal["1"] == 'hutu') : ?>
                    <img src="image/lcom/lcom_9.png" class="col-12 img-fluid" ; id="lcomtyan_img" ; alt="cloud">
                <?php endif; ?>
            </div>

            <?php if (!$loginflag) : ?>
                <a href="project/content.php?id=<?php print(htmlspecialchars($procard['id'], ENT_QUOTES)); ?>">
                    <div class="top_kakoi" style="text-align: center;">
                        <div class="top_inner" style="padding: 15px; text-align: center;">
                            <img src="image/top/hot1.png" class="hot_img animated bounceIn" ; id="lcom_img" ; alt="cloud">
                            <img src="image/project/<?php print(htmlspecialchars($procard['project_picture'], ENT_QUOTES)); ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h2><?php print(htmlspecialchars($procard['project_name'], ENT_QUOTES)); ?></h2>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endif; ?>

            <?php if ($loginflag) : ?>
                <div class="top_kakoi" style="text-align: center;">
                    <div class="top_inner" style="padding: 15px; text-align: center;">
                        <div class="card-body">
                            <h2><?php print(htmlspecialchars($personal["0"], ENT_QUOTES)); ?></h2>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>


    </div>
    </div>

</body>

</html>