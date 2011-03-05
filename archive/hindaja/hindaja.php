<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Hindaja</title>
  <link rel="stylesheet" type="text/css" href="hindaja.css" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Kogutud andmed:</h1>
<?php
$file = fopen ("http://$_GET[site]", "r");

$pilt_kujunduselemendina=0;
$puudub_alt=0;
$tabelid=0;
$iframed=0;
$framesetid=0;
$brid=0;

if (!$file)
{
   echo "<p>Unable to open remote file.</p>\n";
}
else
{
    while (!feof ($file))
    {
        $line = fgets ($file, 1024);
        /* This only works if the title and its tags are on one line */
        if (preg_match("/<title>(.*)<\/title>/", $line, $out))
        {
            $title = $out[1];
        }
        if (preg_match("/<img[^<>]+>/i", $line, $out))
        {
            preg_match("/<img[^<>]+src=[\"']([^\"'<>]*)[\"'][^<>]*>/i", $line, $src);
            if (preg_match("/<img[^<>]+alt=[\"']([^\"'<>]*)[\"'][^<>]*>/i", $line, $alt))
            {
                if (strlen($alt[1])==0)
                {
                    $pilt_kujunduselemendina++;
                }
            }
            else
            {
                $puudub_alt++;
            }
        }
        if (preg_match("/<table/i", $line, $out))
        {
            $tabelid++;
        }
        if (preg_match("/<iframe/i", $line, $out))
        {
            $iframed++;
        }
        if (preg_match("/<frameset/i", $line, $out))
        {
            $framesetid++;
        }
        if (preg_match("/<br/i", $line, $out))
        {
            $brid++;
        }
    }
    fclose($file);
}

echo "<p>Lehe pealkiri: \"$title\".</p>\n";
echo "<p>$pilt_kujunduselemendina pilti kujunduselemendina.</p>\n";
echo "<p>$puudub_alt pildil puudub alternatiivtekst.</p>\n";
echo "<p>$tabelid tabelit.</p>\n";
echo "<p>$iframed iframe.</p>\n";
echo "<p>$framesetid frameset'i.</p>\n";
echo "<p>$brid br-i.</p>\n";

?>
</body>
</html>
