<?php
require_once("admin-mode.php");
require_once("mysqlconnect.php");
require_once("document.php");

if (!is_admin_mode()) {
  header("Location: /");
  exit();
}

$document = new Document();
$document->SetTitle("Admin: Uue artikli lisamine");
$document->AddMainMenu();
$document->AddSubMenu();

$chapter = <<<EOHTML
<h1>Admin: Uue artikli lisamine</h1>

<form action="add-article.php" method="post">
<fieldset>
<legend>Nimed</legend>
<p><label for="af_name">Pealkiri</label>
<input type="text" name="name" id="af_name" /></p>

<p><label for="af_address">Aadress</label>
<input type="text" name="address" id="af_address" value="archive/" /></p>
</fieldset>


<fieldset>
<legend>Tüüp</legend>
<select name="type">
<option value="normal">normal</option>
<option value="standalone">standalone</option>
<option value="application/zip">application/zip</option>
<option value="application/pdf">application/pdf</option>
<option value="text/css">text/css</option>
</select>
</fieldset>


<fieldset>
<legend>Kategooria</legend>
<select name="category">
<option value="Üldine">Üldine</option>
<option value="HTML ja CSS">HTML ja CSS</option>
<option value="Kool">Kool</option>
<option value="Trinoloogia">Trinoloogia</option>
<option value="Laulud">Laulud</option>
<option value="Luuletused">Luuletused</option>
</select>
</fieldset>


<fieldset>
<legend>Kommentaaride lubamine</legend>
<ul>
<li><label><input type="radio" name="comments" value="Y" checked="checked" />Jah</label></li>
<li><label><input type="radio" name="comments" value="N" />Ei</label></li>
</ul>
</fieldset>


<input type="submit" value="Salvesta" />
</form>

EOHTML;

$document->AddBasicChapter($chapter, "Admin:_Uue_artikli_lisamine");

$document->Out();

?>