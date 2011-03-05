<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Metsjeesuse pildialbum</title>
<link rel="stylesheet" type="text/css" href="metsjeesus.css" />
</head>
<body>

<h1>Metsjeesuse pildialbum</h1>

<div id="nav">
<ul>
<?php 
foreach($picter->active_gallery["page"] as $i => $page )
{
    if ($page["open"])
    { 
        echo "<li><strong title=\"$i. lehekülg\">$page[begin]-$page[end]</strong></li>\n";
    }else{ 
        echo "<li><a href=\"?page_id=$i\" title=\"$i. lehekülg\">$page[begin]-$page[end]</a></li>\n";
    }
}
?>
</ul>
</div>

<div id="gallery">

<?php
foreach($picter->active_gallery["page_pic"] as $i => $pic)
{
    $picter->make_thumb($pic);
    $picter->pic_info($pic, 0);
    if ($pic["thumb"]["imagesize"]["width"]>$pic["thumb"]["imagesize"]["height"])
    {
        $orientation="ls";
    }else{
        $orientation="pt";
    }
    $picter->load_pic_comment($pic);
    $picter->load_pic_counter($pic);
    $thumb=$pic["thumb"];
    $filesize=$pic["filesize"]["formatted"];
    $imagesize=$pic["imagesize"];
echo <<<EOHTML
<div class="thumb $orientation">
  <a href="?pic_id=$pic[id]" title="Failinimi : $pic[filename]"><img src="$thumb[filename]" alt="$pic[filename]" /></a>
  <dl>
    <dt>Kommentaare</dt><dd>$pic[comment_count]</dd>
    <dt>Klikke</dt><dd>$pic[counter_count]</dd>
    <dt>Failinimi</dt><dd>$pic[filename]</dd>
    <dt>Suurus</dt><dd>$filesize</dd>
    <dt>Dimensioonid</dt><dd>$imagesize[width] &times; $imagesize[height]</dd>
  </dl>
</div>

EOHTML;
}
?>

</div>

<div id="footer">
<p>Copyright © by Metsjeesus</p>
</div>
    

</body>
</html>