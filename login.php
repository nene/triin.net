<?php
require_once("admin-mode.php");
require_once("document.php");

// When user enters correct information, log in
if (isset($_POST["user"]) && isset($_POST["pass"])) {
  if ($_POST["user"] == ADMIN_USER && md5($_POST["pass"]) == ADMIN_PASS) {
    $_SESSION["user"] = $_POST["user"];
    $_SESSION["admin"] = true;
  }
}

$document = new Document();
$document->SetTitle("Admin: Login");
$document->AddMainMenu();
$document->AddSubMenu();

$login_page = <<<EOHTML
<h1>Admin: Login</h1>

<form action="login.php" method="post">
<fieldset>
<legend>Autentimine</legend>
<p><label for="af_pass">Kasutaja</label>
<input type="text" name="user" id="af_user" /></p>

<p><label for="af_pass">Parool</label>
<input type="password" name="pass" id="af_pass" /></p>
</fieldset>

<input type="submit" value="Sisene" />
</form>

EOHTML;

$logout_link = <<<EOHTML
<h1>Admin: Login</h1>

<p>Oled sisse logitud. <a href="logout.php">Logi välja.</a></p>

<ul>
<li><a href="admin.php">Lisa artikkel.</a></li>
<li><a href="latest-comments.php">Vaata viimaseid kommentaare.</a></li>
</ul>

EOHTML;


$document->AddBasicChapter(is_admin_mode() ? $logout_link : $login_page, "Admin:_Login");

$document->Out();

?>