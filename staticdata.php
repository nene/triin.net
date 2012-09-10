<?php
class StaticData
{
    var $mStyles=array('screen'=>'/style/trinoloogialeht.css',
                       'print'=>'/style/print.css');
    var $mEncoding='utf-8';
    var $mBase='http://www.triin.net/';
    var $mShortcutIcon='/kujundus/fawicon.png';

    function is_naked_day()
    {
        $start = date('U', mktime(-12,0,0,04,05,date('Y')));
        $end = date('U', mktime(36,0,0,04,05,date('Y')));
        $z = date('Z') * -1;
        $now = time() + $z;
        if ( $now >= $start && $now <= $end )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function GetStyles()
    {
        // if it's annual CSS Naked Day (april the 5th, don't show styles :) )
        if ( $this->is_naked_day() )
        {
            return "<!-- Sorry, no stylesheets - it's annual CSS Naked Day! -->";
        }

        foreach($this->mStyles as $media => $stylesheet)
        {
            $out.= '<link rel="stylesheet" type="text/css" href="'.$stylesheet.'" media="'.$media.'" />'."\n";
        }
        return $out;
    }

    function GetEncoding()
    {
        return '<meta http-equiv="content-type" content="text/html; charset='.$this->mEncoding.'" />'."\n";
    }

    function GetBase()
    {
        return '<base href="'.$this->mBase.'" />'."\n";
    }

    function GetOpenId()
    {
        return
			'<link rel="openid.server" href="http://www.myopenid.com/server" />'."\n".
			'<link rel="openid.delegate" href="http://rene.saarsoo.myopenid.com/" />'."\n";
    }

    function GetRss()
    {
        return '<link rel="alternate" type="application/rss+xml" title="Triinulehe artiklid" href="http://www.triin.net/feed.xml" />'."\n".
               '<link rel="alternate" type="application/rss+xml" title="Triinulehe kommentaarid" href="http://www.triin.net/comment-feed.xml" />'."\n";
    }

    function GetShortcutIcon()
    {
        return '<link rel="Shortcut Icon" type="image/png" href="'.$this->mShortcutIcon.'" />'."\n";
    }

    function GetMarkupInfo()
    {
return <<<EOHTML
<div id="markup">
<p><a href="http://www.triin.net/feed.xml" title="RSS feed - uued artiklid Triinulehel">RSS</a>,
<a href="http://www.triin.net/comment-feed.xml" title="RSS feed - uued kommentaarid Triinulehel">RSS kommentaarid</a>,
<a href="http://validator.w3.org/check/referer" title="Kontrolli XHTML-i valideerumist">XHTML</a>,
<a href="http://jigsaw.w3.org/css-validator/check/referer" title="Kontrolli stiililehe valideerumist">CSS</a>,
<a href="http://bobby.watchfire.com/" title="Kontrolli vastavust WAI AA tasemele">AA</a></p>
</div>

EOHTML;
    }

    function GetGeneralInfo()
    {
return <<<EOHTML
<div id="yldinfo">
<h1>Trinoloogialeht</h1>
<address>
<span id="asutuse_nimi">Eesti Trinoloogide Maja.</span>
<span id="deviis">Eesti trinoloogiahuviliste avalik kogunemiskoht.</span>
<a href="&#109;&#097;&#105;&#108;&#116;&#111;&#058;&#105;&#110;&#102;&#111;&#064;&#116;&#114;&#105;&#105;&#110;&#046;&#110;&#101;&#116;">&#105;&#110;&#102;&#111;&#064;&#116;&#114;&#105;&#105;&#110;&#046;&#110;&#101;&#116;</a>
</address>
</div>

EOHTML;
    }


    function GetGoogleAnalyticsJs() {
return <<<EOHTML
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-4512525-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>

EOHTML;
    }

    function GetPrettifyCss() {
return <<<EOHTML
<link href="/prettify/prettify.css" type="text/css" rel="stylesheet" />
EOHTML;
    }

    function GetPrettifyJs() {
return <<<EOHTML
<script type="text/javascript" src="/prettify/prettify.js"></script>
<script type="text/javascript">
(function(){
    var pres = document.getElementsByTagName("pre");
    for (var i=0, len=pres.length; i<len; i++) {
        var code = pres[i].getElementsByTagName("code")[0];
        if (code) {
            code.className = "prettyprint";
        }
    }
    prettyPrint();
})();
</script>
EOHTML;
    }
}
?>
