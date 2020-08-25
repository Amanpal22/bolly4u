<?php
$url = 'https://youtube.com/watch?v='.$_GET['v'].'';

$cmd =' youtube-dl -g -f36  ' . escapeshellarg($url);
exec($cmd, $outputsd);

$results = print_r($outputsd[0], true);
$pat = '/^(https:\/\/)[a-zA-Z0-9\-.]+.googlevideo.com\//';
$results1 = preg_replace($pat, 'https://redirector.googlevideo.com/', $results);
$cmd2 =' youtube-dl -g -f18  ' . escapeshellarg($url);
exec($cmd2, $outputss);

$results2 = print_r($outputss[0], true);
$results3 = preg_replace($pat, 'https://redirector.googlevideo.com/', $results2);

$cmd3 =' youtube-dl -g -f22   ' . escapeshellarg($url);
exec($cmd3, $outputsss);
$results4 = print_r($outputsss[0], true);
$results5 = preg_replace($pat, 'https://redirector.googlevideo.com/', $results4);

$cmd4 =' youtube-dl -g -f17  ' . escapeshellarg($url);
exec($cmd4, $outputssss);

$name =' youtube-dl -e ' .  escapeshellarg($url);
exec($name, $outputs);
echo '<a href="'.$outputssss[0].'&title=[yoursite]'.$outputs[0].'.3gp">Download 3gp 176x144p</a>
<br/>
<a href="'.$results1.'&title=[yoursite]'.$outputs[0].'.mp4">Download MP4 320x240p</a><br/><a href="'.$results3.'&title=[yoursite]'.$outputs[0].'.mp4">Download MP4 640x360p</a><br/><a href="'.$results5.'&title=[yoursite]'.$outputs[0].'.mp4">Download MP4 HD720p</a><br/>
';
?>