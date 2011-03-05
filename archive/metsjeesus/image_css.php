<?php 
$picter->assign_pic(0, $_GET["pic_id"]);
?>
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
    echo "<li><a href=\"?page_id=$i\" title=\"$i. lehekülg\">$page[begin]-$page[end]</a></li>\n";
}
?>
</ul>
</div>

<div id="bigimage">
<?php 
$picter->make_medium($picter->active_picture); 
echo '<img src="'.$picter->active_picture["filename"].'" alt="'.$picter->active_picture["filename"].'" />';
?>

<!-- Siia vahele peaks käima ka eelmine ja järgmine pilt -->


<form action="<?php echo $vars["URL_self"]."?post=1&amp;pilt_id=".($pilt_id) ?>" method="post">
<p id="name"><label>Teie nimi:</label><input name="kellelt" type="text" size="40" /></p>
<p id="comment"><label>Kommentaar:</label><textarea name="sisu" cols="40" rows="7"></textarea></p>
<p id="submit"><input type="submit" name="Submit" value="VALMIS !" /></p>
</form>

</div>

<div id="footer">
<p>Copyright © by Metsjeesus</p>
</div>
    

</body>
</html>