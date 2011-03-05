<?php
class picter {

    var $gallery=array();
    
    function picter(){
        }
    function source($dir){
        $id=count($this->gallery);
        $this->gallery[$id]["dir"]=$dir;
        $this->gallery[$id]["pic"]=$this->open_dir($dir);
        }
    function open_dir($dir){
        $pictures=array();
        $i=0;
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    $type=strtolower(substr($file,-4, 4));
                    $types=array(".jpg",".gif",".png","jpeg",".jpe");
                    if (in_array($type,$types)){
                        $pictures[$i++]["filename"]=$file;
                        }
                    }
                closedir($dh);
                }
            }
        $array_lowercase = array_map('strtolower', $pictures);
        if($this->sort=="asc"){
            array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $pictures);
            }
        else{
            array_multisort($array_lowercase, SORT_DESC, SORT_STRING, $pictures);
            }
        return $pictures;
        }
    function assign_gallery($id){
        $cols=3;
        $rows=2;
        $count=count($this->gallery[$id]["pic"]);
        $this->gallery[$id]["count"]=$count;
        
        // how many pages and how mani pics in there
        $page_id=$_GET["page_id"];
        $pic_id=$_GET["pic_id"];
        $this->gallery[$id]["page"] = array();
        $this->gallery[$id]["page_rows"] = $rows;
        $this->gallery[$id]["page_cols"] = $cols;
        for($i=0;$i*$cols*$rows<$count; $i++){ 
            if($i==$page_id){ 
                $this->gallery[$id]["page"][$i]["open"] = 1;
                }
            else{
                $this->gallery[$id]["page"][$i]["open"] = 0;
                }
            if(!(($i+1)*$cols*$rows<=$count)){
                $this->gallery[$id]["page"][$i]["begin"] = $i*$cols*$rows+1;
                $this->gallery[$id]["page"][$i]["end"] = $count;
                }
            else{
                $this->gallery[$id]["page"][$i]["begin"] = $i*$cols*$rows+1;
                $this->gallery[$id]["page"][$i]["end"] = ($i+1)*$cols*$rows;
                }
            }
        
        // active page, how many pics and where is row break
        $this->gallery[$id]["page_pic"] = array();
        $inc=0;
        for($i=$page_id*$cols*$rows;$i<($page_id+1)*$cols*$rows; $i++){ 
            $this->gallery[$id]["page_pic"][$inc] = &$this->gallery[$id]["pic"][$i]; 
            if(($i%$cols==($cols-1))){ 
                $this->gallery[$id]["page_pic"][$inc]["row_break"]=1; 
                } 
            else{ 
                $this->gallery[$id]["page_pic"][$inc]["row_break"]=0; 
                } 
            $this->gallery[$id]["page_pic"][$inc]["id"]=$i; 
            if(($i+1)==$count){ 
                $i=($page_id+1)*$cols*$rows; 
                } 
            $inc++; 
            }
        $this->active_gallery = &$this->gallery[$id];
        }
    
    function assign_pic($album_id,$pic_id){
        $cols=3;
        $rows=2;
        $count=count($this->gallery[$album_id]["pic"]);
        $this->gallery[$id]["count"]=$count;
        
        // how many pages and how mani pics in there
        $page_id=(int)($pic_id/($cols*$rows));
        $this->gallery[$id]["page"] = array();
        $this->gallery[$id]["page_rows"] = $rows;
        $this->gallery[$id]["page_cols"] = $cols;
        for($i=0;$i*$cols*$rows<=$count; $i++){ 
            if($i==$page_id){ 
                $this->gallery[$id]["page"][$i]["open"] = 1;
                }
            else{
                $this->gallery[$id]["page"][$i]["open"] = 0;
                }
            if(!(($i+1)*$cols*$rows<=$count)){
                $this->gallery[$id]["page"][$i]["begin"] = $i*$cols*$rows+1;
                $this->gallery[$id]["page"][$i]["end"] = $count;
                }
            else{
                $this->gallery[$id]["page"][$i]["begin"] = $i*$cols*$rows+1;
                $this->gallery[$id]["page"][$i]["end"] = ($i+1)*$cols*$rows;
                }
            }
        $this->active_picture = $this->gallery[$album_id]["pic"][$pic_id];
        $this->active_gallery = &$this->gallery[$album_id];
        }
    function pic_info(&$pic, $level){
        switch($level){
            case "1":
                break;
            default:
                if(!isset($pic["getlevel"]) || $pic["getlevel"]=="" || $pic["getlevel"]<0){
                    $this->pic_info_0($pic);
                    $pic["getlevel"]="0";
                    }
            }
        }
    function pic_info_0(&$pic){
        $this->get_filesize($pic);
        $this->get_imagesize($pic);
        }

    function get_filesize(&$pic) {
        $size=filesize($pic["filename"]);
        if ($size != 0) {
            $pic["filesize"]["B"]=$size;    
            $pic["filesize"]["KB"]=$size / 1024;
            $pic["filesize"]["MB"]=$size / 1024 / 1024;
            $pic["filesize"]["GB"]=$size / 1024 / 1024 / 1024;
            $pic["filesize"]["TB"]=$size / 1024 / 1024 / 1024 / 1024;
        
            if ($size>=1099511627776) {
                $fsize = round($pic["filesize"]["TB"], 2);
                $suff = "TB";
                }
            elseif ($size>=1073741824) {
                $fsize = round($pic["filesize"]["GB"], 2);
                $suff = "GB";
                }
            elseif ($size>=1048576) {
                $fsize = round($pic["filesize"]["MB"], 2);
                $suff = "MB";
                }
            elseif ($size>=1024) {
                $fsize = round($pic["filesize"]["KB"], 2);
                $suff = "KB";
                }
            elseif ($size<1024) {
                $fsize = round($pic["filesize"]["B"], 2);
                $suff = "Byte";
                }
            }
        else {
            $suff = "Byte";
            }
        $format = $fsize." ".$suff;
        $pic["filesize"]["formatted"]=$format;
        return $size;
        }
    function get_imagesize(&$pic) {
        $size = getimagesize($pic["filename"]);
        $pic["imagesize"]["width"]=$size[0];
        $pic["imagesize"]["height"]=$size[1];
        $pic["imagesize"]["img"]=$size[3];
        $pic["imagesize"]["mime"]=$size["mime"];
        $pic["imagesize"]["bits"]=$size["bits"];
        switch($size[2]){
            case 1;
                $pic["imagesize"]["failtype"]="GIF";
                break;
            case 2;
                $pic["imagesize"]["failtype"]="JPG";
                break;
            case 3;
                $pic["imagesize"]["failtype"]="PNG";
                break;
            case 4;
                $pic["imagesize"]["failtype"]="SWF";
                break;
            case 5;
                $pic["imagesize"]["failtype"]="PSD";
                break;
            case 6;
                $pic["imagesize"]["failtype"]="BMP";
                break;
            case 7;
                $pic["imagesize"]["failtype"]="TIFF";
                break;
            case 8;
                $pic["imagesize"]["failtype"]="TIFF";
                break;
            case 9;
                $pic["imagesize"]["failtype"]="JPC";
                break;
            case 10;
                $pic["imagesize"]["failtype"]="JP2";
                break;
            case 11;
                $pic["imagesize"]["failtype"]="JPX";
                break;
            case 12;
                $pic["imagesize"]["failtype"]="JB2";
                break;
            case 13;
                $pic["imagesize"]["failtype"]="SWC";
                break;
            case 14;
                $pic["imagesize"]["failtype"]="IFF";
                break;
            case 15;
                $pic["imagesize"]["failtype"]="WBMP";
                break;
            case 16;
                $pic["imagesize"]["failtype"]="XBM";
                break;
            default:
                $pic["imagesize"]["failtype"]="";
                break;
            }
        }
    function make_thumb(&$pic) {
    
        //first make directory;
        $dirname="thumbs";
        $this->get_imagesize($pic);
        if(!is_dir($dirname)){
            mkdir ($dirname, 0777);
            }
        $pic["thumb"]["default_width"]=200;
        $pic["thumb"]["default_height"]=200;
        //then check if thumb exist
        if(!is_file($dirname."/".$pic["filename"])){
            $resize=$this->resize_calc($pic, $pic["thumb"]["default_width"],$pic["thumb"]["default_height"]);
            $this->resize_gd($pic, $resize, $dirname);
            }
        //then add thumb information
        //same as basic image information
        $pic["thumb"]["filename"]=$dirname."/".$pic["filename"];
        $this->pic_info_0($pic["thumb"]);
        }
    
    function make_medium(&$pic) {
        $convert_medium=0;
        if($convert_medium){
            //first make directory;
            $dirname="medium";
            $this->get_imagesize($pic);
            if(!is_dir($dirname)){
                mkdir ($dirname, 0777);
                }
            //then check if file exist
            if(!is_file($dirname."/".$pic["filename"])){
                $resize=$this->resize_calc($pic, "200","200");
                $this->resize_gd($pic, $resize, $dirname);
                }
            //then add thumb information
            //same as basic image information
            $pic["medium"]["filename"]=$dirname."/".$pic["filename"];
            $this->pic_info_0($pic["thumb"]);
            }
        else{
            $this->get_imagesize($pic);
            $resize=$this->resize_calc($pic, "700","");
            $tmp=$pic;
            $pic["medium"]=$tmp;
            $pic["medium"]["imagesize"]["width"]=$resize["width"];
            $pic["medium"]["imagesize"]["height"]=$resize["height"];
            }
        }
    
    function resize_calc(&$pic, $max_width, $max_height){
        $width=$pic["imagesize"]["width"];
        $height=$pic["imagesize"]["height"];
        if($width>$height){
            if(isset($max_width) && strlen($max_width)){
                $resize_width=$max_width;
                $resize_height=(int)(($max_width*$height)/$width);
                }
            else{
                $resize_width=(int)(($max_height*$width)/$height);
                $resize_height=$max_height;
                }
            }
        else{
            if(isset($max_height) && strlen($max_height)){
                $resize_width=(int)(($max_height*$width)/$height);
                $resize_height=$max_height;
                }
            else{
                $resize_width=$max_width;
                $resize_height=(int)(($max_width*$height)/$width);
                }
            }    
        $arr=array();
        $arr["width"]=$resize_width;
        $arr["height"]=$resize_height;
        return $arr;
        }
    function resize_gd(&$pic, $resize, $dir, $quality="70"){
        switch($pic["imagesize"]["failtype"]){
            case "JPG":
                $im = imagecreatefromjpeg($pic["filename"]);
                break;
            case "PNG":
                $im = imagecreatefrompng($pic["filename"]);
                break;
            case "GIF":
                $im = imagecreatefromgif($pic["filename"]);
                break;
            default:
                break;
            }
        if(!$im){
            //do some stuff
            return;
            }
        //echo "here"; die();
        $width=$pic["imagesize"]["width"];
        $height=$pic["imagesize"]["height"];
        
        $im2=imagecreatetruecolor($resize["width"], $resize["height"]);
        
        if (function_exists("imageCopyResampled")){
            if (!@ImageCopyResampled($im2, $im, 0, 0, 0, 0, $resize["width"], $resize["height"], $width, $height)) {
                ImageCopyResized($im2, $im, 0, 0, 0, 0, $resize["width"], $resize["height"], $width, $height);
                }
            }
        else {
            ImageCopyResized($im2, $im, 0, 0, 0, 0, $resize["width"], $resize["height"], $width, $height);
            }
        imagejpeg($im2, $dir."/".$pic["filename"], $quality);
        }
    
    function make_str($var, $prefix="\$var"){
        if(!strlen($prefix)){
            $prefix="\$var";
            }
        $str="";
        if(is_array($var)){
            foreach($var as $key => $value){
                $str.=$this->make_str($value, $prefix."[\"".$key."\"]"); 
                }
            }
        else{
            $str.=$prefix."=\"".$var."\";\n";
            }
        return $str;
        }
    function save_file($file, $var=""){
        $str="<?php \n";
        $str.=$this->make_str($var);
        $str.="?>";
        $handle = fopen($file, "w");
        if(!$handle){
            echo "Cannot open file (".$file."). Make sure you have write permissions";
            }
        if (fwrite($handle, $str) === FALSE) {
            echo "Cannot write to file (".$file."). Make sure you have write permissions.";
            die();
            }
        fclose($handle);
        }
    function load_file($file){
        if(!is_file($file)){
            return;
            }
        include($file);
        return $var;
        }
    
    function load_pic_comment(&$pic){
        $dir="comments";
        $pic["comment"]=$this->load_file($dirname."/".$pic["filename"].".php");
        $pic["comment_count"]=count($pic["comment"]);
        }
    function load_pic_counter(&$pic){
        $dir="counter";
        $pic["counter"]=$this->load_file($dirname."/".$pic["filename"].".php");
        $pic["counter_count"]=count($pic["counter"]);
        $pic["counter_ip_count"]=$this->counter_ip($pic["counter"]);
        }
    function load_album_counter(){
        $data=$this->load_file($dirname."/counter.index.php");
        $kokku=$this->counter_ip($data);
        }
        
    function add_album_counter(){
        $file=$dirname."counter.index.php";
        $data=$this->load_file($file);
        $i=count($data);
        $var=array();
        $var[$i]["ip"]=$this->getip();
        $var[$i]["time"]=time();
        $var[$i]["referer"]=$_SERVER["HTTP_REFERER"];
        $file=$dirname."counter.index.php";
        if(is_file($file)){
            $size=1;
            }
        $str="";
        if(!$size){
            $str="<?php \n";
            }
        $str.=$this->make_str($var);
        $str.="?>";
        if($size){
            $handle = fopen($file, "r+");
            }
        else{
            $handle = fopen($file, "w");
            }
        if(!$handle){
            echo "Cannot open file (".$file."). Make sure you have write permissions";
            }
        if($size){
            fseek($handle, -2, SEEK_END);
            }
        if (fwrite($handle, $str) === FALSE) {
            echo "Cannot write to file (".$file."). Make sure you have write permissions.";
            die();
            }
        fclose($handle);
        }
    
    function counter_ip(&$arr){
        $return=array();
        if(!is_array($arr)){
            return 0;
            }
        foreach($arr as $key => $value){
            if(!in_array($value["ip"], $return)){
                $return[]=$value["ip"];
                }
            }
        return count($return);
        }
    
    function getip() {    
        if (isset($_SERVER)) {
            if (isset($_SERVER[HTTP_X_FORWARDED_FOR])) {
                $realip = $_SERVER[HTTP_X_FORWARDED_FOR];
                } 
            elseif (isset($_SERVER[HTTP_CLIENT_IP])) {
                $realip = $_SERVER[HTTP_CLIENT_IP];
                }
            else {
                $realip = $_SERVER[REMOTE_ADDR];
                }
            }
        else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $realip = getenv( "HTTP_X_FORWARDED_FOR");
                }
            elseif (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
                }
            else {
                $realip = getenv("REMOTE_ADDR");
                }
            }
        return $realip;
        }
    
    }

$picter= new picter();
$picter->source(".");


//var_dump($data);
$picter->assign_gallery(0);

$picter->add_album_counter();

//nl2br(var_dump($picter));
if(isset($_GET["pic_id"])){
    include("image_css.php");
    }
else{
    include("gallery_css.php");
    }
//phpinfo();
?>