<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Задачи</title>
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/site.css" rel="stylesheet">
</head>

<body>
	<div class="wrap">
		<nav id="w2" class="navbar-inverse navbar-fixed-top navbar">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w2-collapse"><span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button><a class="navbar-brand" href="/">Главная</a>
                </div>
                <div id="w2-collapse" class="collapse navbar-collapse">
					<ul id="w3" class="navbar-nav navbar-right nav">
						<li>
                            <?php if (isset($_SESSION['admin'])) { ?>
                                <a href="/site/logout">Выйти (admin)</a>
                            <?php } else { ?>
                                <a href="/site/login">Войти</a>
                            <?php } ?>
                        </li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
            <?php
                if (isset($_SESSION['success'])) {
            ?>
                    <div id="w4-success-0" class="alert-success alert fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?= $_SESSION['success'] ?></div>
            <?php
                    unset($_SESSION['success']);
                }
            ?>
            <?= $content ?>
        </div>
    </div>
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.js"></script>
</body>

</html>
