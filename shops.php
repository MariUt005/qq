<?php
session_start();

if (empty($_SESSION["login"])) {
    header("Location: index.php");
}

if (strcmp($_SESSION['login'],'admin')) {
    header("Location: order.php");
}

require "db.php";

function delete_shop() {
    if (isset($_POST['shop_code'])) {
        $shop = R::findOne('shop', 'code = ?', array($_POST['shop_code']));
        R::trash($shop);
        $tochki = R::findAll('tochka', 'shop_code = ?', array($_POST['shop_code']));
        $tochki_codes = R::exportAll($tochki);
        for ($i = 0; $i < count($tochki_codes); $i++) {
            R::trashAll(R::findAll('access', 'tochka_code = ?', array($tochki_codes[$i]['tochka_code'])));
        }
        R::trashAll($tochki);
    }
    return NULL;
}
delete_shop();

print <<<HTMLBLOCK
<!DOCTYPE html>
<head>
<title>Магазины</title>
<link rel="stylesheet" href="main.css" >
</head>
<body>
<div id="main">
<div class="wrapper">

HTMLBLOCK;

print <<<HTMLBLOCK
<h1>Магазины</h1>
<a href="panel.php">Главная</a>
<a href="regshop.php">Регистрация магазина</a><div id="table">
<table class="table"  id="pagenavi"><thead>
<tr>
<th>Название магазина</th>
<th>Код магазина</th>
<th></th>
</tr>
</thead><tbody>
HTMLBLOCK;

$shops = R::getAll( 'SELECT * FROM shop' );
for ($i = 0; $i < count($shops); $i++) {
    $shop_name = $shops[$i]['name'];
    $shop_code = $shops[$i]['code'];
    print <<<HTMLBLOCK

        <tr>
            <td>$shop_name</td>
            <td>$shop_code</td>
            <td><form action="" method="POST">
        <input type="hidden" name="shop_code" value="$shop_code">
        <input type="submit" name="delete_shop" value="Удалить"></form></td>
        </tr>

HTMLBLOCK;
}
print <<<HTMLBLOCK
        </tbody>
        </table>
        </div>
        </div>
        </div>
</body>
</html>
HTMLBLOCK;

?>