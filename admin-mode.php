<?php 
require_once 'conf.php';
session_start();
function is_admin_mode() {
  return $_SESSION["admin"] == true && $_SESSION["user"] == ADMIN_USER;
}
?>
