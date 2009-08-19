<?php
require_once("admin-mode.php");
require_once("document.php");

if (!is_admin_mode()) {
  header("Location: /");
  exit();
}

$document = new Document();
$document->SetTitle("Admin: Viimased kommentaarid");
$document->AddMainMenu();
$document->AddSubMenu();

function commentToHtml($comment)
{
  $date = datetime_to_est($comment['datetime'], true);
  if (strlen($comment['homepage'])>0) {
    $name = "<a href=\"$comment[homepage]\" title=\"kommenteerija koduleht\">$comment[name]</a>";
  }
  else {
    $name = $comment['name'];
  }

  return <<<EOHTML
<div id="kommentaar_$comment[id]">
$comment[text]
  <p class="autor">
  Teema: $comment[article]<br />
  $date $name ($comment[email]).<br />
  <b><a href="?delete=$comment[id]">Kustuta</a></b>
  </p>
</div>
EOHTML;
}

if (isset($_GET["delete"])) {
  $delete_id = intval($_GET["delete"]);
  mysql_query("DELETE FROM comments WHERE id=$delete_id");
}

// Otsime andmebaasist viimased kommentaarid
$result = mysql_query("
  SELECT
    comments.id as id,
    comments.name as name,
    datetime,
    homepage,
    email,
    text,
    archive.name as article
  FROM comments LEFT JOIN archive ON (comments.articleid=archive.id)
  ORDER BY datetime DESC"
);
$comments = "";
while ($row = mysql_fetch_array($result) )
{
  $comments.= commentToHtml($row);
}


$chapter = <<<EOHTML
<h1>Admin: Viimased kommentaarid</h1>

$comments

EOHTML;

$document->AddBasicChapter($chapter, "kommentaarid");

$document->Out();

?>