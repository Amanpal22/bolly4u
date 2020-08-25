<?php
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
<div><iframe src="http://downloadnee.com/api?id='.$_GET["id"].'&format=mp4" width="120" height="300" scrolling="no" style="border:none;"></iframe></div>';
?>