<?php
include 'includes/func.php';
include 'includes/info.php';
$yf=ngegrab('https://www.googleapis.com/youtube/v3/videos?key='.$devkey.'&part=snippet,contentDetails,statistics,topicDetails&id='.$_GET['id'].'');
$yf=json_decode($yf);

// UTubeBd API here.

if($yf){
foreach ($yf->items as $item)
{

$name=$item->snippet->title;
$des = $item->snippet->description;
$date = dateyt($item->snippet->publishedAt);
$channelId = $item->snippet->channelId;
$chtitle = $item->snippet->channelTitle;
$ctd=$item->contentDetails;
$duration=format_time($ctd->duration);
$hd = $ctd->definition;
$st= $item->statistics;
$views = $st->viewCount;
$likes = $st->likeCount;
$dislike = $st->dislikeCount;
$favoriteCount = $st->favoriteCount;
$commentCount = $st->commentCount;
{$title=''.$name.'';}
$tag=$name;
$tag=str_replace(" ",",", $tag);
$dtag=$des;
include 'includes/config.php';
echo '<h1>'.$name.'</h1><br/>';
echo '<div class="play" align="center">';
echo '<iframe class="play" width="290" height="233" src="https://youtube.com/embed/'.$_GET["id"].'" frameborder="0" allowfullscreen></iframe></div>';

echo '<div class="ad1">';
echo '<table class="" style="width:100%">';
echo '<tr valign="top">';
echo '<td width="30%">Title</td>';
echo '<td>:</td>';
echo '<td><font color="black">'.$name.'</font></td>';
echo '</tr>';
echo '<tr valign="top">';
echo '<td width="30%">Duration</td>';
echo '<td>:</td>';
echo '<td>'.$duration.' Min</td>';
echo '</tr>';
echo '<tr valign="top">';
echo '<td width="30%">Channel</td>';
echo '<td>:</td>';
echo '<td>'.$chtitle.'</td>';
echo '</tr>';
echo '<tr valign="top">';
echo '<td width="30%">Uploaded At</td>';
echo '<td>:</td>';
echo '<td>'.$date.'</td>';
echo '</tr>';
echo '<tr valign="top">';
echo '<td width="30%">Views</td>';
echo '<td>:</td>';
echo '<td>'.$views.'</td>';
echo '</tr>';
echo '<tr valign="top">';
echo '<td width="30%">Likes</td>';
echo '<td>:</td>';
echo '<td>'.$likes.'</td>';
echo '</tr>';
echo '</table>';
echo '</div>';
echo' <div class="ad1"> <div class="topmenu"> <font color="red"><b>Tags: </b></font> '.$name.' free download. '.$name.' download Full Hd Songs. Download '.$name.'  full Mp3 song (320kbps). '.$name.'  Song Download, Mp4, 3gp, Avi, HD full Android, Pc.Download '.$name.'  official Print download DVDrip Vcdscam webrip Dvdscam download now</div></div>';
echo '<h2>Download File</h2>';
include'ad.php';
include'ttube.php';
include'ad.php';
include 'related.php';
}
}

include 'last_search.php';
include 'includes/foot.php';
?>