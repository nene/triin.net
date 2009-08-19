<?php
class ArchiveItem 
{
    var $mFileName;
    var $mLang="et";
    var $mTitle;
    var $mAuthor;
    var $mDescription;
    var $mKeywords;
    var $mDate;
    var $mLastModified;
    var $mContent;
    
    /** 
        SaveMeta
        Salvestab html-i meta-elemendi väärtuse 
        vastavasse klassi-muutujasse.
    **/
    function SaveMeta($name, $content)
    {
        switch ($name)
        {
            case 'author':        $this->mAuthor = $content; break;
            case 'description':   $this->mDescription = $content; break;
            case 'keywords':      $this->mKeywords = $content; break;
            case 'date':          $this->mDate = $content; break;
            case 'last-modified': $this->mLastModified = $content; break;
        } 
    }

    function getLanguage()
    {
        return $this->mLang;
    }


    function getMetaTags()
    {
        $out="";
        if (strlen($this->mAuthor)>0){
            $out.="<meta name=\"author\" content=\"".$this->mAuthor."\" />\n";
        }
        if (strlen($this->mDescription)>0){
            $out.="<meta name=\"description\" content=\"".$this->mDescription."\" />\n";
        }
        if (strlen($this->mKeywords)>0){
            $out.="<meta name=\"keywords\" content=\"".$this->mKeywords."\" />\n";
        }
        if (strlen($this->mDate)>0){
            $out.="<meta name=\"date\" content=\"".$this->mDate."\" />\n";
        }
        if (strlen($this->mLastModified)>0){
            $out.="<meta name=\"last-modified\" content=\"".$this->mLastModified."\" />\n";
        }
        return $out;
    }
    
    /**
        Load
        Laeb html-failist $mFileName tiitli $mTitle, meta-info ja
        sisu $mContent (elementide <body> ja </body> vaheline osa)
        NB! Funktsioon eeldab, et failis pole pikki ridu (üle 256 
        märgi) ja et elemendid <title />, <meta />, <body> ja 
        </body> ei asu ühel real teiste elementidega. Ühtlasi
        eeldatakse ka korrektset XHTML-i süntaksit.
    **/
    function Load()
    {
        $line="";
        // Proovime faili avada ja testime avamise õnnestumist
        $file = fopen($this->mFileName, "r");
        if (!$file) {
            echo "<p><strong class=\"error\">Unable to open remote file.</strong><p>\n";
            exit;
        }

        // Liigume failis edasi ridahaaval kuni jõuame <html> elemendini
        while (!feof($file)) {
           $line = fgets($file, 256);
           if (strpos($line, '<html')!==false) {
               break;
           }
        }
        // Salvestame keele muutujasse
        if ( preg_match('/<html.* lang="([^"]*)".*>/', $line, $matches) ) {
            $this->mLang = $matches[1];
        }

        // Liigume failis edasi ridahaaval kuni jõuame tiitlini
        while (!feof($file)) {
           $line = fgets($file, 256);
           if (strpos($line, '<title')!==false) {
               break;
           }
        }
        // Salvestame tiitli muutujasse
        if (preg_match('/<title>(.*)<\/title>/', $line, $matches);
        $this->mTitle = $matches[1];

        // Liigume failis edasi ja salvestame meta-väärtused
        // kuni jõuame body elemendini
        while (!feof($file)) {
           $line = fgets($file, 256);
           if (preg_match('/<meta name="(.*)" content="(.*)" \/>/', $line, $matches)) {
               $this->SaveMeta($matches[1], $matches[2]);
           }elseif (strpos($line, '<body')!==false) {
               break;
           }
        }

        // Salvestame kogu vahepealse sisu, kuni jõuame sulgeva bodyni
        while (!feof($file)) {
           $line = fgets($file, 256);
           if (strpos($line, '</body')!==false) {
               break;
           }
           $this->mContent .= $line;
        }
                
        fclose($file);
        
        if (strlen($this->mContent)==0){
            echo "<p><strong class=\"error\">This file is not properly formatted XHTML.</strong><p>\n";
        }
    }
    
    /**
        ArchiveItem
        Konstruktor. Seab paika failinime.
    **/
    function ArchiveItem($fileName="")
    {
        $this->mFileName = $fileName;
    }
    
}
 
?>