<?php
session_start();

if (empty($_SESSION["login"])) {
    header("Location: index.php");
}

if (strcmp($_SESSION['login'],'admin')) {
    header("Location: order.php");
}

require "db.php";
function regtochka() {
    if (isset($_POST['tochka_name'])) {
        $_COOKIE['tochka_name'] = $_POST['tochka_name'];
        $_COOKIE['tochka_code'] = $_POST['tochka_code'];
        if (empty($_POST['tochka_name'])) {
            return "Введите название!";
        }
        if (empty($_POST['tochka_code'])) {
            return "Введите код точки!";
        }
        if (empty($_POST['shop_code'])) {
            return "Введите код магазина!";
        }
        $tochka = R::findOne('tochka', 'tochka_code = ?', array($_POST['tochka_code']));
        if (! empty($tochka)) {
            return "Такая точка уже существует!";
        }
        $shop = R::findOne('shop', 'code = ?', array($_POST['shop_code']));
        if (empty($shop)) {
            return "Такого магазина не существует!";
        }
        $tochka = R::dispense('tochka');
        $tochka->name = $_POST['tochka_name'];
        $tochka->tochka_code = $_POST['tochka_code'];
        $tochka->shop_code = $_POST['shop_code'];
        R::store($tochka);

        $_COOKIE['tochka_name'] = NULL;
        $_COOKIE['tochka_code'] = NULL;

        header("Location: tochki.php");
    } else {
        $_COOKIE['tochka_name'] = NULL;
        $_COOKIE['tochka_code'] = NULL;
    }
    return NULL;
}


$error = regtochka();

print <<<HTMLBLOCK
<!DOCTYPE html>
<head>
<title>Регистрация точки</title>
<link rel="stylesheet" href="main.css" >
</head>
<body>
<div id="main">
<div class="wrapper">
HTMLBLOCK;

$tochka_name = isset($_COOKIE['tochka_name']) ? $_COOKIE['tochka_name'] : NULL;
$tochka_code = isset($_COOKIE['tochka_code']) ? $_COOKIE['tochka_code'] : NULL;
print <<<HTMLBLOCK
<h1>Регистрация точки</h1>

<span class="error">$error</span>
<form action="" method="POST">
<input type="text" name="tochka_name" value="$tochka_name" placeholder="Название"><br>
<input type="text" name="tochka_code" value="$tochka_code" placeholder="Код точки"><br>
<label>Код магазина</label>
<select name="shop_code">
HTMLBLOCK;
$shops = R::getAll('SELECT * FROM shop');
for ($i = 0; $i < count($shops); $i++) {
    print "<option value=".$shops[$i]['code'].">".$shops[$i]['name']."</option>";
}
print <<<HTMLBLOCK
</select><br><br>
<a href="tochki.php">Назад</a>
<input type="submit" name="regshop" value="Создать точку">
</form>
</div>
</div>
</body>
</html>
HTMLBLOCK;


?>