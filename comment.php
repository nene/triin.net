<?php
require_once('commentator.php');
require_once('document.php');
require_once('urlvars.php');


foreach ($_POST as $key => $value)
{
    $_POST[$key] = stripslashes($value);
}

$document = new Document();
$id=(int)$_POST['id'];

if ($_POST['submit']=='Eelvaade')
{
    $document->SetTitle("Kommentaari eelvaade");
    $send = false;
}else
{
    $send = true;
}

$commentator = new Commentator($_POST);
if ($commentator->Parse())
{
    $document->AddComments($id, 'after', $_POST, $commentator->mFormattedComment);
}else
{
    $document->SetTitle("Vigane kommentaar!");
    $document->AddComments($id, 'after', $_POST, '', $commentator->mError);
    $send = false;
}


if (!$send)
{
    $document->AddMainMenu();
    $document->AddSubMenu();
    $query = "SELECT address FROM archive WHERE id='$id'";
    $result = mysql_query($query);
    if (mysql_num_rows($result)>0)
    {
        $doc = mysql_fetch_array($result);
        $document->AddArchive($doc['address']);
    }else{
        $document->SetTitle("Oi oi oi!");
        $document->AddComments($id, 'after', $_POST, '', "Seda dokumenti mida te tahtsite kommenteerida kahjuks pole.");
    }
}else
{
    $query = "SELECT * FROM archive WHERE id='$id'";
    $result = mysql_query($query);
    if (mysql_num_rows($result)>0)
    {
        $doc = mysql_fetch_array($result);
        if ($doc['comments']=='Y')
        {
            $query = $commentator->GetQuery();
            $result = mysql_query($query);
            header("Location: /".str_replace('-','/',$doc['date']).'/'.UrlVars::real2url($doc['name']));
            exit;
        }else
        {
            $document->SetTitle("Oi oi oi!");
            $document->AddComments($id, 'after', $_POST, '', "Seda dokumenti kahjuks ei saa kommenteerida.");
            $document->AddArchive($doc['address']);
        }
    }else{
        $document->SetTitle("Oi oi oi!");
        $document->AddComments($id, 'after', $_POST, '', "Seda dokumenti mida te tahtsite kommenteerida kahjuks pole.");
    }
}

$document->Out();
?>