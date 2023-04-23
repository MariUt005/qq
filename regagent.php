<?php
session_start();

if (empty($_SESSION["login"])) {
    header("Location: index.php");
}

if (strcmp($_SESSION['login'],'admin')) {
    header("Location: order.php");
}

require "db.php";
function regagent() {
    if (isset($_POST['login'])) {
        $_COOKIE['login'] = $_POST['login'];
        $_COOKIE['fio'] = $_POST['fio'];
        if (empty($_POST['login'])) {
            return "Введите логин!";
        }
        if (empty($_POST['fio'])) {
            return "Введите ФИО!";
        }
        $agent = R::findOne('agents', 'login = ?', array($_POST['login']));
        if (! empty($agent)) {
            return "Такой агент уже существует!";
        }
        $agent = R::dispense('agents');
        $agent->login = $_POST['login'];
        $agent->fio = $_POST['fio'];
        $agent->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        R::store($agent);

        $_COOKIE['login'] = NULL;
        $_COOKIE['fio'] = NULL;

        header("Location: agents.php");
    } else {
        $_COOKIE['login'] = NULL;
        $_COOKIE['fio'] = NULL;
    }
    return NULL;
}
$error = regagent();

print <<<HTMLBLOCK
<!DOCTYPE html>
<head>
<title>Новый агент</title>
<link rel="stylesheet" href="main.css" >
</head>
<body>
<div id="main">
<div class="wrapper">
HTMLBLOCK;

$login = isset($_COOKIE['login']) ? $_COOKIE['login'] : NULL;
$fio = isset($_COOKIE['fio']) ? $_COOKIE['fio'] : NULL;

print <<<HTMLBLOCK
<h1>Новый агент</h1>

<span class="error">$error</span>
<form action="" method="POST">
<input type="text" name="login" value="$login" placeholder="Логин"><br>
<input type="text" name="fio" value="$fio" placeholder="ФИО"><br>
<input type="password" name="password" placeholder="Пароль"><br>
<a href="agents.php">Назад</a>
<input type="submit" name="regshop" value="Создать агента">
</form>
</div>
</div>
</body>
</html>
HTMLBLOCK;


?>