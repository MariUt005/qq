<?php
session_start();

if (empty($_SESSION["login"])) {
    header("Location: index.php");
}

if (strcmp($_SESSION['login'],'admin')) {
    header("Location: order.php");
}

require "db.php";

function delete_access() {
    if (isset($_POST['tochka_code'])) {
        $access = R::findOne('access', 'tochka_code = ?', array($_POST['tochka_code']));
        R::trash($access);
    }
    return NULL;
}

function delete_agent() {
    if (isset($_POST['login'])){
        $agent = R::findOne('agents', 'login = ?', array($_POST['login']));
        R::trash($agent);
        $access = R::findAll('access', 'login = ?', array($_POST['login']));
        R::trashAll($access);
    }
}

delete_access();
delete_agent();

print <<<HTMLBLOCK
<!DOCTYPE html>
<head>
<title>Кредитные агенты</title>
<link rel="stylesheet" href="main.css" >
</head>
<body>
<div id="main">

<div class="wrapper">
HTMLBLOCK;


$agents = [];
if (isset($_GET['tochka_code'])) {
    $tochka_code = $_GET['tochka_code'];
    print <<<HTMLBLOCK
<h1>Кредитные агенты на торговой точке №$tochka_code</h1>
<a href="panel.php">Главная</a>
<a href="regaccess.php">Добавить доступ</a>
<table>
<thead>
<tr>
<th>ФИО</th>
<th>Логин</th>
<th></th>
</tr>
</thead><tbody>
HTMLBLOCK;

    $agents_logins = R::exportAll(R::findAll( 'access', 'tochka_code = ?', array($tochka_code)));
    for ($i = 0; $i < count($agents_logins); $i++) {
        array_push($agents, R::findOne('agents', 'login = ?', array($agents_logins[$i]['login'])));
    }
    for ($i = 0; $i < count($agents); $i++) {
        $login = $agents[$i]['login'];
        $fio = $agents[$i]['fio'];
        print <<<HTMLBLOCK
        <tr>
        <td><a href="tochki.php?login=$login" class="getmoreinfo">$fio</a></td>
        <td>$login</td>
        <td>
                <form action="" method="POST">
        <input type="hidden" name="login" value="$login">
        <input type="hidden" name="tochka_code" value="$tochka_code">
        <input type="submit" name="delete_access" value="Удалить доступ">
        </form>
</td>
</tr>

HTMLBLOCK;
    }
} else {
    print <<<HTMLBLOCK
<h1>Кредитные агенты</h1>
<a href="panel.php">Главная</a>
<a href="regagent.php">Добавить агента</a>
<table>
<thead>
<tr>
<th>ФИО</th>
<th>Логин</th>
<th></th>
</tr>
</thead><tbody>
HTMLBLOCK;
    $agents = R::getAll('SELECT * FROM agents');
    for ($i = 0; $i < count($agents); $i++) {
        $login = $agents[$i]['login'];
        $fio = $agents[$i]['fio'];
        print <<<HTMLBLOCK
        <tr>
        <td><a href="tochki.php?login=$login" class="getmoreinfo">$fio</a></td>
        <td>$login</td>
        <td>
             <form action="" method="POST">
        <input type="hidden" name="login" value="$login">
        <input type="submit" name="delete_agent" value="Удалить агента">
        </form>
</td>
</tr>
HTMLBLOCK;
    }
}
print <<<HTMLBLOCK
</tbody>
</table>
</div>
</div>
</body>
</html>
HTMLBLOCK;


?>