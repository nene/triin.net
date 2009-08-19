<?php
require_once("admin-mode.php");
require_once("mysqlconnect.php");
require_once("document.php");

if (!is_admin_mode()) {
  header("Location: /");
  exit();
}

$document = new Document();
$document->SetTitle("Admin: Lisamise tulemus");
$document->AddMainMenu();
$document->AddSubMenu();

$hash=sha1($_POST['pass']);

$query= "INSERT INTO `archive` 
( `id` , 
`name` , 
`address` , 
`date` , 
`next` , 
`previous` , 
`groupid` , 
`order` , 
`type` , 
`category` , 
`comments` ) 
VALUES (
'', 
'$_POST[name]', 
'$_POST[address]', 
CURDATE( ) , 
'0', 
'0', 
'0', 
'0', 
'$_POST[type]', 
'$_POST[category]', 
'$_POST[comments]'
);";    

mysql_query($query);
    
$chapter = <<<EOHTML
<h1>Admin: Lisamine õnnestus</h1>

<dl>
<dt>Nimi</dt><dd>$_POST[nimi]</dd>
<dt>Aadress</dt><dd>$_POST[address]</dd>
<dt>Tüüp</dt><dd>$_POST[type]</dd>
<dt>Kategooria</dt>$_POST[category]<dd></dd>
<dt>Kommentaarid</dt><dd>$_POST[comments]</dd>
</dl>

EOHTML;

$document->AddBasicChapter($chapter, "Admin:_Lisamise_tulemus");

$document->Out();

?>