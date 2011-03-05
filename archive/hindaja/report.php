<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Raport</title>
  <link rel="stylesheet" type="text/css" href="hindaja.css" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Raport</h1>

<?php
$report['kirjeldus']['not_valid'] = "See lehekülge ei valideeru!";
$report['fleim']    ['not_valid'] = "Esiteks peab lehekülg valideeruma! Alles seejärel saab edasi rääkida.";
$report['soovitus'] ['not_valid'] = "";

$report['kirjeldus']['frames'] = "Leheküljel kasutatakse raame / freime.";
$report['fleim']    ['frames'] = "Raamid on saatanast - loobu neist kohe!";
$report['soovitus'] ['frames'] = "Soovitavalt kasvõi include-i headerid PHP-ga või kui see pole võimalik, siis copy-paste nad igale lehele; see ei tohiks väikese lehe puhul eriline vaev olla.";

$report['kirjeldus']['tables'] = "Kujundus on tehtud kasutades tabeleid.";
$report['fleim']    ['tables'] = "Tabelitega kujundus kuulub minevikku - kasuta CSS-i!";
$report['soovitus'] ['tables'] = "";



$report['kirjeldus']['no_doctype'] = "DOCTYPE on määramata.";
$report['fleim']    ['no_doctype'] = "DOCTYPE peab olema! See on kohustuslik!";
$report['soovitus'] ['no_doctype'] = "Soovitan XHTML 1.0 Strict.";

$report['kirjeldus']['no_charset'] = "Characterset on määramata.";
$report['fleim']    ['no_charset'] = "Kui sul characterset määratud pole, siis ei tea keegi kur*di brauser, mis keeles su tekst kirjutatud võib olla.";
$report['soovitus'] ['no_charset'] = "Eesti keele ametlik Charset on iso-8859-15.";

$report['kirjeldus']['no_alt'] = "Piltidel puudub alternatiivtekst";
$report['fleim']    ['no_alt'] = "Alternatiivtekst peab olema!";
$report['soovitus'] ['no_alt'] = "Kui pilt on kujunduselement, siis pane alt=\"\"";

$report['kirjeldus']['no_type'] = "Script elemendil puudub parameeter type.";
$report['fleim']    ['no_type'] = "Kui sa skripti tüüpi ei määra, siis brauser ju ei tea, mis x-scripti sa kasutad. Ja language=\"blablaba\" pole mingi näitaja.";
$report['soovitus'] ['no_type'] = "script type=\"text/javascript\"";

$report['kirjeldus']['no_height'] = "Tabelile on määratud height-atribuut.";
$report['fleim']    ['no_height'] = "Tabelil pole height-atribuuti! Kuidas te sellest ükskord aru ei saa!";
$report['soovitus'] ['no_height'] = "Height on olemas näiteks elemendil td, kasuta seda.";



$report['kirjeldus']['bold_tag'] = "b ja i elemendi kasutamine.";
$report['fleim']    ['bold_tag'] = "b ja i on aegunud!";
$report['soovitus'] ['bold_tag'] = "Kasuta b asemel strong ning i asemel em.";

$report['kirjeldus']['underline_tag'] = "Vananenud elementide kasutamine.";
$report['fleim']    ['underline_tag'] = "Igasuguste u, s, big, small, tt jne tagide aeg on ammu möödas!";
$report['soovitus'] ['underline_tag'] = "Teksti kujundamise jaoks kasuta CSS-i.";

$report['kirjeldus']['blink_tag'] = "Kasutatakse üht jubedat tag-i mille nime ma ei soovi suhu võtta.";
$report['fleim']    ['blink_tag'] = "AAAAAARRRRGGGHHH!!! Mida mu silmad peavad nägema!!! Koristage need BLINKid ja MARQUEEd ära!!!";
$report['soovitus'] ['blink_tag'] = "Igasugune vilkumine ja liikumine paluks leheküljelt eemaldada.";

$report['kirjeldus']['font_tag'] = "font-tagi kasutamine.";
$report['fleim']    ['font_tag'] = "font-tag on saatanast! Roogi see oma koodist välja!";
$report['soovitus'] ['font_tag'] = "Teksti saab väga edukalt ja palju paremini kujundada CSS-ga.";

$report['kirjeldus']['center_tag'] = "center-tagi kasutamine.";
$report['fleim']    ['center_tag'] = "center-tagi aeg on ammu möödas! reg_replace(\"&lt;/?[Cc][Ee][Nn][Tt][Ee][Rr]&gt;\", \"\", *.html);";
$report['soovitus'] ['center_tag'] = "Teksti keskele joondamiseks kasuta CSS-i.";

$report['kirjeldus']['iframe_tag'] = "iframe-ide kasutamine.";
$report['fleim']    ['iframe_tag'] = "iframe on üks kõige jubedamaid asju! Loobuge sellest!";
$report['soovitus'] ['iframe_tag'] = "Tee dünaamiline leht või kopi-pasteeri, aga mitte iframe.";



$report['kirjeldus']['nbsp_overuse'] = "Teksti paigutamiseks kasutatakse tühikuid.";
$report['fleim']    ['nbsp_overuse'] = "nbsp-sid võib olla vaid üks korraga! Neid ei kasutata teksti paigutamiseks!";
$report['soovitus'] ['nbsp_overuse'] = "Tühja ruumi loomiseks kasuta sobivaid html-i elemente või siis võta appi CSS.";

$report['kirjeldus']['break_overuse'] = "Liiga palju br elemente.";
$report['fleim']    ['break_overuse'] = "br võib olla väga hea element, ent sellel leheküljel on ta saatanast!";
$report['soovitus'] ['break_overuse'] = "tekstilõikude eraldamiseks kasutatakse paragrahve (elementi p).";

$report['kirjeldus']['hr_overuse'] = "Liialt palju hr elemente.";
$report['fleim']    ['hr_overuse'] = "Mõttetud horisontaaljoonte üleküllus - jube, lihtsalt jube...";
$report['soovitus'] ['hr_overuse'] = "hr-ide asemel kasuta parem CSS-i võimalust määrata tekstile äärejooned.";



$report['kirjeldus']['style_tag'] = "Stiilid on html faili sees.";
$report['fleim']    ['style_tag'] = "Mis mõte nende stiilide kokkukogumisel on, kui nad ikkagi paigutatakse html-faili sisse?";
$report['soovitus'] ['style_tag'] = "Stiililehed on soovitav siiski linkida välise failina.";

$report['kirjeldus']['inline_style'] = "Kasutatakse inline-stiile.";
$report['fleim']    ['inline_style'] = "Inline stiilid on täpselt sama hea kui font-tagide kasutamine - ehk siis, see on saatanast!";
$report['soovitus'] ['inline_style'] = "Stiilid paluks ikkagi ainult eraldi failis.";



$report['kirjeldus']['invisible_text'] = "Tekst on taustaga peaaegu ühte värvi.";
$report['fleim']    ['invisible_text'] = "Ma ei näe mitte midagi!!!";
$report['soovitus'] ['invisible_text'] = "Teksti värv peab moodustama taustaga kontrasti.";

$report['kirjeldus']['mystery_meat_navigation'] = "Menüü on segane ja arusaamatu.";
$report['fleim']    ['mystery_meat_navigation'] = "Selline navigatsioon on nagu pudru ja kapsad - mitte midagi ei mõista.";
$report['soovitus'] ['mystery_meat_navigation'] = "Navigeerimine olgu ikkagi lihtne ja selge - parim vahend selleks on selge tekst, mitte kirevad ja ebamäärased pildid.";

$report['kirjeldus']['invisible_links'] = "Lingid on ülejäänud tekstist eristamatud.";
$report['fleim']    ['invisible_links'] = "Hei! Kas siin lehel on kusagil lingid? Mina neid küll ei näe.";
$report['soovitus'] ['invisible_links'] = "Lingid peavad olema ülejäänud tekstist selgelt eristuvad - soovitatavalt värvilised ning allajoonitud.";

$report['kirjeldus']['fake_links'] = "Tekstis on lõike, mis liialt meenutavad linke, kuigi nad seda pole.";
$report['fleim']    ['fake_links'] = "Buu... ma proovisin klikkida mingil asjal, aga selgus et see polnudki link... Urrr...";
$report['soovitus'] ['fake_links'] = "Värvilist (eriti sinist) ning allajoonitud teksti tuleks võimaluste piires vältida - see meenutab liialt palju linke.";

$report['kirjeldus']['self_links'] = "Lehekülg on lingitud iseendaga.";
$report['fleim']    ['self_links'] = "Mis mõte on sellel, et ma pääsen leheküljel lingi kaudu sellele samale lehele?";
$report['soovitus'] ['self_links'] = "Leht ei tohiks iseennast linkida - see toob ainult segadust.";

$report['kirjeldus']['where_am_i'] = "Puudub selge tagasiside selle kohta, millisel alamleheküljel viibid.";
$report['fleim']    ['where_am_i'] = "Sellel leheküljel tunnen end eksinuna - ma ei saa kuidagi aru kuskohas ma viibin.";
$report['soovitus'] ['where_am_i'] = "Navigatsiooni parandaks kõvasti, kui näiteks see link, mis menüüs viitab hetkel aktiivsele leheküljele, oleks esitatud rõhutatuna.";

foreach ($_POST as $Key => $Value)
{
    //echo $Key.' = '.$Value.'<br />';
    
    if ($Key != 'kirjeldus' && $Key != 'fleim' && $Key != 'soovitus' && $Value=='on'){
        echo "<p>\n";
        if ($_POST['kirjeldus']=='on'){
            echo $report['kirjeldus'][$Key]."\n";
        }
        if ($_POST['fleim']=='on'){
            echo $report['fleim'][$Key]."\n";
        }
        if ($_POST['soovitus']=='on'){
            echo $report['soovitus'][$Key]."\n";
        }
        echo "</p>\n";
    }
}
?>

</body>
</html>
