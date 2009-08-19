<?php

class Chapter
{
    var $mContent;
    var $mId;
    var $mLang="et";
    
    function Chapter($content, $id, $lang="et")
    {
        $this->mContent = $content;
        $this->mId = $id;
        $this->mLang = $lang;
    }
    
    function GetContent()
    {
        return $this->mContent;
    }
    
    function GetId()
    {
        return $this->mId;
    }

    function GetLanguage()
    {
        return $this->mLang;
    }
}

?>