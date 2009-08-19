<?php
require_once("mysqlconnect.php");
require_once("document.php");

$document = new Document();
$document->SetTitle("Looming");
$document->AddMainMenu("Looming");
$document->AddSubMenu();


$chapter = "<h1>Looming</h1>\n";

$query = "SELECT * FROM archive WHERE category='Luuletused' OR category='Laulud' AND `order`=0 ORDER BY category, date DESC, name";
$result = mysql_query($query);

while($doc = mysql_fetch_array($result))
{
    if ($doc['category']!=$old_category)
    {
        if (strlen($old_category)!=0)
        {
            $chapter.="</ul>\n";
        }
        $chapter.= "<h2>$doc[category]</h2>\n";
        $chapter.= "<ul>\n";
        $old_category = $doc['category'];
    }
    
    $address = '/'.str_replace('-','/',$doc['date']).'/'.UrlVars::real2url($doc['name']);
    
    if ($doc['type']=='normal')
    {
        $class = '';
    }elseif($doc['type']=='standalone')
    {
        $class = ' class="standalone"';
    }elseif($doc['type']=='text/css')
    {
        $class = ' class="css"';
    }else
    {
        $class = ' class="file"';
    }
    
    $chapter.= "<li$class><a href=\"$address\">$doc[name]</a></li>\n";
}
$chapter.= "</ul>\n";



$document->AddBasicChapter($chapter, "Looming");


$document->Out();

?>