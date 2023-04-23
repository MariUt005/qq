<?php
session_start();

require "db.php";



function signin() {
	if (isset($_POST['login'])) {
		$_COOKIE['login'] = $_POST['login'];
		$_COOKIE['password'] = $_POST['password'];
		if (empty($_POST['login'])) {
			return "Введите логин!";
		}
		if (empty($_POST['password'])) {
			return "Введите пароль!";
		}
		require "config.php";
		if ($_POST["login"] == $admin) {
			if (! password_verify($_POST["password"], $pass)) {
				return "Логин и/или пароль неверный!";
			}
			$_SESSION['login'] = $admin;
		} else {
			$agent = R::findOne('agents', 'login = ?', array($_POST['login']));
			if (empty($agent)) {
				return "Логин и/или пароль неверный!";
			}
			if (! password_verify($_POST['password'], $agent->password)) {
				return "Логин и/или пароль неверный!";
			}
		
			$_SESSION['login'] = $agent->login;
		}
		$_COOKIE['login'] = NULL;
		$_COOKIE['password'] = NULL;
		
		header("Location: panel.php");
	} else {
		$_COOKIE['login'] = NULL;
		$_COOKIE['password'] = NULL;
	}
	return NULL;
}

if (isset($_SESSION['login'])) {
	header("Location: panel.php");
}

$error = signin();

print <<<HTMLBLOCK
<!DOCTYPE html>
<head>
<title>Вход</title>
<link rel="stylesheet" href="main.css" >
</head>
<body>
<div id="main">
<div class="wrapper">
HTMLBLOCK;

$login = isset($_COOKIE['login']) ? $_COOKIE['login'] : NULL;
$password = isset($_COOKIE['password']) ? $_COOKIE['password'] : NULL;
print <<<HTMLBLOCK
		<h1>Вход</h1>
		<span class="error">$error</span>
		<form action="" method="POST">
			<input type="text" name="login" placeholder="Login" class="reg" value="$login"><br>
			<input type="password" name="password" placeholder="Пароль" class="reg" value="$password"><br>
			<input type="submit" name="signin" value="Войти" class="do_reg">
		</form>
</div>
</div>
</body>
</html>
HTMLBLOCK;
?>
