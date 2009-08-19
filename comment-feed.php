<?php
require_once("mysqlconnect.php");
require_once("urlvars.php");

header("Content-type: application/rss+xml");


echo <<<EOHTML
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
<channel>
    <title>Triinuleht - Viimased kommentaarid</title>
    <link>http://www.triin.net</link>
    <description>Triinulehe uudised</description>
    <language>et</language>

EOHTML;


$query=<<<EOSQL
SELECT archive.name AS articlename, comments.name AS author, datetime, date, text
FROM comments, archive
WHERE comments.articleid = archive.id
ORDER BY `datetime` DESC 
LIMIT 15
EOSQL;

$result = mysql_query($query);
while ($row = mysql_fetch_array($result))
{
    $address = "http://www.triin.net/".str_replace('-','/',$row['date'])."/".UrlVars::real2url($row['articlename']);
    $text = strip_tags($row['text']);
    if (strlen($text)>100)
    {
        $text = substr($text,0,97)."...";
    }
    $time = strtotime($row['datetime']);
    $time = date("D, j M Y H:i:s \G\M\T", $time);
    
    echo <<<EOHTML
<item>
    <title>$row[articlename]</title>
    <link>$address#kommentaarid</link>
    <description>$row[author]: $text</description>
    <pubDate>$time</pubDate>
    <dc:creator>$row[author]</dc:creator>
</item>

EOHTML;

}
echo <<<EOHTML
</channel>
</rss>

EOHTML;
