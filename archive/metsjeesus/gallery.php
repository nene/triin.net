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
    <table align="center" width="100%" cellspacing="1" cellpadding="0">
        <tr>
        <?php
        foreach($picter->active_gallery["page_pic"] as $i => $pic){
            $picter->make_thumb($pic);
            $picter->pic_info($pic, 0);
            
        ?>
            <td valign="top" align="center">
                <table bgcolor="#ffffff" width="<?php echo ($pic["thumb"]["default_width"]+20); ?>" height="<?php echo ($pic["thumb"]["default_height"]+20); ?>" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <a href="<?php echo "?pic_id=".$pic["id"]; ?>">
                                <img src="<?php echo $pic["thumb"]["filename"];?>"
                                    class="image"
                                    border="0"
                                    style="FILTER: alpha(opacity=50)"
                                    onmouseover="udu(this, 100, 5, 5)"
                                    onmouseout="udu(this, 50, 50, 15)"
                                    name="thumb_<?php echo $pic["filename"]; ?>"
                                    width="<?php echo $pic["thumb"]["imagesize"]["width"]; ?>"
                                    height="<?php echo $pic["thumb"]["imagesize"]["height"]; ?>"
                                    alt="<?php echo $pic["filename"]; ?>"
                                    title="Failinimi : <?php echo $pic["filename"]; ?>">
                            </a>
                        </td>
                    </tr>
                </table>
                <table bgcolor="#666666" valign="bottom" width="<?php echo ($pic["thumb"]["default_width"]+20); ?>" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="info" align="right">Kommentaare</td>
                        <td class="info" align="left">:<?php $picter->load_pic_comment($pic); echo $pic["comment_count"]; ?></td>
                    </tr>
                    <tr>
                        <td class="info" align="right">Klikke</td>
                        <td class="info" align="left">:<?php $picter->load_pic_counter($pic); echo $pic["counter_count"]; ?></td>
                    </tr>
                    <tr>
                        <td class="info" align="right">Failinimi</td>
                        <td class="info" align="left">:<?php echo $pic["filename"]; ?></td>
                    </tr>
                    <tr>
                        <td class="info" align="right">Suurus</td>
                        <td class="info" align="left">:<?php echo $pic["filesize"]["formatted"]; ?></td>
                    </tr>
                    <tr>
                        <td class="info" align="right">Dimensioonid</td>
                        <td class="info" align="left">:<?php echo $pic["imagesize"]["width"]; ?>x<?php echo $pic["imagesize"]["height"]; ?></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>
            <?php if($pic["row_break"]){ ?>
        </tr>
        <tr>
            <?php } ?>
        <?php } ?>
        <tr>
    </table>
    <table width="100%" cellspacing="1" cellpadding="0" border="1" bordercolor="#cccccc">
        <tr>
            <td bgcolor="#666666" align="center"><font color="#ffffff" size="2">Copyright &copy; by Metsjeesus</font></td>
        </tr>
    </table>
    </body>
    </html>