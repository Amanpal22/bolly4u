
<?php

/*
 * Developed By ArkTeam.In 
 * YouTube Grabber Script
 * Buy Cheap Domain at https://ArkTeam.In/
 */

include_once('curl.php');

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'); 
    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 
    $bytes /= pow(1024, $pow);
    return round($bytes, $precision) . '' . $units[$pow]; 
} 
if(isset($_REQUEST['id'])) {
	$my_id = $_REQUEST['id'];
} else {
	echo '<p>No video id passed in</p>';
	exit;
}

if(isset($_REQUEST['type'])) {
	$my_type =  $_REQUEST['type'];
} else {
	$my_type = 'redirect';
}

if(isset($_REQUEST['debug'])) {
	$debug = TRUE;
} else {
	$debug = FALSE;
}

if ($my_type == 'Download') {
?>



	
<?php
} // end of if for type=Download

/* First get the video info page for this video id */
$my_video_info = 'https://www.youtube.com/get_video_info?&video_id='. $my_id.'&asv=3&el=detailpage&hl=en_US';
$my_video_info = curlGet($my_video_info);

/* TODO: Check return from curl for status code */

$thumbnail_url = $title = $url_encoded_fmt_stream_map = $type = $url = '';

parse_str($my_video_info);

$my_title = $title;

if(isset($url_encoded_fmt_stream_map)) {
	/* Now get the url_encoded_fmt_stream_map, and explode on comma */
	$my_formats_array = explode(',',$url_encoded_fmt_stream_map);
	//if($debug) {
	//	echo '<pre>';
	//	print_r($my_formats_array);
	//	echo '</pre>';
	//}
} else {
	echo '<p>No encoded format stream found.</p>';
	echo '<p>Here is what we got from YouTube:</p>';
	echo $my_video_info;
}
if (count($my_formats_array) == 0) {
	echo '<p>No format stream map found - was the video id correct?</p>';
	exit;
}

/* create an array of available download formats */
$avail_formats[] = '';
$i = 0;
$ipbits = $ip = $itag = $sig = $quality = '';
$expire = time(); 
foreach($my_formats_array as $format) {
	parse_str($format);
	$avail_formats[$i]['itag'] = $itag;
        $quality = str_replace('hd720', 'HD 720p', $quality);
        $quality = str_replace('medium', '360p', $quality);
        $quality = str_replace('small', '240p', $quality);
        $avail_formats[$i]['quality'] = $quality;
        $type = str_replace('video/webm', 'WebM', $type);
        $type = str_replace('video/x-flv', 'FLV 240p', $type);
        $type = str_replace('video/3gpp', '3GP', $type);
        $type = str_replace('video/mp4', 'Mp4', $type);
	$type = explode(';',$type);
	$avail_formats[$i]['type'] = $type[0];
	$avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
	parse_str(urldecode($url));
	$avail_formats[$i]['expires'] = date("G:i:s T", $expire);
	$avail_formats[$i]['ipbits'] = $ipbits;
	$avail_formats[$i]['ip'] = $ip;
	$i++;
}

if ($debug) {
	
	
}
if ($my_id = $_REQUEST['id']) {
	

	/* now that we have the array, print the options */
	for ($i = 0; $i < count($avail_formats); $i++) {
		echo '<div class="downLink" align="center"><a class="downlink" rel="nofollow" href="' . $avail_formats[$i]['url'] . '&title='. urlencode($my_title) .' (VdWeb.Com)"> Download ' . $avail_formats[$i]['type'] . ' ' .  $avail_formats[$i]['quality'] . '</a></div>';
	}
	echo '';
?>


<?php

} else {

/* In this else, the request didn't come from a form but from something else
 * like an RSS feed.
 * As a result, we just want to return the best format, which depends on what
 * the user provided in the url.
 * If they provided "format=best" we just use the largest.
 * If they provided "format=free" we provide the best non-flash version
 * If they provided "format=ipad" we pull the best MP4 version
 *
 * Thanks to the python based youtube-dl for info on the formats
 *   							https://rg3.github.com/youtube-dl/
 */

$format =  $_REQUEST['format'];
$target_formats = '';
switch ($format) {
	case "best":
		/* largest formats first */
		$target_formats = array('38', '37', '46', '22', '45', '35', '44', '34', '18', '43', '6', '5', '17', '13');
		break;
	case "free":
		/* Here we include WebM but prefer it over FLV */
		$target_formats = array('38', '46', '37', '45', '22', '44', '35', '43', '34', '18', '6', '5', '17', '13');
		break;
	case "ipad":
		/* here we leave out WebM video and FLV - looking for MP4 */
		$target_formats = array('37','22','18','17');
		break;
	default:
		/* If they passed in a number use it */
		if (is_numeric($format)) {
			$target_formats[] = $format;
		} else {
			$target_formats = array('38', '37', '46', '22', '45', '35', '44', '34', '18', '43', '6', '5', '17', '13');
		}
	break;
}

/* Now we need to find our best format in the list of available formats */
$best_format = '';
for ($i=0; $i < count($target_formats); $i++) {
	for ($j=0; $j < count ($avail_formats); $j++) {
		if($target_formats[$i] == $avail_formats[$j]['itag']) {
			//echo '<p>Target format found, it is '. $avail_formats[$j]['itag'] .'</p>';
			$best_format = $j;
			break 2;
		}
	}
}

//echo '<p>Out of loop, best_format is '. $best_format .'</p>';
if( (isset($best_format)) && 
  (isset($avail_formats[$best_format]['url'])) && 
  (isset($avail_formats[$best_format]['type'])) 
  ) {
	$redirect_url = $avail_formats[$best_format]['url'];
	$content_type = $avail_formats[$best_format]['type'];
}
if(isset($redirect_url)) {
	header("Location: $redirect_url"); 
}

} // end of else for type not being Download
?>
