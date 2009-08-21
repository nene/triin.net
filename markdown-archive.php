<?php
require_once("archive.php");
require_once("markdown.php");

class MarkdownArchive extends Archive
{
    function Load()
    {
        // Kontrollime faili olemasolu
        if (!file_exists($this->mFileName)) {
            echo "<p><strong class=\"error\">Unable to open remote file.</strong><p>\n";
            exit;
        }

        $text = file_get_contents($this->mFileName);
        
        // Remove first line that contains date
        preg_match("/^(.*?)\\\n(.*)$/s", $text, $matches);
        $this->SaveMeta("date", $matches[1]);
        $text = $matches[2];
        
        // Convert markdown to HTML
        $this->mContent = Markdown($text);
        
        // Grab title from next line in the file
        $matches = preg_match('/^(.*)$/', $text);
        $this->mTitle = $matches[1];
        
        // Assume english and me as author
        $this->mLang = "en";
        $this->SaveMeta("author", "Rene Saarsoo");
    }
    
}
 
?>