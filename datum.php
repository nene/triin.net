<?php
require_once("mysqlconnect.php");
require_once("urlvars.php");
require_once("document.php");

class Datum
{
    var $mDocument;
    var $mDate;
    var $mDocumentName;

    function Datum($date, $documentName)
    {
        $this->mDocument = new Document();
        $this->mDate=$date;
        $this->mDocumentName=$documentName;
    }

    /**
        GetDateEntry
        Küsib andmebaasist kõik antud kuupäeva, kuu või aasta dokumendid.
        Kui leiti mõni dokument, siis tagastatakse need järjestamata loendina <ul>
        Vastasel juhul tagastatakse false.
    **/
    function GetDateEntry($date)
    {
        // küsime andmebaasist kõik antud kuupäeva, kuu või aasta dokumendid
        if (strlen($date)==7)
        {
            $begin_date = "$date-01";
            $month = substr($date,5,2);
            $year = substr($date,0,4);
            if ($month==12)
            {
                $end_date = ($year+1)."-01-01";
            }elseif ($month<9)
            {
                $end_date = "$year-0".($month+1)."-01";
            }else{
                $end_date = "$year-".($month+1)."-01";
            }
            $query = "SELECT * FROM archive WHERE date >= '$begin_date' AND date < '$end_date'";
        }elseif (strlen($date)==4)
        {
            $query = "SELECT * FROM archive WHERE date >= '$date-01-01' AND date <= '$date-12-31'";
        }else
        {
            $query = "SELECT * FROM archive WHERE date='$date'";
        }
        $result = mysql_query($query);
        
        // kui päring andis tulemusi, siis
        if (mysql_num_rows($result)>0)
        {
            // loome loendi linkidega tolle kuupäeva dokumentidele
            $content = "<ul>\n";
            while ($row = mysql_fetch_array($result))
            {
                $content .= '<li><a href="/'.str_replace('-','/',$row['date']).'/'.
                UrlVars::real2url($row['name']).'">'.$row['date'].' '.$row['name']."</a></li>\n";
            }
            $content .= "</ul>\n";
            // tagastame selle loendi
            return $content;
        }else{
            // kui tollele kuupäevale polnud dateeritud ühtki dokumenti,
            // siis tagastame false
            return false;
        }
    }


    /**
        LoadDateInfo
        Kui on antud dokumendi nimi, siis on pealkirjaks, et dokumenti ei leitud
        ja pakutakse valida mõni teine selle kuupäeva dokument juhul kui neid leidub.
        Kui dokumendi nime pole antud, siis on pealkirjaks vastav kuupäev, kuu või aasta
        ning pakutakse valida mõni selle kuupäeva, kuu või aasta dokument juhul kui
        neid muidugi leidub.
    **/
    function LoadDateInfo()
    {
        // Kui dokumenti nimi on antud, siis sätime ühed teated,
        // nime puudumisel teised vastavalt, kas on antud kuupäev, kuu või aasta
        if (strlen($this->mDocumentName)>0)
        {
            $title = "Viga 404. Dokumenti ei leitud.";
            $content = "<h1>Dokumenti \"".$this->mDocumentName."\" ei leitud kuupäeval ".$this->mDate."!</h1>\n";
            $intro = "<p>Võibolla otsite mõnda teist selle kuupäeva dokumenti:</p>\n";
            $empty_list_message = "<p>Muide, sellele kuupäevale pole dateeritud üldse ühtegi dokumenti.</p>\n";
        
        // kui tegemist on kuuga
        }elseif (strlen($this->mDate) == 7){
            $title = "Aasta ".substr($this->mDate,0,4).", kuu ".substr($this->mDate,5,2);
            $content = "<h1>$title:</h1>\n";
            $intro = "";
            $empty_list_message = "<p>Sellele kuule pole dateeritud ühtegi dokumenti.</p>\n";
        
        // kui tegemist on aastaga
        }elseif (strlen($this->mDate) == 4){
            $title = "Aasta ".$this->mDate;
            $content = "<h1>$title:</h1>\n";
            $intro = "";
            $empty_list_message = "<p>Sellele aastale pole dateeritud ühtegi dokumenti.</p>\n";
        
        // kui tegemist on kuupäevaga
        }else{
            $title = "Kuupäev ".$this->mDate;
            $content = "<h1>$title:</h1>\n";
            $intro = "";
            $empty_list_message = "<p>Sellele kuupäevale pole dateeritud ühtegi dokumenti.</p>\n";
        }
        
        // Proovime hankida kõik antud kuupäeva dokumendid
        $date_entry = $this->GetDateEntry($this->mDate);
        // Kui sellel kuupäeval oli dokumente, siis
        if ($date_entry!==false)
        {
            // Anname kasutajale valida tolle kuupäeva dokumentide seast
            $content .= $intro;
            $content .= $date_entry;
        }else{
            // Kui tollel kuupäeval dokumente polnud, siis nii ka ütleme.
            $content .= $empty_list_message;
        }
        
        $this->mDocument->AddBasicChapter($content);
        $this->mDocument->SetTitle($title);
    }


    function GetAddressById($id)
    {
        global $realChars, $urlChars;
        
        $query = "SELECT * FROM archive WHERE id='$id'";
        $result = mysql_query($query);
        if (mysql_num_rows($result)>0)
        {
            $row = mysql_fetch_array($result);
            return '/'.str_replace('-','/',$row['date']).'/'.UrlVars::real2url($row['name']);
        }else{
            return '';
        }
    }    

    
    /**
        Load
        Laeb dokumendi sisu ja menüüd
    **/
    function Load()
    {
        // Kui tegemist on korrektse kuupäevaga, 
        // siis laeme vastava kuupäeva dokumendi
        if ( strlen($this->mDate) == 10 && checkdate(substr($this->mDate,5,2), substr($this->mDate,8,2), substr($this->mDate,0,4)) )
        {
            $this->LoadDate();
        
        // kui tegemist on kuu või aastaga, 
        // siis anname info vastava kuupäeva dokumentide kohta
        }elseif(preg_match('/^[0-9]{4}-(0[1-9]|1[012])$|^[0-9]{4}$/', $this->mDate))
        {
            $this->LoadDateInfo();
        
        // muul juhul anname teate, et kuupäev on vigane
        }else
        {
            $this->mDocument->AddBasicChapter("<h1>Dokumenti ei leitud!</h1>\n".
                   "<p>Sellisel kuupäeval (".$this->mDate.") ei saagi olla ühtegi dokumenti.</p>\n");
            $this->mDocument->SetTitle("Viga 404. Dokumenti ei leitud.");
        }
        
        $this->mDocument->AddMainMenu();
        if (gettype($this->mDocument->mSubMenu)!='object')
        {
            $this->mDocument->AddSubMenu($this->mDocumentName);
        }
        $this->mDocument->Out();
    }
    
    

    /**
        LoadNormalPage
        Laeb harilikku tüüpi lehekülje ning ühtlasi määrab dokumendi
        <title> atribuudi laetud lehe pealkirja järgi.
        Samuti laetakse dokumendi grupiindeksile vastav menüü.
    **/
    function LoadNormalPage($doc)
    {
        $this->mDocument->AddArchive($doc['address']);
        $this->mDocument->SetTitle($doc['name']);
        $this->mDocument->AddSubMenu($this->mDocumentName, $doc['category'], $doc['groupid']);
        
        
        // kui eksisteerib sellele dokumendile järgnev dokument,
        // siis küsime andmebaasist selle nime
        if ($doc['next']>0)
        {
            $this->mDocument->SetNext($this->GetAddressById($doc['next']));
        }    
        // kui eksisteerib selle dokumendile eelnev dokument,
        // siis küsime andmebaasist selle nime
        if ($doc['previous']>0)
        {
            $this->mDocument->SetPrevious($this->GetAddressById($doc['previous']));
        }    
        
        if ($doc['comments']=='Y')
        {
            $this->mDocument->AddComments($doc['id']);
        }
    }
    
    
    /**
        LoadDate
        Proovib laadida dokumendi, mis vastab antud nimele ja kuupäevale.
        Kui dokumendi nime pole antud, või antud nimega dokumenti sellel
        kuupäeval pole, siis luuakse vealeht.
    **/
    function LoadDate()
    {
        // Kui on antud dokumendi nimi
        if (strlen($this->mDocumentName)>0)
        {
            // Küsime andmebaasist dokumenti, mis vastaks antud nimele ja kuupäevale
            $query = "SELECT * FROM archive WHERE name='".$this->mDocumentName."' AND date='".$this->mDate."'";
            $result = mysql_query($query);
            // Kui selline dokument leiti, siis
            if (mysql_num_rows($result)>0)
            {
                $doc = mysql_fetch_array($result);
                if ($doc['type']=='normal')
                {
                    // kui tegu on hariliku dokumendiga,
                    // siis laeme selle tavalise lehena
                    $this->LoadNormalPage($doc);
                }elseif($doc['type']=='standalone')
                {
                    // kui tegu on iseseisva lehega,
                    // siis lihtsalt incluudime selle lehe
                    // ning väljume
                    include($doc['address']);
                    exit;
                }else
                {
                    // muudel juhtudel saadame kliendile
                    // vastavat tüüpi faili
                    $fp = fopen($doc['address'], 'rb');
                    header("Content-Type: ".$doc['type']);
                    header("Content-Length: ".filesize($doc['address']));
                    fpassthru($fp);
                    exit;
                }
            }else
            {
                $this->LoadDateInfo();
            }
        }else
        {
            $this->LoadDateInfo();
        }
    }
    
}

$datum = new Datum($_GET['date'], UrlVars::url2real($_GET['document_name']));
$datum->Load();
    
    
?>