<?php
include 'includes/info.php';
echo '<h2>Related videos</h2>';
echo ''.$yllix.'';
$grab=ngegrab('https://www.googleapis.com/youtube/v3/search?key='.$devkey.'&part=snippet&maxResults=5&relatedToVideoId='.$_GET['id'].'&type=video');
$json = json_decode($grab);
if($json)
{
foreach($json->items as $hasil) 
{
$name = $hasil->snippet->title;
$link = $hasil->id->videoId;
$tgl = $hasil->snippet->publishedAt;
$date = dateyt($tgl);
$des = $hasil->snippet->description;
$chid = $hasil->snippet->channelId;
$linkmake = preg_replace("/[^A-Za-z0-9[:space:]]/","$1",$name);
$linkmake = str_replace(' ','-',$linkmake);
$final = strtolower("$linkmake");
include'v_list.php';
}
}
?>