<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Hindaja</title>
  <link rel="stylesheet" type="text/css" href="hindaja.css" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<h1>Veebilehe hindamise abiline</h1>

<form action="report.php" method="post">

<h2>Üldised vead</h2>
<p><label><input type="checkbox" name="not_valid" />Lehekülg ei valideeru</label>
<label><input type="checkbox" name="frames" />Lehekülg kasutab raame (freime)</label>
<label><input type="checkbox" name="tables" />Kujundus on tehtud kasutades tabeleid</label></p>

<h2>Kui ei valideeru</h2>
<p>Märgi millised mittevalideerumisega seotud probleemid leheküljel esinevad:</p>
<p><label><input type="checkbox" name="no_doctype" /><strong>DOCTYPE</strong> on määramata</label>
<label><input type="checkbox" name="no_charset" /><strong>Characterset</strong> on määramata</label>
<label><input type="checkbox" name="no_alt" /><strong>alt</strong>ernatiivtekst puudub</label>
<label><input type="checkbox" name="no_type" />script elemendil on atribuut <strong>type</strong> määramata</label>
<label><input type="checkbox" name="no_height" />tabelile on määratud atribuut <strong>height</strong></label></p>

<h2>Vananenud elemendid</h2>
<p>Märgi, kas leheküljel kasutatakse mõnda järgnevatest html-i elementidest:</p>
<p><label><input type="checkbox" name="bold_tag" />b, i</label>
<label><input type="checkbox" name="underline_tag" />u, s, strike, tt, big, small</label>
<label><input type="checkbox" name="blink_tag" />blink, marquee</label>
<label><input type="checkbox" name="font_tag" />font</label>
<label><input type="checkbox" name="center_tag" />center</label>
<label><input type="checkbox" name="iframe_tag" />iframe</label></p>

<h2>Ülekasutus</h2>
<p>Märgi, kas leheküljel kasutatakse <strong>ohtralt</strong> järgmisi elemente:</p>
<p><label><input type="checkbox" name="nbsp_overuse" />&amp;nbsp;</label>
<label><input type="checkbox" name="break_overuse" />br</label>
<label><input type="checkbox" name="hr_overuse" />hr</label></p>

<h2>Stiilide valekasutus</h2>
<p><label><input type="checkbox" name="style_tag" />stiilid asuvad <strong>style</strong> elementide vahel</label>
<label><input type="checkbox" name="inline_style" />kasutatakse inline stiile</label></p>

<h2>Ligipääsetavuse probleemid</h2>
<p><label><input type="checkbox" name="invisible_text" />tekst on taustaga peaaegu ühte värvi</label>
<label><input type="checkbox" name="mystery_meat_navigation" />menüü koosneb piltidest, mille tähendus on segane või millel olev tekst on raskesti loetav</label>
<label><input type="checkbox" name="invisible_links" />lingid on eristamatud ülejäänud tekstist (allajoonimata või sama värvi)</label>
<label><input type="checkbox" name="fake_links" />lehel on allajoonitud või siniseksvärvitud teksti, mis aga pole link</label>
<label><input type="checkbox" name="self_links" />lehekülg lingib iseennast</label>
<label><input type="checkbox" name="where_am_i" />lehekülg ei anna selget tagasisidet selle kohta, millisel alamlehel sa viibid</label></p>

<h2>Raporti sisu</h2>
<p>Siin märgi ära, millist sisu raportisse soovid:</p>
<p><label><input type="checkbox" name="kirjeldus" />Probleemi kirjeldus</label>
<label><input type="checkbox" name="fleim" />Fleim selle jubeda koodi aadressil :)</label>
<label><input type="checkbox" name="soovitus" />Konstruktiivne soovitus, mida ette võtta probleemi lahendamiseks</label></p>


<p><input type="submit" value="Koosta raport" /></p>

</form>

</body>
</html>
