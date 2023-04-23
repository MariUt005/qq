<?php
session_start();

if (empty($_SESSION["login"])) {
    header("Location: index.php");
}

if (strcmp($_SESSION['login'],'admin')) {
    header("Location: order.php");
}

require "db.php";
function regaccess() {
    if (isset($_POST['login'])) {
        $_COOKIE['login'] = $_POST['login'];
        $_COOKIE['tochka_code'] = $_POST['tochka_code'];
        if (empty($_POST['login'])) {
            return "Введите логин!";
        }
        if (empty($_POST['tochka_code'])) {
            return "Введите код точки!";
        }
        $access = R::findOne('access', 'login = ? and tochka_code = ?', array($_POST['login'], $_POST['tochka_code']));
        if (! empty($access)) {
            return "Доступ уже существует!";
        }
        $tochka = R::findOne('tochka', 'tochka_code = ?', array($_POST['tochka_code']));
        if (empty($tochka)) {
            return "Такой точки не существует!";
        }
        $agent = R::findOne('agents', 'login = ?', array($_POST['login']));
        if (empty($agent)) {
            return "Такого агента не существует!";
        }
        $access = R::dispense('access');
        $access->login = $_POST['login'];
        $access->tochka_code = $_POST['tochka_code'];
        R::store($access);

        $_COOKIE['login'] = NULL;
        $_COOKIE['tochka_code'] = NULL;

        header("Location: agents.php?tochka_code=".$_POST['tochka_code'] );
    } else {
        $_COOKIE['login'] = NULL;
        $_COOKIE['tochka_code'] = NULL;
    }
    return NULL;
}
$error = regaccess();

print <<<HTMLBLOCK
<!DOCTYPE html>
<head>
<title>Новый доступ</title>
<link rel="stylesheet" href="main.css" >
</head>
<body>
<div id="main">
<div class="wrapper">
HTMLBLOCK;

$login = isset($_COOKIE['login']) ? $_COOKIE['login'] : NULL;
$tochka_code = isset($_COOKIE['tochka_code']) ? $_COOKIE['tochka_code'] : NULL;

print <<<HTMLBLOCK
<h1>Новый доступ</h1>
<span class="error">$error</span>
<form action="" method="POST">
<label>Логин</label>
<select name="login">
HTMLBLOCK;
$agents = R::getAll('SELECT * FROM agents');
for ($i = 0; $i < count($agents); $i++) {
    print "<option value=".$agents[$i]['login'].">".$agents[$i]['login']."</option>";
}
print <<<HTMLBLOCK
</select><br><br>
<label>Код точки</label>
<select name="tochka_code">
HTMLBLOCK;
$tochki = R::getAll('SELECT * FROM tochka');
for ($i = 0; $i < count($tochki); $i++) {
    print "<option value=".$tochki[$i]['tochka_code'].">".$tochki[$i]['name']."</option>";
}
print <<<HTMLBLOCK
</select><br><br>
<a href="agents.php?tochka_code=$tochka_code">Назад</a>
<input type="submit" name="regshop" value="Выдать доступ">
</form>
</div>
</div>
</body>
</html>
HTMLBLOCK;


?>