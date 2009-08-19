<?php
require_once("admin-mode.php");

$_SESSION["user"] = "";
$_SESSION["admin"] = false;
header("Location: /login.php");

?>