<?php
require_once("mysqlconnect.php");
require_once("document.php");

$document = new Document();
$document->SetTitle("Teadmiseks");
$document->AddMainMenu("Teadmiseks");
$document->AddSubMenu();

$document->AddArchive("archive/kirjutised/teadmiseks.html");

$document->Out();

?>