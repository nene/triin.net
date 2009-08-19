<?php
require_once("mysqlconnect.php");
require_once("urlvars.php");

header("Content-type: application/rss+xml");


echo <<<EOHTML
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
    <title>Triinuleht - Viimased artiklid</title>
    <link>http://www.triin.net</link>
    <description>Triinulehe uudised</description>
    <language>et</language>

EOHTML;


$query="SELECT * FROM archive ORDER BY `date` DESC LIMIT 15";
$result = mysql_query($query);
while ($row = mysql_fetch_array($result))
{
    $address = "http://www.triin.net/".str_replace('-','/',$row['date'])."/".UrlVars::real2url($row['name']);
    $time = strtotime($row['date']);
    $time = date("D, j M Y H:i:s \G\M\T", $time);
    echo <<<EOHTML
<item>
    <title>$row[name]</title>
    <link>$address</link>
    <pubDate>$time</pubDate>
    <dc:creator>Rene Saarsoo</dc:creator>
</item>

EOHTML;

}
echo <<<EOHTML
</channel>
</rss>

EOHTML;
