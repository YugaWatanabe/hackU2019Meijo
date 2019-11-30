<?php
session_start();
require('../dbconnect.php');

if (!isset($_SESSION['join'])) {
	header('Location: index.php');
	exit();
}

if (!empty($_POST)) {
	$statement = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, picture=?, created=NOW()');
	$statement->execute(array($_SESSION['join']['name'], $_SESSION['join']['email'], sha1($_SESSION['join']['password']), $_SESSION['join']['image']));
	unset($_SESSION['join']);

	header('Location: thanks.php');
	exit();
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link rel="stylesheet" href="../style8.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<title>確認画面</title>

	<style>
		.check_img{
			width: 30%;
			height: auto;
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
				<a class="nav-item nav-link active" href="../index.php">ホーム</a>
				<a class="nav-item nav-link" href="joinproject.php">プロジェクトを探す</a>
				<?php if (!$loginflag) : ?>
					<a class="nav-item nav-link" href="../login/login.php">ログイン</a>
				<?php endif; ?>

				<?php if ($loginflag) : ?>
					<a class="nav-item nav-link" href="../project/createpro.php">プロジェクト作成</a>
					<a class="nav-item nav-link" href="../login/logout.php">ログアウト</a>
				<?php endif; ?>

				<form class="form-inline my-2 my-lg-0" action="../project/searchproject.php" method="get">
					<input class="search_form2 mr-sm-1" id="search" name="search" type="text" placeholder="フリーワードを入力" />
					<button class="btn_form2" type="submit" id="sbtn2"><i class="fas fa-search"></i></button>
				</form>
			</div>
		</div>
		<form class="form-inline my-2 my-lg-0" action="../project/searchproject.php" method="get">
			<input class="form-control mr-sm-1" id="search" name="search" type="text" placeholder="フリーワードを入力" />
			<input type="hidden" name="page" value="1">
			<button class="search_btn" type="submit" id="sbtn2"><i class="fas fa-search"></i></button>
		</form>
	</nav>

	<div class="container">
		<form action="" method="post">
			<input type="hidden" name="action" value="submit" />
			<dl>
				<dt>ニックネーム</dt>
				<dd>
					<?php print(htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES)); ?>
				</dd>
				<dt>メールアドレス</dt>
				<dd>
					<?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?>
				</dd>
				<dt>パスワード</dt>
				<dd>
					【表示されません】
				</dd>
				<dt>写真など</dt>
				<dd>
					<?php if ($_SESSION['join']['image'] != '') : ?>
						<img class ="check_img" src="../image/icon/<?php print(htmlspecialchars($_SESSION['join']['image'], ENT_QUOTES)); ?>">
					<?php endif; ?>
				</dd>
				<div><a href="join.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>
			</dl>
			<br>
			<br>
	</div>


</body>

</html>