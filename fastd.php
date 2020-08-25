<?php
 /******************************************************\
 	@AUTHOR			PMESCO CREATIONS
 	@ABOUT			YOUTUBE DOWNLOADER
 	@VERSION		2.1
 	@WEBSITE		WWW.WAPMON.COM
	@CONTACT		SUPPORT@WAPMON.COM
 \******************************************************/

if(!empty($_GET['id'])){
	
	$data = getpage('https://www.youtube.com/watch?v='.$_GET['id'].'');
	
	preg_match('/ytplayer.config = {(.*?)};/',$data,$match);
	
	$o = json_decode('{'.$match[1].'}') ;
	$player = explode('s.ytimg.com/yts/jsbin/html5player-',$o->assets->js);
	$player = explode('/',$player[1]);
	$player = $player[0];
	$stream_map = $o->args->url_encoded_fmt_stream_map;
	$title = $o->args->title;
	$output = array();
	parse_str($stream_map,$output);
	$siglength = explode('.',$output['s']);
	$json = ''.md5(''.$player.'_'.strlen($siglength[0]).'.'.strlen($siglength[1]).'').'.json';
	
	if (!file_exists($json) || filesize($json) == 0){
		$algos = file_get_contents('http://developers.wapmon.com/api/youtube/algo?player_id='.$player.'&sl='.strlen($siglength[0]).'.'.strlen($siglength[1]).'');
		if($algos == 'error'){
			echo 'Unable to get data from Algo Server. Please contact us via email (support@wapmon.com)';
			exit;
		}
		else{
			$fp = fopen($json, "a");
			if(flock($fp, LOCK_EX)){
				fwrite($fp, $algos);
				flock($fp, LOCK_UN);
			}
			fclose($fp);
		}
	}
	
	
	echo '  <title>'.$title.' GetIndiaHost.Com</title>';
	
	generate_directlink($stream_map,md5(''.$player.'_'.strlen($siglength[0]).'.'.strlen($siglength[1]).''),$title);
	
}

function decipher($sig,$player){
	$algo = file(''.$player.'.json');
	$algo = explode('O',$algo[0]);
	foreach($algo as $arrange){
		$signature = str_split($sig);
		$decrypt .= $signature[$arrange];
	}
	return $decrypt;
}

function generate_directlink($stream_map,$player,$title){
	$links = explode(',',$stream_map);
	foreach($links as $link){
		parse_str($link,$r);
		$dllink = explode('.googlevideo.com/',$r['url']);
		$dllink = 'https://redirector.googlevideo.com/'.$dllink[1].'&title='.rawurlencode($title).'';
		$links = 'video/'.$r['itag'].'';
		$links = str_ireplace('video/5','Download as FLV (240p)',$links);
		$links = str_ireplace('video/17','Download as 3GP (144p)',$links);
		$links = str_ireplace('video/18','Download as MP4 (360p)',$links);
		$links = str_ireplace('video/22','Download as MP4 (720p)',$links);
		$links = str_ireplace('video/34','Download as FLV (360p)',$links);
		$links = str_ireplace('video/35','Download as FLV (480p)',$links);
		$links = str_ireplace('video/36','Download as 3GP (240p)',$links);
		$links = str_ireplace('video/37','Download as MP4 (1080p)',$links);
		$links = str_ireplace('video/38','Download as MP4 (1080p)',$links);
		$links = str_ireplace('video/43','Download as WebM (360p)',$links);
		$links = str_ireplace('video/44','Download as WebM (480p)',$links);
		$links = str_ireplace('video/45','Download as WebM (720p)',$links);
		$links = str_ireplace('video/46','Download as WebM (1080p)',$links);
		$links = str_ireplace('video/82','Download as MP4 (360p 3D)',$links);
		$links = str_ireplace('video/83','Download as MP4 (480p 3D)',$links);
		$links = str_ireplace('video/84','Download as MP4 (720p 3D)',$links);
		$links = str_ireplace('video/85','Download as MP4 (1080p 3D)',$links);
		$links = str_ireplace('video/100','Download as WebM (360p 3D)',$links);
		$links = str_ireplace('video/101','Download as WebM (480p 3D)',$links);
		$links = str_ireplace('video/133','Download as MP4 (240p VO)',$links);
		$links = str_ireplace('video/134','Download as MP4 (360p VO)',$links);
		$links = str_ireplace('video/135','Download as MP4 (480p VO)',$links);
		$links = str_ireplace('video/136','Download as MP4 (720p VO)',$links);
		$links = str_ireplace('video/137','Download as MP4 (1080p VO)',$links);
		$links = str_ireplace('video/139','Download as MP4 (Low bitrate AO)',$links);
		$links = str_ireplace('video/140','Download as MP4 (Med bitrate AO)',$links);
		$links = str_ireplace('video/141','Download as MP4 (Hi bitrate AO)',$links);
		$links = str_ireplace('video/160','Download as MP4 (144p VO)',$links);
		$links = str_ireplace('video/171','Download as WebM (Med bitrate AO)',$links);
		$links = str_ireplace('video/172','Download as WebM (Hi bitrate AO)',$links);
		$links = str_ireplace('video/242','Download as WebM (240p VOX)',$links);
		$links = str_ireplace('video/243','Download as WebM (360p VOX)',$links);
		$links = str_ireplace('video/244','Download as WebM (480p VOX)',$links);
		$links = str_ireplace('video/245','Download as WebM (480p VOX)',$links);
		$links = str_ireplace('video/246','Download as WebM (480p VOX)',$links);
		$links = str_ireplace('video/247','Download as WebM (720p VOX)',$links);
		$links = str_ireplace('video/248','Download as WebM (1080p VOX)',$links);
		$links = str_ireplace('video/264','Download as MP4 (1080p VO)',$links);
		echo '<div class="catRow"><a href="'.$dllink."&signature=".decipher($r['s'],$player).'">'.$links.'</a></div>';
    }
}

function getpage($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}

if(empty($_GET['id'])){
	echo '<form action=""><input type="text" name="id" placeholder="YOUTUBE ID" value=""><input type="submit" value="Submit"></form>';
}

?>