<?php 
$picter->assign_pic(0, $_GET["pic_id"]);
?>
<html>
        <head>
                <title>Metsjeesuse Pildialbum</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                <STYLE TYPE="text/css">
                <!--
                A { text-decoration: none; }
                A:link { color: #EEEEEE; }
                A:visited { color: #DDDDDD; }
                A:hover { color: #FFFFFF; text-decoration: underline; }
                .info {
                    font-family: Tahoma, Arial, Helvetica, sans-serif; 
                    font-size: 12px;
                    font-weight: bold;
                    color: #FFFFFF;
                    }
                .page {
                    font-family: Tahoma, Arial, Helvetica, sans-serif; 
                    font-size: 12px;
                    font-weight: bold;
                    background-color: #666666;
                    }
                .page_active {
                    font-family: Tahoma, Arial, Helvetica, sans-serif; 
                    font-size: 12px;
                    font-weight: bold;
                    background-color: #999999;
                    }
                -->
</STYLE><script>
                                pildid = new Object();
                                taimerid = new Object();
                        function udu(objekt, protsent, aeg, pilte){
                                if(!document.all){
                                        return;
                                        }
                                if(objekt != "[object]"){
                                        setTimeout("udu("+objekt+","+protsent+","+aeg+","+pilte+")",0);
                                        return;
                                        }
                                if(aeg<=0){
                                        objekt.filters.alpha.opacity=protsent;
                                        return;
                                        }
                                ajamuut=aeg/pilte;
                                protsmuut=(protsent-objekt.filters.alpha.opacity)/pilte;
                                objekt.filters.alpha.opacity+=protsmuut;
                                clearTimeout(taimerid[objekt.sourceIndex]);
                                pildid[objekt.sourceIndex]=objekt;
                                taimerid[objekt.sourceIndex]=setTimeout("udu(pildid["+objekt.sourceIndex+"],"+protsent+","+(aeg-ajamuut)+","+(pilte-1)+")",ajamuut);
                                }
                </script>
        </head>
        <body bgcolor="#333333">
<table width="100%" cellspacing="1" cellpadding="0" border="1" bordercolor="#cccccc">
    <tr>
           <td bgcolor="#666666" align="center"><font color="#ffffff" size="6">Metsjeesuse pildialbum</font></td>
    </tr>
</table>

<table align="center" cellspacing="1" cellpadding="0" border="1" bordercolor="#cccccc">
        <tr>
            <?php foreach($picter->active_gallery["page"] as $i => $page ){ ?>
            <td class="<?php if($page["open"]){ echo "page_active"; }else{ echo "page"; }?>"><b><a href="<?php echo "?page_id=".$i; ?>">
                <?php 
                    echo $page["begin"]."-".$page["end"];
                    ?>
                </a></b></td>
                <?php } ?>
    
        </tr>
    </table></br>
<?php $picter->make_medium($picter->active_picture); ?>
<table align="center" width="100%" cellspacing="1" cellpadding="0">
    <tr>
        <td align="center"><a href="<?php echo $vars["URL_self"].$vars["FILES"][$pilt_id-1]; ?>">
                        <img 
        src="<?php echo $picter->active_picture["filename"]; ?>" 
        width="<?php echo $picter->active_picture["medium"]["imagesize"]["width"]; ?>"
        height="<?php echo $picter->active_picture["medium"]["imagesize"]["height"]; ?>"
        border="0">
                </a>
        </td>
    </tr>
</table>
<table align="center" width="100%" cellspacing="1" cellpadding="0" border="1" bordercolor="#cccccc">
    <tr>
        <td align="center" width="<?php echo ($vars["thumb_laius"]+20); ?>">
            <?php if(($pilt_id-2)>0){?>
            <table align="center" valign="top" cellspacing="0" cellpadding="0" border="0" height="<?php echo ($vars["thumb_pikkus"]+20); ?>">
            <tr><td>
            <a href="<?php echo $vars["URL_self"]."?pilt_id=".($pilt_id-2) ?>">
               <img src="<?php echo $vars["URL_self"].$thumb_pic($vars["FILES"][$pilt_id-3]); ?>" border="0">
            </a>
            </td></tr>
            </table>
            <table valign="bottom" cellspacing="0" cellpadding="0" border="0">
            <tr><td>
                 <a href="<?php echo $vars["URL_self"]."?pilt_id=".($pilt_id-2) ?>">
                 ÜLEEELMINE
                 </a>
            </td></tr>
            </table><?php } ?>
        </td>


        <td align="center" width="<?php echo ($vars["thumb_laius"]+20); ?>" valign="top">
            <?php if(($pilt_id-1)>0){?>
            <table align="center" valign="top" cellspacing="0" cellpadding="0" border="0" height="<?php echo ($vars["thumb_pikkus"]+20); ?>">
            <tr><td><a href="<?php echo $vars["URL_self"]."?pilt_id=".($pilt_id-1) ?>">
               <img src="<?php echo $vars["URL_self"].$thumb_pic($vars["FILES"][$pilt_id-2]); ?>" border="0">
            </a>
            </td></tr>
            </table>
            <table valign="bottom" cellspacing="0" cellpadding="0" border="0">
            <tr><td>
            <a href="<?php echo $vars["URL_self"]."?pilt_id=".($pilt_id-1) ?>">
               EELMINE
            </a>
            </td></tr>
            </table><?php } ?>
        </td>

        <td align="center" width="<?php echo ($vars["thumb_laius"]+20); ?>">
            <?php if(($pilt_id)<$vars["FILES_COUNT"]){?>
            <table align="center" valign="top" cellspacing="0" cellpadding="0" border="0" height="<?php echo ($vars["thumb_pikkus"]+20); ?>">
            <tr><td><a href="<?php echo $vars["URL_self"]."?pilt_id=".($pilt_id+1) ?>">
               <img src="<?php echo $vars["URL_self"].$thumb_pic($vars["FILES"][$pilt_id]); ?>" border="0">
            </a>
            </td></tr>
            </table>
            <table valign="bottom" cellspacing="0" cellpadding="0" border="0">
            <tr><td>
            <a href="<?php echo $vars["URL_self"]."?pilt_id=".($pilt_id+1) ?>">
               JÄRGMINE
            </a>
            </td></tr>
            </table><?php } ?>
        </td>


        <td align="center" width="<?php echo ($vars["thumb_laius"]+20); ?>" valign="top">
            <?php if(($pilt_id+1)<$vars["FILES_COUNT"]){?>
            <table align="center" valign="top" cellspacing="0" cellpadding="0" border="1" height="<?php echo ($vars["thumb_pikkus"]+20); ?>">
            <tr><td><a href="<?php echo $vars["URL_self"]."?pilt_id=".($pilt_id+2) ?>">
               <img src="<?php echo $vars["URL_self"].$thumb_pic($vars["FILES"][$pilt_id+1]); ?>" border="0">
            </a>
            </td></tr>
            </table>
            <table valign="bottom" cellspacing="0" cellpadding="0" border="1">
            <tr><td>
            <a href="<?php echo $vars["URL_self"]."?pilt_id=".($pilt_id+2) ?>">
               ÜLEJÄRGMINE
            </a>
            </td></tr>
            </table><?php } ?>
        </td>

    </tr>
</table>
<br>
<form action="<?php echo $vars["URL_self"]."?post=1&pilt_id=".($pilt_id) ?>" method="post">
<table width="450" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Teie
        nimi:</font></div></td>
    <td>
        <input name="kellelt" type="text" size="40">
    </td>
  </tr>
  <tr>
    <td valign="top"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Kommentaar:</font></div></td>
    <td>
        <textarea name="sisu" cols="40" rows="7" wrap="VIRTUAL"></textarea>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
        <input type="submit" name="Submit" value="VALMIS !">
    </td>
  </tr>
</table>
</form>


<table width="100%" cellspacing="1" cellpadding="0" border="1" bordercolor="#cccccc">
    <tr>
           <td bgcolor="#666666" align="center"><font color="#ffffff" size="2">Copyright &copy; by Metsjeesus</font></td>
    </tr>
</table>
</body>
</html>