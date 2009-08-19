<?php
require_once("mysqlconnect.php");
require_once("document.php");

$document = new Document();
$document->SetTitle("Kontakt");
$document->AddMainMenu("Kontakt");
$document->AddSubMenu();

$chapter = <<<EOHTML
<h1>Kontakt</h1>

<div class="pilt">
<img src="/archive/mina.jpg" alt="Minu pilt" />
<p>Mina, oma eduka sportlaskarjääri tipphetkel?</p>
</div>


<p>No põhimõtteliselt, kui keegi väga soovib, siis võib ta ju 
mulle kirjutada ja joonistada. Aadress on igatahes nüüd
välja jagatud ja saab näha, kas sünnib sellest halba/head.
Ega must mingit head kirjasõpra vast ei tule, nii et parem
ärge selles suunas kohe proovima hakakegi.</p>

<p>Aga kui on midagi seoses sellesama Trinoloogialehega või
triinudega, siis see on kõik päris kindlasti alati teretulnud.</p>

<p>Seda pilti siin tuleb ühtlasi võtta kui hoiatust, et te
ei kipuks kuidagi pimesi minuga kohtuma, ja et te päris selgesti
näeksite, et mina ei kuulu triinude hulka.</p>

<p>Olge tublid!</p>

<ul>
<li>Haapsalu</li>
<li>Männi 9-3</li>
<li>Rene Saarsoo</li>
</ul>

EOHTML;

$document->AddBasicChapter($chapter, "Kontakt");

$document->Out();

?>