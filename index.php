<?php
require_once("mysqlconnect.php");
require_once("document.php");

$document = new Document();
$document->SetTitle("Trinoloogialeht");
$document->AddMainMenu("Hiljutine");
$document->AddSubMenu();

$query = "SELECT * FROM archive WHERE type='normal' ORDER BY date DESC LIMIT 3";
$result = mysql_query($query);

while($doc = mysql_fetch_array($result))
{
    $query = "SELECT COUNT(*) FROM comments WHERE articleid='$doc[id]'";
    $result2 = mysql_query($query);
    $com = mysql_fetch_array($result2);
    
    $url = '/'.str_replace('-','/',$doc['date']).'/'.UrlVars::real2url($doc['name']);
    
    if ($doc['comments']=='Y')
    {
        $url.='#kommentaarid';
    }
    
    $document->AddArchive($doc['address'],$com[0],$url,$doc['comments']);
}

$document->Out();

?>