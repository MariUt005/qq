<?php

session_start();

if (empty($_SESSION['login'])) {
    header("Location: index.php");
}

require "db.php";
require "config.php";

print <<<HTMLBLOCK
<!DOCTYPE html>
<head>
<title>Оформление кредита</title>
<link rel="stylesheet" href="main.css" >
</head>
<body>
<div id="main">
<div class="wrapper">
HTMLBLOCK;

print <<<HTMLBLOCK
<h1>Оформление кредита</h1>
HTMLBLOCK;

print <<<HTMLBLOCK
<form>
<label>Торговая точка</label>
<select name="tochka">
HTMLBLOCK;
$tochki = R::getAll( 'SELECT * FROM tochka' );
for ($i = 0; $i < count($tochki); $i++) {
    $code = $tochki[$i]['tochka_code'];
    $name = $tochki[$i]['name'];
    print <<<HTMLBLOCK
<option value="$code">$name</option>
HTMLBLOCK;

}
print <<<HTMLBLOCK
</select><br><br>
<label>Способ оплаты</label>
<select name="oplata">
<option>Наличные</option>
<option>Карта</option>
<option>Перевод</option>
</select><br><br>
<input type="text" placeholder="+7 (900) 000-00-00"><br>
<label>Категория кредита</label>
<select name="category">
<option>Образовательный</option>
<option>Автокредит</option>
<option>Ипотека</option>
<option>Потребительский кредит</option>
</select><br><br>
<input type="text" placeholder="Сумма"><br>
<button onclick="alert(1)">Оформить заказ</button>
<button onclick="alert(1)">Получить ссылку</button>
</form>
HTMLBLOCK;

if (!strcmp($_SESSION['login'], $admin)) {
    print '<a href="panel.php">Назад</a>';
} else {
    print '<a href="logout.php">Выйти</a>';
}
print <<<HTMLBLOCK
</div>
</div>
</body>
</html>
HTMLBLOCK;
