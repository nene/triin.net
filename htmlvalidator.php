<?php

class HtmlValidator
{
    var $mAllowedHtml = array('p', 'br', 'a', 'em', 'strong', 'code', 'blockquote', 'abbr', 'acronym');
    var $mStack = array();
    
    
    function ValidateParameters($elementName, $parameters)
    {
        switch ($elementName)
        {
            case 'a':
                // kontrollime parameetrite vastavust regulaaravaldisele
                if (preg_match('/^( +rel="[^"]+")?( +title="[^"]+")?( +rel="[^"]+")? +href="[^"]+"( +rel="[^"]+")?( +title="[^"]+")?( +rel="[^"]+")? *$/', $parameters)==0)
                {
                    // mittevastavuse korrel tagastame veateate
                    return "Ebasobivad parameetrid elemendile 'a'.";
                }
            break;
            case 'blockquote':
                // kontrollime parameetrite vastavust regulaaravaldisele
                if (preg_match('/^ +cite="[^"]+" */', $parameters)==0)
                {
                    // mittevastavuse korrel tagastame veateate
                    return "Ebasobiv(ad) parameeter(id) elemendile 'blockquote'.";
                }
            break;
            case 'abbr':
                // kontrollime parameetrite vastavust regulaaravaldisele
                if (preg_match('/^ +title="[^"]+" */', $parameters)==0)
                {
                    // mittevastavuse korrel tagastame veateate
                    return "Ebasobiv(ad) parameeter(id) elemendile 'abbr'.";
                }
            break;
            case 'acronym':
                // kontrollime parameetrite vastavust regulaaravaldisele
                if (preg_match('/^ +title="[^"]+" */', $parameters)==0)
                {
                    // mittevastavuse korrel tagastame veateate
                    return "Ebasobiv(ad) parameeter(id) elemendile 'acronym'.";
                }
            break;
            default:
                // parameetrid on lubatud vaid ülaltoodud elementidel
                // ülejäänute puhul tagastame veateate
                return "Elemendil ".$elementName.' pole parameetrid lubatud.';
        }
        return true;
    }
    
    function ValidateOpeningElement($element)
    {
        // leiame elemendi nime, eemaldades lõpust kõik parameetrid
        $element_name = substr($element, 0, strpos($element.' ', ' '));
        
        // kontrollime, kas elemendi nimi on lubatud elementide seas
        if (in_array($element_name, $this->mAllowedHtml)==true)
        {
            // kui elemendil puuduvad parameetrid, siis
            if ($element_name == $element)
            {
                // juhul kui elemendiks on 'a', anname veateate
                if ($element == 'a')
                {
                    return "Elemendil 'a' peab olema määratud parameeter href.";
                }elseif ($element == 'p')
                {
                    // kui element on 'p', siis kontrollime, et ta ei asuks 
                    // ühegi teise elemendi sees v.a. 'blockquote'.
                    // kui asub, siis anname veateate.
                    if (count($this->mStack)>0)
                    {
                        if ($this->mStack[count($this->mStack)-1] != 'blockquote')
                        {
                            return "Element 'p' ei saa olla ühegi teise elemendi sees v.a. 'blockquote'.";
                        }
                    }
                }
                // paigutame lubatud elemendi pinusse
                array_push($this->mStack, $element_name);
            }else{
                // paigutame lubatud elemendi pinusse
                array_push($this->mStack, $element_name);
                // kui elemendil on parameetrid, siis valideerime elemendi parameetrid
                return $this->ValidateParameters($element_name, substr($element, strlen($element_name)));
            }
        }else{
            // mitte lubatud elemendi puhul anname veateate
						if (strpos($element_name, '<'))
						{
						    return "Elemendi nimi ei saa sisaldada '&lt;' märki.";
						}else{
						    return "Element '$element_name' pole lubatud.";
						}
        }
        
        return true;
    }
    
    function ValidateClosingElement($element)
    {
        // kontrollime, kas elemendi nimi on lubatud elementide seas
        if (in_array($element, $this->mAllowedHtml)==true)
        {
            // kontrollime, kas element ühtib pinust võetava elemendiga
            if (array_pop($this->mStack)!=$element)
            {
                // kui ei ühti, siis anname veateate
                return "Elementi '$element' ei saa selles kohas sulgeda.";
            }
        }else{
            // mitte lubatud elemendi puhul anname veateate
            return "Element '$element' pole lubatud.";
        }
        return true;
    }
    
    function ValidateShortenedElement($element)
    {
        // kui lühendatud element pole <br />, siis anname veateate.
        if (preg_match('/^br +\/$/', $element)==0)
        {
            return "Element '$element' pole lubatud lühendatud kujul.";
        }
        return true;
    }
    
    function ValidateElement($element)
    {
        // asename elemendisisesed reavahetused tühikutega
        $element = preg_replace("/(\015\012)|(\015)|(\012)/", " ", $element);
        
        // kui element algab kaldkriipsuga, siis valideerime ta lõpuelemendina,
        // kui mitte, siis alguselemendina
        if ($element[0]=='/')
        {
            // valideerimiseks anname elemendi ilma alustava kaldkriipsuta
            return $this->ValidateClosingElement(substr($element, 1));
        }elseif(substr($element, -1)=='/'){
            return $this->ValidateShortenedElement($element);
        }else{
            return $this->ValidateOpeningElement($element);
        }
        return true;
    }
    
    function Validate($source)
    {
        // otsime lähtekoodist kõik elemendid ja paigutame nad massiivi $matches. 
        // $matches[0] on massiiv elementidest koos < ja > märgiga
        // $matches[1] on massiiv elementidest ilma < ja > märgita
        preg_match_all('/<([^>]*)>/', $source, $matches);
        
        // valideerime kõik algus- ja lõpumärgita elemendid
        foreach ($matches[1] as $element)
        {
            $err = $this->ValidateElement($element);
            
            // kui element ei valideeru, siis tagastame veateate
            if ($err!==true)
            {
                return $err;
            }
        }
        
        // Kui mõni element jäi sulgemata (pinust eemaldamata), siis anname veateate.
        if (count($this->mStack)>0)
        {
            return 'one or more elements not finished!';
        }
        
        return true;
    }
}

?>