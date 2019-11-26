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

    <link rel="stylesheet" href="style8.css">

    <script src="//code.jquery.com/jquery-1.12.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-rwdImageMaps/1.6/jquery.rwdImageMaps.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">


    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }
        img {
            margin-top: 50%;
            width: 100%;
            height: auto;
        }
        @media screen and (min-width: 767px) {
            img {
            margin-top: 40px;
            width: 100%;
            height: auto;
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
            <div class="animated jello">
                <img src="image/top/japan1.png" usemap="#ImageMap" alt="" />
                <map name="ImageMap">
                    <area shape="poly" coords="870,242,866,244,866,244,820,205,869,190,895,166,887,142,931,146,981,91,977,22,987,14,1060,100,1167,106,1176,163,1131,155,1047,199,1043,252,987,189,935,201,926,216,881,191,907,246,870,243,870,243" href="project/search_place.php?place=8&page=1" alt="hokkaido" />
                    <area shape="poly" coords="850,266,850,267,908,264,938,253,949,271,908,419,864,543,746,483,793,419,814,397,799,369,823,333,823,333" href="project/search_place.php?place=14&page=1" alt="tohoku" />
                    <area shape="poly" coords="736,601,745,590,751,590,719,493,737,484,854,550,901,630,824,686,829,638,797,658,752,661,731,606,732,598,733,598" href="project/search_place.php?place=1&page=1" alt="" />
                    <area shape="poly" coords="498,527,584,510,560,478,633,443,629,476,603,509,679,473,731,414,783,374,792,395,745,473,717,490,746,589,715,606,737,638,723,676,703,684,707,640,678,653,675,683,629,661,608,679,598,640,576,623,578,577,592,557,574,537,481,537,470,523,479,522" href="project/search_place.php?place=4&page=1" alt="" />
                    <area shape="poly" coords="492,717,534,708,541,688,563,696,579,668,554,651,558,639,576,636,566,617,570,573,582,555,569,541,479,539,466,533,446,564,462,600,492,600,508,587,520,600,514,610,491,622,499,656,485,677,479,712,502,724,529,709,529,709" href="project/search_place.php?place=3&page=1" alt="" />
                    <area shape="poly" coords="215,622,224,642,274,649,321,632,342,611,414,612,454,593,437,561,450,536,343,562,302,593,220,619,199,621" href="project/search_place.php?place=20&page=1" alt="" />
                    <area shape="poly" coords="289,701,291,715,333,743,366,725,368,711,388,691,441,709,457,637,417,636,404,655,335,659,289,693,322,690" href="project/search_place.php?place=8&page=1" alt="" />
                    <area shape="poly" coords="98,702,96,657,189,661,209,645,230,660,233,702,270,743,270,778,218,794,204,824,196,863,146,842,140,815,165,772,172,730,198,735,176,694,105,703,94,704" href="project/search_place.php?place=28&page=1" alt="" />
                    <area shape="poly" coords="77,321,364,262,430,11,15,0,36,288,36,288" href="project/search_place.php?place=25&page=1" alt="" />
                </map>
            </div>

            <script>
                $('img[usemap]').rwdImageMaps();
            </script>
</body>

</html>