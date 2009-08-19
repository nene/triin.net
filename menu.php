<?php    

class Menu
{
    var $mMenu;
    var $mTitle;
    var $mId;
    var $mSelected;
    var $mAccesskey;
    
    function Menu($menu, $title, $id, $selected='', $accesskey=false)
    {
        $this->mMenu = $menu;
        $this->mTitle = $title;
        $this->mId = $id;
        $this->mSelected = $selected;
        $this->mAccesskey = $accesskey;
    }
    
    function GetContent()
    {
        $out = '<div id="'.$this->mId.'">'."\n".
               '<h2>'.$this->mTitle.'</h2>'."\n".
               "<ul>\n";
        
        $key='';
        foreach ($this->mMenu as $name => $address)
        {
            if ($this->mSelected == $name)
            {
                $out.= "<li><strong>$name</strong></li>\n";
            }else{
                if ($this->mAccesskey)
                {
                    $key = strtolower(substr($name,0,1));
                    $key = " accesskey=\"$key\" title=\"$name [".strtoupper($key)."]\"";
                }
                $out.= "<li><a$key href=\"$address\">$name</a></li>\n";
            }
        }
        
        $out.= "</ul>\n".
               "</div>\n";
        
        return $out;
    }
}
?>