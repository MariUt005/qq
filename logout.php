<?php

session_start();
if (empty($_SESSION["login"])) {
    header("Location: index.php");
} else {
    $_SESSION["login"] = NULL;
    header("Location: index.php");
}
?>