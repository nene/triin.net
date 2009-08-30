<?php
require_once("conf.php");
require_once('recaptchalib.php');
  
class Comments
{
    var $mContent;
    var $mArticleId;
    var $mPosition='before';
    var $mPreview;
    var $mForm;
    var $mError;
    
    function Comments($articleId, $position='before')
    {
        $this->mArticleId = $articleId;
        $this->mPosition = $position;
    }
    
    function Load()
    {
        // Otsime andmebaasist, kas dokumendile on kommentaare
        $query = "SELECT * FROM comments WHERE articleid='{$this->mArticleId}' ORDER BY datetime";
        if ($this->mPosition=='after')
        {
            $query.= " DESC";
        }
        $result = mysql_query($query);
        // Kui kommentaare leiti, siis lisame dokumendile
        // kõik kommentaariandmed assotsiatiivmassiividena
        if (mysql_num_rows($result)>0)
        {
            while ($row = mysql_fetch_array($result) )
            {
                $this->mContent.= $this->DbRecordToHtml($row);
            }
        }
    }
    
    function DbRecordToHtml($comment)
    {
        $date = datetime_to_est($comment['datetime'], true);
        if (strlen($comment['homepage'])>0)
        {
            $name = "<a href=\"$comment[homepage]\" title=\"kommenteerija koduleht\">$comment[name]</a>";
        }else{
            $name = $comment['name'];
        }

return <<<EOHTML
<div id="kommentaar_$comment[id]">
$comment[text]
<p class="autor">Seda ütles $date $name.</p>
</div>

EOHTML;

    }

    
    function GetCommentForm()
    {
        $reCAPTCHA = recaptcha_get_html(RECAPTCHA_PUBLIC_KEY);
return <<<EOHTML
<form action="/comment.php" method="post" id="commentform">
<h1>Lausu oma mõtteid</h1>
<p class="input">Nimi: <input type="text" name="name" value="{$this->mForm[name]}" /></p>
<p class="input">Koduleht: <input type="text" name="homepage" value="{$this->mForm[homepage]}" /></p>
<p class="input">e-post: <input type="text" name="email" value="{$this->mForm[email]}" /></p>
<p>Lubatud HTML: <code>&lt;a href="" rel="" title=""&gt;, &lt;strong&gt;,
&lt;em&gt;, &lt;code&gt;, &lt;blockquote cite=""&gt;,
&lt;abbr title=""&gt; ja &lt;acronym title=""&gt;</code>.
Reavahetused ja lõigud lisatakse automaatselt.</p>
<p>Kindlasti tuleks määrata oma nimi.
Kodulehe ja e-posti
aadress on valikulised, kusjuures e-posti aadressi
lehele üles ei panda - see on vaid selleks, kui te
kohe mitte ilma selle lisamiseta ei saa.
</p>
<p><textarea rows="20" cols="50" name="comment">{$this->mForm[comment]}</textarea></p>
<p>Et võidelda spämmiga, tõesta, et oled inimene
  <span lang="en">(to fight spam, prove that you are human being)</span>:</p>
$reCAPTCHA
<p><input type="submit" name="submit" value="Ütle!" />
<input type="submit" name="submit" value="Eelvaade" />
<input type="hidden" name="id" value="{$this->mArticleId}" /></p>
</form>

EOHTML;
    }
    
        
    function GetContent()
    {
        if (strlen($this->mContent)>0 && $this->mPosition=='before' )
        {
            $content = "<h1>Arvamused ja täiendused</h1>\n";
            $content.= $this->mContent;
        }
        if (strlen($this->mPreview)>0)
        {
            $content.= "<div id=\"preview\">\n";
            $content.= "<h1>Eelvaade</h1>\n";
            $content.= $this->mPreview;
            $content.= "</div>\n";
        }
        if (strlen($this->mError)>0)
        {
            $content.= "<div id=\"errormessage\" class=\"error\">\n";
            $content.= "<h1>Viga!</h1>\n";
            $content.= $this->mError;
            $content.= "</div>\n";
        }
        
        $content.= $this->GetCommentForm();
        
        if (strlen($this->mContent)>0 && $this->mPosition=='after' )
        {
            $content.= "<h1>Kommentaarid</h1>\n";
            $content.= $this->mContent;
        }
        
        return $content;
    }
    
    function AddPreview($preview)
    {
        $this->mPreview = $preview;
    }
    
    function AddFormInfo($form)
    {
        $this->mForm = $form;
    }

    function AddErrorMessage($error)
    {
        $this->mError = $error;
    }
        
    
    function GetId()
    {
        return "kommentaarid";
    }

    function GetClass()
    {
        return "comments-chapter";
    }

    function GetLanguage()
    {
        return "et";
    }
}

?>