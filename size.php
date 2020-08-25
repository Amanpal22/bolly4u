<?php
$site = $_GET['site'];
$site = ''.$sitetitle.'';
include 'curl.php';
include 'config.php';
include 'ytdl/01_key-update.php';
$decrypt_key = get_key();
if(isset($_GET['query']))
{
$q = urldecode($_GET['query']);
$search_result = new Youtube_Search($q);
$search_result = $search_result->outputdata;
}
else
{
if(isset($_GET["id"]))
{
$link = urldecode($_GET['id']);
if(strlen($link) == 11)
{
$linkvideo = "https://youtube.com/watch?v=".$link;
}
else
{
$linkvideo = $link;
}
}
else
{
$lastest = file_get_contents('lastest');
if (filter_var($lastest, FILTER_VALIDATE_URL) === false)
{
$lastest = 'https://www.youtube.com/watch?v='.$_GET['v'].'';
}
$linkvideo = $lastest;
}
$video = new Youtube_Grabber($linkvideo);
$video->decryptkey = $decrypt_key;
$video->GetVideoData();
}
for($i = 0;$i < count($video->videodata['map']);$i++)
{
$dlinks = '<div class="downLink" align="center"><a class="downLink" href="'.$video->videodata['map'][$i][2].'&title=('.$site.')_'.$video->videodata['map'][$i][7].'">'.$video->videodata['map'][$i][6].'</a> ('.$video->videodata['map'][$i][4].')</div>';
$dlinks = str_ireplace('<a href="'.$video->videodata['map'][$i][2].'&title=('.$site.')_'.$video->videodata['map'][$i][7].'">Download WebM (360p 3D) <span class="downLink">'.$video->videodata['map'][$i][4].'</a>','',$dlinks);
//$dlinks = str_ireplace('<a href="'.$video->videodata['map'][$i][2].'&title=('.$site.')_'.$video->videodata['map'][$i][7].'">Download WebM (360p) '.$video->videodata['map'][$i][4].'</a>','',$dlinks);
$dlinks = str_ireplace('<a href="'.$video->videodata['map'][$i][2].'&title=('.$site.')_'.$video->videodata['map'][$i][7].'">Download MP4 (720p 3D) '.$video->videodata['map'][$i][4].'</a>','',$dlinks);
$dlinks = str_ireplace('<a href="'.$video->videodata['map'][$i][2].'&title=('.$site.')_'.$video->videodata['map'][$i][7].'">Download Mp4 (360p 3D) '.$video->videodata['map'][$i][4].'</a>','',$dlinks);
//$dlinks = str_ireplace('<a href="'.$video->videodata['map'][$i][2].'&title=('.$site.')_'.$video->videodata['map'][$i][7].'">Download FLV (240p) '.$video->videodata['map'][$i][4].'</a>','',$dlinks);
$dlinks = str_ireplace('<a href="'.$video->videodata['map'][$i][2].'&title=('.$site.')_'.$video->videodata['map'][$i][7].'">78 '.$video->videodata['map'][$i][4].'</a>','',$dlinks);
echo $dlinks;
}
?>

<?php
class Curl
{
public $url;
public $method = 'get';
public $useragent = 'Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3';
public $referer = 'https://www.google.com/';
public $cookiefile;
public $postfield;
public $header = array();
public $output;
private $curl;
function SetUp($url)
{
$this->url = $url;
$this->curl = curl_init();
curl_setopt ($this->curl, CURLOPT_URL, $this->url);
curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($this->curl, CURLOPT_AUTOREFERER, true);
curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($this->curl, CURLOPT_USERAGENT, $this->useragent);   
}
function SetUseragent($useragent)
{
$this->useragent = $useragent;
curl_setopt($this->curl, CURLOPT_USERAGENT, $this->useragent);
}
function SetPosts($postfield)
{
$this->postfield = $postfield;
curl_setopt($this->curl, CURLOPT_POST, 1);
curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->postfield);
}
function SetCookie($cookiefile)
{
$this->cookiefile = $cookiefile;
curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookiefile);
curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookiefile);
}
function SetHeader($header)
{
$this->header = $header;
curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->header);
}
function SetFollow($follow) // $follow is True or False
{
curl_setopt ($this->curl, CURLOPT_FOLLOWLOCATION, $follow);
}
function CExec()
{
$html = curl_exec ($this->curl);
curl_close ($this->curl);
$this->output = $html;
return $this->output;
}
}
?>
<?php
error_reporting(0);
function get_key()
{
$youtube = getpage("https:/youtube.com/watch?ajax=1&layout=mobile&tsp=1&utcoffset=420&v=09R8_2nJtjg");
$youtube = str_replace(")]}'","",$youtube);
$contents = json_decode($youtube, true);
$link = 'http:'.$contents['content']['swfcfg']['assets']['js'];
$vcode = $contents['content']['swfcfg']['sts'];

$js = getpage($link);
$xcode = GetBetween($js,'a=a.split("");',';return a.join("")');
$xcode = str_replace('a,','',$xcode);
$xcode = str_replace(PHP_EOL,'',$xcode);
$xcode2 = GetBetween($js,'var '.substr($xcode, 0,2).'={','};');
$xcode2 = str_replace('a,b','a',$xcode2);
$xcode = str_replace(substr($xcode, 0,2).'.','',$xcode);
$xcode = str_replace('(','',$xcode);
$xcode = str_replace(')','',$xcode);

$xcode_ex = explode(";",$xcode);
$xcode2_ex = explode(PHP_EOL,$xcode2);
$nArray = array();

for($i = 0;$i<count($xcode2_ex);$i++)
{
    $tmp = explode(':',$xcode2_ex[$i]);
    $n = $tmp[0];
    $m = $tmp[1];
    $nArray[$n] = $m;
}
$xhtml = $vcode." ";
for($y = 0;$y < count($xcode_ex);$y++)
{
    $a = substr($xcode_ex[$y], 0,2);
    $b = substr($xcode_ex[$y], 2,4);
    $xhtml .= decode($a,$b,$nArray);
    $xhtml .= ' ';
}
$xhtml .= "';";
$xhtml = str_replace(" ';","",$xhtml);
return $xhtml;
//return 'w26 s3 r s3 r s3 w61 s3 r';
}
//Echo "New key is : " . $xhtml;
function GetBetween($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}
function decode($value,$num,$source)
{
    $result = '';
    if(strpos($source[$value],'reverse') !== FALSE)
    {
        $result = 'r';
    }
    else if(strpos($source[$value],'a.splice') !== FALSE)
    {
        $result = 's'.$num;
    }
    else
    {
        $result = 'w'.$num;
    }
    return $result;
}
function getpage($url)
{
    // fetch data
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 5.0; ASUS_T00J Build/LRX21V) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.133 Mobile Safari/537.36');
    $data = curl_exec($curl);
    curl_close($curl);
    //return preg_replace('~[\r\n]+~', ' ', $data);
    return $data;
}
?><?php
class Youtube_Grabber extends Curl
{
public $link;
public $videoid;
public $videoinfolink;
public $error;
public $videodata = array();
public $outputdata;
public $decryptkey;
function __construct($link)
{
$this->link = $link;
$this->GerVideoInfoLink($this->link);
parent::SetUp($this->videoinfolink);
$this->outputdata = parent::CExec();
}
function GetVideoData()
{
$strings = array();
$s = $sig = $url = $type = $quality = $size = '';
$expire = time();
parse_str($this->outputdata,$strings);
$this->videodata['img'] = $strings['iurl'];
$this->videodata['title'] = $strings['title'];
$this->videodata['ctitle'] = $this->clean($strings['title']);
$this->videodata['duration'] = gmdate("H:i:s", $strings['length_seconds']);;
$this->videodata['description'] = $this->get_description($this->link);
if($strings['adaptive_fmts'])
{
$string = explode(",", $strings['adaptive_fmts']);
for($i=0;$i<count($string);$i++)
{
parse_str($string[$i]);
if (strlen($type) > 5)
{
$type = explode(";", $type);
$type = $type[0];
}
$url = urldecode($url);
$quality = $size;
if(strlen($s) > 10)
{
$s = $this->DecryptYouTubeCypher($s,$this->decryptkey);
$url = $url . '&signature=' .$s;
}
$url = $url;
$title= $this->videodata['ctitle'];
$size = $this->get_size($url);
$size = $this->formatBytes($size);
$link = explode('.googlevideo.com/',$url);
$link = 'https://redirector.googlevideo.com/'.$link[1].'';
if($itag == '137')
{
$this->videodata['137'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '140')
{
$this->videodata['140'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '136')
{
$this->videodata['136'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '135')
{
$this->videodata['135'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '134')
{
$this->videodata['134'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '133')
{
$this->videodata['133'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '160')
{
$this->videodata['160'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '251')
{
$this->videodata['251'] = array('$type',$clen,$url,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '171')
{
$this->videodata['171'] = array('$type',$clen,$url,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '250')
{
$this->videodata['250'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
if($itag == '249')
{
$this->videodata['249'] = array('$type',$clen,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
}
if($strings['url_encoded_fmt_stream_map'])
{
$string = explode(",", $strings['url_encoded_fmt_stream_map']);
for($i=0;$i<count($string);$i++)
{
parse_str($string[$i]);
if (strlen($type) > 5)
{
$type = explode(";", $type);
$type = $type[0];
}
$url = urldecode($url);
if(strlen($s) > 10)
{
$s = $this->DecryptYouTubeCypher($s,$this->decryptkey);
$url = $url . '&signature=' .$s;
}
$url = $url;
$title= $this->videodata['ctitle'];
$size = $this->get_size($url);
$size = $this->formatBytes($size);
$itag = str_ireplace('22','Download MP4 (720p) ',$itag);
$itag = str_ireplace('34','Download FLV (360p)',$itag);
$itag = str_ireplace('35','Download FLV (480p)',$itag);
$itag = str_ireplace('36','Download 3GP (240p)',$itag);
$itag = str_ireplace('37','Download MP4 (1080p)',$itag);
$itag = str_ireplace('38','Download MP4 (1080p)',$itag);
$itag = str_ireplace('43','Download WebM (360p)',$itag);
$itag = str_ireplace('44','Download WebM (480p)',$itag);
$itag = str_ireplace('45','Download WebM (720p)',$itag);
$itag = str_ireplace('46','Download WebM (1080p)',$itag);
$itag = str_ireplace('82','Download MP4 (360p 3D)',$itag);
$itag = str_ireplace('83','Download MP4 (480p 3D)',$itag);
$itag = str_ireplace('84','Download MP4 (720p 3D)',$itag);
$itag = str_ireplace('85','Download MP4 (1080p 3D)',$itag);
$itag = str_ireplace('100','Download WebM (360p 3D)',$itag);
$itag = str_ireplace('101','Download WebM (480p 3D)',$itag);
$itag = str_ireplace('133','Download MP4 (240p VO)',$itag);
$itag = str_ireplace('134','Download MP4 (360p VO)',$itag);
$itag = str_ireplace('135','Download MP4 (480p VO)',$itag);
$itag = str_ireplace('136','Download MP4 (720p VO)',$itag);
$itag = str_ireplace('137','Download MP4 (1080p VO)',$itag);
$itag = str_ireplace('139','Download MP4 (Low bitrate AO)',$itag);
$itag = str_ireplace('140','Download MP4 (Med bitrate AO)',$itag);
$itag = str_ireplace('141','Download MP4 (Hi bitrate AO)',$itag);
$itag = str_ireplace('160','Download MP4 (144p VO)',$itag);
$itag = str_ireplace('171','Download WebM (Med bitrate AO)',$itag);
$itag = str_ireplace('172','Download WebM (Hi bitrate AO)',$itag);
$itag = str_ireplace('242','Download WebM (240p VOX)',$itag);
$itag = str_ireplace('243','Download WebM (360p VOX)',$itag);
$itag = str_ireplace('244','Download WebM (480p VOX)',$itag);
$itag = str_ireplace('245','Download WebM (480p VOX)',$itag);
$itag = str_ireplace('246','Download WebM (480p VOX)',$itag);
$itag = str_ireplace('247','Download WebM (720p VOX)',$itag);
$itag = str_ireplace('248','Download WebM (1080p VOX)',$itag);
$itag = str_ireplace('264','Download MP4 (1080p VO)',$itag);
$itag = str_ireplace('5','Download FLV (240p)',$itag);
$itag = str_ireplace('17','Download 3GP (144p)',$itag);
$itag = str_ireplace('18','Download MP4 (360p)',$itag);
$link = explode('.googlevideo.com/',$url);
$link = 'https://redirector.googlevideo.com/'.$link[1].'';
$this->videodata['map'][] = array($type,$quality,$link,date("G:i:s T", $expire),$size,$s,$itag,$title);
}
}
}
}
function GerVideoInfoLink($link)
{
$this->GetVideoID($link);
$this->videoinfolink = 'https://www.youtube.com/get_video_info?&video_id='. $this->videoid. '&asv=3&el=detailpage&hl=en_US';
}
function GetVideoID($link)
{
$url   = parse_url($link);
$my_id = NULL;
if( is_array($url) && count($url)>0 && isset($url['query']) && !empty($url['query']))
{
$parts = explode('&',$url['query']);
if( is_array($parts) && count($parts) > 0 )
{
foreach( $parts as $p )
{
$pattern = '/^v\=/';
if(preg_match($pattern, $p))
{
$my_id = preg_replace($pattern,'',$p);
$this->videoid = $my_id;
return $my_id;
break;
}
}
if(!$my_id)
{
$this->error = '<p>No video id passed in</p>';
$this->Error();
}
}
}
else
{
$this->error = '<p>Invalid url</p>';
$this->Error();
}
}
function Error()
{
die($this->error);
}
function get_size($url)
{
$my_ch = curl_init();
curl_setopt($my_ch, CURLOPT_URL,$url);
curl_setopt($my_ch, CURLOPT_HEADER,         true);
curl_setopt($my_ch, CURLOPT_NOBODY,         true);
curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($my_ch, CURLOPT_TIMEOUT,        20);
$r = curl_exec($my_ch);
foreach(explode("\n", $r) as $header)
{
if(strpos($header, 'Content-Length:') === 0)
{
return trim(substr($header,16));
}
}
return '';
}
function get_description($url)
{
$my_ch = curl_init();
curl_setopt($my_ch, CURLOPT_URL,$url);
curl_setopt($my_ch, CURLOPT_HEADER,true);
curl_setopt($my_ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($my_ch, CURLOPT_FOLLOWLOCATION,true);
$content = curl_exec($my_ch);
$r = explode('<p id="eow-description" >', $content);
if (isset($r[1]))
{
$r = explode('</p></div>', $r[1]);
return $r[0];
}
else
{
return '';
}
}
function formatBytes($bytes, $precision = 2)
{
$units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
$bytes = max($bytes, 0);
$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
$pow = min($pow, count($units) - 1);
$bytes /= pow(1024, $pow);
return round($bytes, $precision) . '' . $units[$pow];
}
function DecryptYouTubeCypher($s,$key)
{
$method = explode(" ",$key);
foreach($method as $m)
{
if($m == 'r')
$s = strrev($s);
else if( substr($m,0,1) == 's')
$s = substr($s, (int) substr($m,1) );
else if( substr($m,0,1) == 'w')
$s = $this->swap($s, (int) substr($m,1));
}
return $s;
}
function swap($a, $b)
{
$c = $a[0];
$a[0] = $a[$b];
$a[$b] = $c;
return $a;
}
function clean($string)
{
$string = preg_replace('/[^A-Za-z0-9_\s-]/', '', $string);
$string = preg_replace('/[\s-]+/', ' ', $string);
$string = preg_replace('/[\s_]/', '_', $string);
return $string;
}
}
?>