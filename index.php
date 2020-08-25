<?php
include 'includes/func.php';

$title  = 'GetIndiaHost.Com :: Bhojpuri New Album, Bhojpuri New Movies, South Movies All Type Video Download'; //Edit Homepage Title

include 'includes/config.php';
include'ad.php';
echo'<h1>Futured File</h1>';
if($_GET['q']){
$q = $_GET['q'];
} else {
$a = array("New DJ Song 2018","Happy New Year 2018 DJ Song");
$b = count($a)-1;
$q = $a[rand(0,$b)];
}
$qu=$q;
$qu=str_replace(" ","+", $qu);
$qu=str_replace("-","+", $qu);
$qu=str_replace("_","+", $qu);
if(strlen($_GET['page']) >1){$yesPage=$_GET['page'];}
else{$yesPage='';}
$grab=ngegrab('https://www.googleapis.com/youtube/v3/search?key='.$devkey.'&part=snippet&order=relevance&maxResults=10&q='.$qu.'&pageToken='.$yesPage.'&type=video');
$json = json_decode($grab);
$nextpage=$json->nextPageToken;
$prevpage=$json->prevPageToken;
if($json)
{
foreach ($json->items as $sam)
{
$link= $sam->id->videoId;
$name= $sam->snippet->title;
$desc = $sam->snippet->description;
$chtitle = $sam->snippet->channelTitle;
$chid = $sam->snippet->channelId;
$date = dateyt($sam->snippet->publishedAt);
$sam = ngegrab('https://www.googleapis.com/youtube/v3/videos?key='.$devkey.'&part=contentDetails,statistics&id='.$link.'');
$linkmake = preg_replace("/[^A-Za-z0-9[:space:]]/","$1",$name);
$linkmake = str_replace(' ','-',$linkmake);
$final = strtolower("$linkmake");
$dt=json_decode($sam);
foreach ($dt->items as $dta){
$time=$dta->contentDetails->duration;
$duration= format_time($time);
$views= $dta->statistics->viewCount;   
}
echo '<div class="fl odd">
<a class="fileName" href="/d/'.$link.'/'.$final.'-GetIndia.html"><div><div><img src="https://i.ytimg.com/vi/'.$link.'/default.jpg" alt="'.$name.'"/></div><div>'.$name.'</div></div></a></div>';

}
include'ad.php';
include'includes/ucweb.php';
echo '<div class="pgn" style="text-align:center;">';
if (strlen($prevpage)>1)
{
echo '<a href="/v/'.uncleaned($q).'&page='.$prevpage.'" class="link1">&#171;Prev</a> ';}
if (strlen($nextpage)>1)
{
echo '<a href="/v/'.uncleaned($q).'&page='.$nextpage.'" class="link2">Next&#187;</a>';
}
echo '</div>';
}

echo '<h2>Select Category</h2>';
include'category.php';
include 'last_search.php';
include 'includes/foot.php';
?>