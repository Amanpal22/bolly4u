<?php
error_reporting(0);
function ngegrab($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$uaa = $_SERVER['HTTP_USER_AGENT'];
    curl_setopt($ch, CURLOPT_USERAGENT, "User-Agent: $uaa");

    return curl_exec($ch);
}
function samgrab($url){$ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch,CURLOPT_ENCODING,'gzip');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '1');
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$header[] = "Accept-Language: en";
$header[] = "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3
";
$header[] = "Pragma: no-cache";
$header[] = "Cache-Control: no-cache";
$header[] = "Accept-Encoding: gzip,deflate";
$header[] = "Content-Encoding: gzip";
$header[] = "Content-Encoding: deflate";
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$load = curl_exec($ch);
curl_close($ch);
return $load;}

$devkey='AIzaSyAlSVLiUvb073IXrTQ0BiNY_N5pa3FBI9M'; // YouTube developer API



function sam($content,$start,$end){
if($content && $start && $end) {
$r = explode($start, $content);
if (isset($r[1])){
$r = explode($end, $r[1]);
return $r[0];}
return '';}}
function format_time($t) {
$sam = str_replace('PT','',$t);
$sam = str_replace('H',':',$sam);
$sam = str_replace('M',':',$sam);
$sam = str_replace('S','',$sam);
return $sam;}
/*
function write_to_file($q)
{$filename = 'sitemap.txt';
$fh = fopen($filename, "a");
if(flock($fh, LOCK_EX))
{fwrite($fh, $q);
flock($fh, LOCK_UN);}
fclose($fh);}
*/
function dateyt($date)
{
	$sam = str_replace('T',' ',$date);
	$sam = str_replace('.000Z','',$sam);
	return $sam;
}

$x0b="array_slice"; 
$x0c="curl_init"; 
$x0d="curl_setopt"; 
$x0e="curl_exec"; 
$x0f="curl_close"; 
$x10="date"; 
$x11="explode"; 
$x12="fclose"; 
$x13="flock"; 
$x14="floor"; 
$x15="fopen"; 
$x16="fwrite"; 
$x17="implode"; 
$x18="mktime"; 
$x19="preg_replace"; 
$x1a="str_replace"; 
$x1b="strtolower"; 
$x1c="substr"; 

function uncleaned($string){ 
			global $x0b,$x0c,$x0d,$x0e,$x0f,$x10,$x11,$x12,$x13,$x14,$x15,$x16,$x17,$x18,$x19,$x1a,$x1b,$x1c; $string = $x19('/[^A-Za-z0-9_\s-]/','',$string);
			$string = $x19('/[\s-]-/',' ',$string);
			$string = $x19('/[\s_]/','+',$string);
			return $x1b($string);
			}


?>