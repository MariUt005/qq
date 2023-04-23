<?php

session_start();

if (empty($_SESSION['login'])) {
	header("Location: index.php");
}

if (strcmp($_SESSION['login'],'admin')) {
	header("Location: order.php");
}

print <<<HTMLBLOCK
<!DOCTYPE html>
<head>
<title>Панель администратора</title>
<link rel="stylesheet" href="main.css" >
</head>
<body>
<div id="main">
<div class="wrapper">
HTMLBLOCK;

print <<<HTMLBLOCK
<h1>Панель администратора</h1>
<p>Ваш логин:
HTMLBLOCK;

print $_SESSION['login'];

print <<<HTMLBLOCK
</p>
<a href="shops.php" class="panel">Магазины</a>
<a href="tochki.php" class="panel">Торговые точки</a>
<a href="agents.php" class="panel">Кредитные агенты</a>
<a href="order.php" class="panel">Оформление заказа</a>
<a href="logout.php" class="panel">Выйти</a>
</div>
</div>
</body>
</html>
HTMLBLOCK;

?>
