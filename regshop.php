<?php
session_start();

if (empty($_SESSION["login"])) {
    header("Location: index.php");
}

if (strcmp($_SESSION['login'],'admin')) {
    header("Location: order.php");
}

require "db.php";
function regshop() {
    if (isset($_POST['shop_name'])) {
        $_COOKIE['shop_name'] = $_POST['shop_name'];
        $_COOKIE['shop_code'] = $_POST['shop_code'];
        if (empty($_POST['shop_name'])) {
            return "Введите название!";
        }
        if (empty($_POST['shop_code'])) {
            return "Введите код!";
        }
        $shop = R::findOne('shop', 'code = ?', array($_POST['shop_code']));
        if (! empty($shop)) {
            return "Такой магазин уже существует!";
        }
        $shop = R::dispense('shop');
        $shop->name = $_POST['shop_name'];
        $shop->code = $_POST['shop_code'];
        R::store($shop);

        $_COOKIE['shop_name'] = NULL;
        $_COOKIE['shop_code'] = NULL;

        header("Location: shops.php");
    } else {
        $_COOKIE['shop_name'] = NULL;
        $_COOKIE['shop_code'] = NULL;
    }
    return NULL;
}
$error = regshop();

print <<<HTMLBLOCK
<!DOCTYPE html>
<head>
<title>Новый магазин</title>
<link rel="stylesheet" href="main.css" >
</head>
<body>
<div id="main">
<div class="wrapper">
HTMLBLOCK;

$shop_name = isset($_COOKIE['shop_name']) ? $_COOKIE['shop_name'] : NULL;
$shop_code = isset($_COOKIE['shop_code']) ? $_COOKIE['shop_code'] : NULL;
print <<<HTMLBLOCK
<h1>Регистрация магазина</h1>

<span class="error">$error</span>
<form action="" method="POST">
<input type="text" name="shop_name" value="$shop_name" placeholder="Название"><br>
<input type="text" name="shop_code" value="$shop_code" placeholder="Код магазина"><br>
<a href="shops.php">Назад</a>
<input type="submit" name="regshop" value="Создать магазин">
</form>
</div>
</div>
</body>
</html>
HTMLBLOCK;


?>