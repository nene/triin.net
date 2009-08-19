<?php
require_once("mysqlconnect.php");
require_once("archive.php");
require_once("chapter.php");
require_once("staticdata.php");
require_once("menu.php");
require_once("comments.php");


function datetime_to_est($datetime, $rahva=false, $time=true)
{
    $kuud = array ( 'jaanuaril', 'veebruaril', 'märtsil', 'aprillil',
                    'mail', 'juunil', 'juulil', 'augustil',
                    'septembril', 'oktoobril', 'novembril', 'detsembril' );

    $YYYY = substr($datetime, 0, 4);
    $MM = ltrim(substr($datetime, 5, 2), '0');
    $DD = ltrim(substr($datetime, 8, 2), '0');
    $HHMM = substr($datetime, 11, 5);
    
    if (date('Y-m-d')==substr($datetime, 0, 10))
    {
        $day = "täna";
    }else{
        $day = "$DD. ".$kuud[$MM-1]." $YYYY";
    }
    
    if ($time)
    {
        return $day." kell $HHMM";
    }else{
        return $day;
    }
}
    


class Document
{
    var $mTitle="default";
    var $mStatic;
    var $mChapters;
    var $mArchiveCount;
    var $mMainMenu;
    var $mSubMenu;
    var $mNext;
    var $mPrevious;
    
    /**
        Document
        Konstruktor
    **/
    function Document()
    {
        $this->mStatic=new StaticData();
    }
    
    
    function AddArchive($fileName, $commentCount=0, $url='', $comments='N')
    {
        $this->mChapters[] = new Archive($fileName, $commentCount, $url, $comments);
        $this->mChapters[count($this->mChapters)-1]->Load();
        $this->mArchiveCount++;
    }
    
    function AddBasicChapter($content, $id='')
    {
        $this->mChapters[] = new Chapter($content, $id);
    }
    
    function AddComments($id, $commentPosition='before', $formInfo='', $preview='', $error='' )
    {
        $this->mChapters[] = new Comments($id, $commentPosition);
        $ch_id=count($this->mChapters)-1;
        $this->mChapters[$ch_id]->AddFormInfo($formInfo);
        $this->mChapters[$ch_id]->AddPreview($preview);
        $this->mChapters[$ch_id]->AddErrorMessage($error);
        $this->mChapters[$ch_id]->Load();
    }
    
    function AddMainMenu($selected = '')
    {
        $this->mMainMenu = new Menu(
            array('Hiljutine' => '/',
                  'Teadmiseks' => '/teadmiseks',
                  'Arhiiv' => '/arhiiv',
                  'Looming' => '/looming',
                  'Kontakt' => '/kontakt'
                 ),
            'Peamenüü',
            'peamenyy',
            $selected,
            true);
    }
    
    
    function AddSubMenu($selected = '', $category='', $groupId=0)
    {
        if ($groupId>0)
        {
            $heading="Sisukord";
            $query = "SELECT * FROM archive WHERE groupid='$groupId' ORDER BY `order`";
        }elseif (strlen($category)>0)
        {
            $heading="Samal teemal";
            $query = "SELECT * FROM archive WHERE category='$category' AND `order`=0 ORDER BY date DESC, name";
        }else{
            $heading="Viimased artiklid";
            $query = "SELECT * FROM archive ORDER BY date DESC, name LIMIT 15";
        }
        $result = mysql_query($query);
        
        while ($row = mysql_fetch_array($result))
        {
            $menu[$row['name']] = '/'.str_replace('-', '/', $row['date']).'/'.UrlVars::real2url($row['name']);
        }
        
        $this->mSubMenu = new Menu(
            $menu,
            $heading,
            'alammenyy',
            $selected);
    }
    
    function SetTitle($title)
    {
        $this->mTitle = $title;
    }
    
    function SetNext($next)
    {
        $this->mNext = $next;   
    }

    function SetPrevious($previous)
    {
        $this->mPrevious = $previous;   
    }
            
    function OutputTitle()
    {
        echo '<title>'.$this->mTitle."</title>\n";
    }            
    
    function OutputMetaInfo()
    {
        if ($this->mArchiveCount==1)
        {
            for ($i=0; $i<count($this->mChapters); $i++)
            {
                if (get_class($this->mChapters[$i])=='archive')
                {
                    echo $this->mChapters[$i]->GetMetaInfo();
                }
            }
        }
    }
    
    function OutputSisu()
    {
        echo "<div id=\"sisu\">\n";
        if (count($this->mChapters)>0)
        {
            for ($i=0; $i<count($this->mChapters); $i++)
            {
                $lang = $this->mChapters[$i]->GetLanguage();
                $id = $this->mChapters[$i]->GetId();
                $content = $this->mChapters[$i]->GetContent();
                echo <<<EOHTML
<div class="peatykk" id="$id" lang="$lang" xml:lang="$lang">
$content
</div>
EOHTML;
            }
        }
        $this->OutputNextPrevious();
        echo "</div>\n";
    }
    
    function OutputMenus()
    {
        if (gettype($this->mMainMenu)=='object')
        {
            echo $this->mMainMenu->GetContent();
        }
        if (gettype($this->mSubMenu)=='object')
        {
            echo $this->mSubMenu->GetContent();
        }
    }
    
    function OutputNextPrevious()
    {
        if (strlen($this->mPrevious)>0 || strlen($this->mNext)>0)
        {
            echo "<div id=\"navigatsioon\">\n";
            echo "<p>";
            if (strlen($this->mPrevious)>0)
            {
                echo '<a id="nextpage" href="'.$this->mPrevious.'" title="Mine eelmisele leheküljele">Eelmine</a> ';
            }
            if (strlen($this->mPrevious)>0 && strlen($this->mNext)>0)
            {
                echo ' ';
            }
            if (strlen($this->mNext)>0)
            {
                echo '<a id="prevpage" href="'.$this->mNext.'" title="Mine järgmisele leheküljele">Järgmine</a>';
            }
            echo "</p>\n";
            echo "</div>\n";
        }
    }
    
    function Out()
    {
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n";
        echo "\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"et\" lang=\"et\">\n";
        echo "<head>\n";
        
        $this->OutputTitle();
        //echo $this->mStatic->getBase();
        echo $this->mStatic->GetEncoding();
        echo $this->mStatic->GetStyles();
        echo $this->mStatic->GetShortcutIcon();
        echo $this->mStatic->GetRss();
        echo $this->mStatic->GetOpenId();
        $this->OutputMetaInfo();
        
        echo "</head>\n";
        echo "<body>\n";
        
        $this->OutputSisu();
        
        echo $this->mStatic->GetGeneralInfo();
        
        $this->OutputMenus();
        
        echo $this->mStatic->GetMarkupInfo();
        
        echo $this->mStatic->GetGoogleAnalyticsJs();
        
        echo "</body>\n";
        echo "</html>\n";
    }
    
}

?>