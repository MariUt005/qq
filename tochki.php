<?php
session_start();

if (empty($_SESSION["login"])) {
    header("Location: index.php");
}

if (strcmp($_SESSION['login'],'admin')) {
    header("Location: order.php");
}

require "db.php";

function delete_tochka() {
    if (isset($_POST['tochka_code'])) {
        $shop = R::findOne('tochka', 'tochka_code = ?', array($_POST['tochka_code']));
        R::trashAll(R::findAll('access', 'tochka_code = ?', array($_POST['tochka_code'])));
        R::trash($shop);
    }
    return NULL;
}

delete_tochka();

print <<<HTMLBLOCK
<!DOCTYPE html>
<head>
<title>Торговые точки</title>
<link rel="stylesheet" href="main.css" >
</head>
<body>
<div id="main">
<div class="wrapper">
HTMLBLOCK;

if (isset($_GET['login'])) {
    $login = $_GET['login'];
    print <<<HTMLBLOCK
<h1>Торговые точки агента $login</h1>
<a href="panel.php">Главная</a>
<a href="regaccess.php">Добавить доступ</a>
<table>
<thead>
<tr>
<th>Название точки</th>
<th>Код точки</th>
<th>Код магазина</th>
<th></th>
<th></th>
</tr>
</thead><tbody>

HTMLBLOCK;

    $tochki_codes = R::exportAll(R::findAll('access', 'login = ?', array($_GET['login'])));
    $tochki = array();
    for ($i = 0; $i < count($tochki_codes); $i++) {
        array_push($tochki, R::exportAll(R::findAll('tochka', 'tochka_code = ?', array($tochki_codes[$i]['tochka_code']))));
    }
    for ($i = 0; $i < count($tochki); $i++) {
        $tochka_name = $tochki[$i][0]['name'];
        $tochka_code = $tochki[$i][0]['tochka_code'];
        $shop_code = $tochki[$i][0]['shop_code'];
        print <<<HTMLBLOCK
        <tr>
        <td>$tochka_name</td>
        <td>$tochka_code</td>
        <td>$shop_code</td>
        <td><form action="" method="POST">
        <input type="hidden" name="tochka_code" value="$tochka_code">
        <input type="submit" name="delete_tochka" value="Удалить">
        </form></td>
        <td><a href="agents.php?tochka_code=$tochka_code">Подключенные агенты</a></td>
</tr>
HTMLBLOCK;
    }
} else {

    print <<<HTMLBLOCK
<h1>Торговые точки</h1>
<a href="panel.php">Главная</a>
<a href="regtochka.php">Регистрация точки</a>
<table>
<thead>
<tr>
<th>Название точки</th>
<th>Код точки</th>
<th>Код магазина</th>
<th></th>
<th></th>
</tr>
</thead><tbody>

HTMLBLOCK;

    $tochki = R::getAll('SELECT * FROM tochka');
    for ($i = 0; $i < count($tochki); $i++) {
        $tochka_name = $tochki[$i]['name'];
        $tochka_code = $tochki[$i]['tochka_code'];
        $shop_code = $tochki[$i]['shop_code'];
        print <<<HTMLBLOCK
        <tr>
        <td>$tochka_name</td>
        <td>$tochka_code</td>
        <td>$shop_code</td>
        <td><form action="" method="POST">
        <input type="hidden" name="tochka_code" value="$tochka_code">
        <input type="submit" name="delete_tochka" value="Удалить">
        </form></td>
        <td><a href="agents.php?tochka_code=$tochka_code">Подключенные агенты</a></td>
</tr>
HTMLBLOCK;
    }
}
print <<<HTMLBLOCK
</tbody></table>
        
</div>
</div>
</body>
</html>
HTMLBLOCK;

?>