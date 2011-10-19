<?php
require_once('conf.php');
require_once('recaptchalib.php');
require_once('htmlvalidator.php');

class Commentator
{
    var $mComment;
    var $mFormattedComment;
    var $mName;
    var $mEmail;
    var $mHomepage;
    var $mRcChallenge;
    var $mRcResponse;
    
    var $mError;
    
    function Commentator($request)
    {
        $this->mComment = trim($request['comment']);
        $this->mId = (int)$request['id'];
        $this->mName = trim($request['name']);
        $this->mEmail = trim($request['email']);
        $this->mHomepage = trim($request['homepage']);
        $this->mRcChallenge = $request['recaptcha_challenge_field'];
        $this->mRcResponse = $request['recaptcha_response_field'];
    }
    
    function CheckName($name)
    {
        if (!preg_match("/^[^\"'<>]*$/", $name))
        {
            $err.= "<p>Üks normaalne nimi ei sisaldada märke ', \", &amp;, &lt; ega &gt;.</p>\n";
        }
        if (strlen($name)==0)
        {
            $err.= "<p>Palun lisage oma kommentaarile ka oma nimi.</p>\n";
        }
        if (strlen($name)==1)
        {
            $err.= "<p>Teie nimi ei koosne ju ometi ühest tähest? Või kui, siis lisage ka oma perekonnanimi.</p>\n";
        }
        if (strlen($name)>255)
        {
            $err.= "<p>Teie nimi on liiga pikk, palun jätke ära näiteks isanimi või kirjutage lihtsalt see nimi, millega teid teie sõbrad harilikult kutsuvad.</p>\n";
        }
        return $err;
    }    
        
    
    function CheckHomepage($homepage)
    {    
        if (!preg_match("/^https?:\/\/[^\"']+$|^$/", $homepage))
        {
            $err.= "<p>Kodulehe aadress pole korrektne - see peab algama kujul http:// või https:// ja ei tohi sisaldada jutumärke.</p>";
        }
        if (strlen($homepage)>255)
        {
            $err.= "<p>Kodulehe aadress, mille sisestasite on liiga pikk, palun kirjutage mõni lühem.</p>\n";
        }
        return $err;
    }
    
    function CheckEmail($email)        
    {
        if (!preg_match("/^[A-Za-z0-9]+@$|[A-Za-z0-9]+\.([A-Za-z0-9]+\.)?[A-Za-z0-9]{2,4}$|^$/", $email))
        {
            $err.= "<p>E-posti aadress pole korrektne.</p>";
        }
        if (strlen($email)>255)
        {
            $err.= "<p>E-posti aadress, mille sisestasite on natuke liiga pikk, palun kirjutage mõni lühem.</p>\n";
        }
        return $err;
    }

    function CheckTooManyLinks($comment)
    {
        if (preg_match("/(<a\b.*){3,}/si", $comment))
        {
            $err.= "<p>Kommentaaris on liiga palju linke, tundub nagu spämm.</p>";
        }
        return $err;
    }

    function CheckSpam($challenge, $response)
    {
        $resp = recaptcha_check_answer(
            RECAPTCHA_PRIVATE_KEY,
            $_SERVER["REMOTE_ADDR"],
            $challenge,
            $response
        );
        if (!$resp->is_valid)
        {
            $err = "<p>Teil on korrektselt täitmata reCAPTCHA spämmi-vastane lahter.</p>";
        }
        return $err;
    }
    
    function FieldCheck()
    {
        $err.=$this->CheckName($this->mName);
        $err.=$this->CheckHomepage($this->mHomepage);
        $err.=$this->CheckEmail($this->mEmail);
        $err.=$this->CheckTooManyLinks($this->mComment);
        $err.=$this->CheckSpam($this->mRcChallenge, $this->mRcResponse);
        $this->mError.= $err;
        return (strlen($err)==0);
    }
    
    function Parse()
    {
        // proovime lisada paragrahvid
        $result = $this->AddParagraphs($this->mComment);
        if ($result!==false)
        {
            $this->mFormattedComment = $result;
            // kontrollime nime, kodulehe ja emaili väljasid
            $check = $this->FieldCheck();
            // proovime valideerida
            $valid = $this->Validate();
            if ($valid && $check)
            {
                return true;
            }else{
                return false;
            }
        }else{
            $this->mError = "Element 'blockquote' peab oleme lõpetatud ning ei saa asuda teise 'blockquote' sees.";
            return false;
        }
    }
    
    function Validate()
    {
        $validator = new HtmlValidator;
        
        $result = $validator->Validate($this->mFormattedComment);
        
        if ($result===true)
        {
            return true;
        }else{
            $this->mError.= $result;
            return false;
        }
    }
    
    function GetQuery()
    {
        $comment = addslashes($this->mFormattedComment);
        return <<<OESQL
INSERT INTO `comments` ( `id` , `articleid` , `datetime` , `name` , `email` , `homepage` , `text` ) 
VALUES ('', '{$this->mId}', NOW( ) , '{$this->mName}', '{$this->mEmail}', '{$this->mHomepage}', '$comment')
OESQL;
    }
    
    function AddParagraphs($text)
    {
        // jaotame teksti ridadeks
        $lines = preg_split('/\015\012|\015|\012/', $text);
        
        // liigume ridahaaval läbi kogu testi
        for ($i = 0; $i < count($lines); $i++)
        {
            // kui rida on tühi, siis
            if (trim($lines[$i]) == '')
            {
                // juhul kui lõik sisaldab teksti,
                // siis vormindame selle lõigu
                // ja lisame kogu vormindatud tekstile
                if (strlen($p) > 0)
                {
                    $formatted_text.="<p>$p</p>\n\n";
                }
                // tühjendame lõigu
                $p = '';
            }else{
                // kui rida pole tühi, siis kontrollime, 
                // kas rida sisaldab <blockquote> elementi
                if (preg_match('/<blockquote(\s+cite="[^"]+")?\s*>/', $lines[$i])==0)
                {
                    // kui ei sisalda siis juhul, kui lõik
                    // sisaldab teksti, lisame selle rea lõigule
                    // koos eelneva reavahetuse märgiga.
                    if (strlen($p) > 0)
                    {
                        $p.= "<br />\n".$lines[$i];
                    }else{
                        // kui lõigus tekst puudub, siis saab
                        // lõigu tekstiks see rida.
                        $p = $lines[$i];
                    }
                }else{
                    // kui <blockquote> esineb, siis 
                    // poolitame rea selle koha pealt kaheks.
                    $splitted = preg_split('/<blockquote(\s+cite="[^"]+")?\s*>/', $lines[$i]);
                    // kui lõik sisaldab teksti, siis 
                    if (strlen($p)>0)
                    {
                        // kui esimene pool poolitatud reast
                        // sisaldab teksti, siis
                        if (strlen($splitted[0])>0)
                        {    
                            // lisame selle rea lõigule
                            // koos eelneva reavahetuse märgiga
                            $p.= "<br />\n".$splitted[0];
                        }    
                    }else{
                        // kui lõik teksti ei sisalda,
                        // siis omistame lõigule kogu esimese poole
                        // poolitatud reast
                        $p = $splitted[0];
                    }
                    // teise poole poolitatud reast
                    // omistame sellele samale reale
                    $lines[$i] = $splitted[1];
                    
                    // kui nüüd lõik sisaldab teksti,
                    // siis vormindame selle lõigu
                    // ja lisame kogu vormindatud tekstile 
                    if (strlen($p) > 0)
                    {
                        $formatted_text.="<p>$p</p>\n\n";
                    }
                    // tühjendame lõigu ning blockuote-i sisu 
                    $p = '';
                    $block = '';
                    
                    // tsükkel seni, kuni element <blockquote> pole lõpetatud
                    while (strpos($lines[$i], '</blockquote>')===false)
                    {
                        // kui reas sisaldub elemendi <blockquote> algus,
                        // siis tagastame veateate FALSE
                        if (preg_match('/<blockquote(\s+cite="[^"]+")?\s*>/', $lines[$i])==1)
                        {
                            return false;
                        }
                        // lisame blockquote-i sisule käesoleva rea
                        $block.= "\n".$lines[$i];
                        // liigume edasi järgmisele reale
                        $i++;
                        // kui reanumber ületab ridade arvu,
                        // siis tagastame veateate FALSE
                        if ($i >= count($lines))
                        {
                            return false;
                        }
                    }
                    // poolitame rea elemendi blockquote lõpumärgi koha pealt
                    $splitted = explode('</blockquote>', $lines[$i]);
                    // lisame blockquote-i sisule esimese poole
                    // ja lõigule omistame teise poole
                    $block.= $splitted[0];
                    $p = $splitted[1];
                    // kogu vormindatud tekstile lisame blockquote-i, mille sisu
                    // on vormistatud lõikudeks
                    $formatted_text.= "<blockquote>\n\n".$this->AddParagraphs($block)."</blockquote>\n\n";
                }
            }
        }
        
        // kui viimane lõik jäi lisamata,
        // siis lisame ka selle vormistatuna kogu tekstile
        if (strlen($p) > 0)
        {
            $formatted_text.="<p>$p</p>\n\n";
        }
        
        return $formatted_text;
    }
    
    
    
}


?>