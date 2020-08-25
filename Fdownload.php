<?php 
$idv=$_GET['id']; // if your souece get id please change v with id
$json = file_get_contents('http://www.saveitoffline.com/process/?url=http://www.youtube.com/watch?v='.$idv.'&type=json'); 
$json = json_decode($json); 
$name = $json->title;

if($json) 
{
foreach ($json->urls as $ambil)
{
$version = $ambil->label; 
$url = $ambil->id; 
$version = str_ireplace('(audio - no video)', '[Mp3] - ', $version);
$version = str_ireplace('[Mp3] - webm', 'MP3 - ', $version);
 
if(!preg_match('#no sound#',$version))

{
echo '<div class="downLink" align="center"><a class="downLink" href="'.$url.'"> Download <span style="color:white">'.$version.'</span></a></div>';

}
}
}

?>