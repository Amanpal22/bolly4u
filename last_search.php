<?php
$div = "| # |";
$dat = 'last_search.txt';
$fp=fopen($dat, 'r');
$count=fgets($fp);
fclose($fp);
$search = $q;
$search = str_replace('+', ' ', $search);
$data = explode($div, $count);
if (in_array($search, $data)) 
{
$tulis = implode($div, $data);
$hit=$tulis;
}
else 
{
$data = explode($div, $count);
$tulis = $data[1].''.$div.''.$data[2].''.$div.''.$data[3].''.$div.''.$data[4].''.$div.''.$data[5].''.$div.''.$data[6].''.$div.''.$data[7].''.$div.''.$data[8].''.$div.''.$data[9].''.$div;
$tulis .= $search;
$hit=$tulis;
}
$cuplissayangputri=fopen($dat, 'w');
fwrite($cuplissayangputri,$tulis);
fclose($cuplissayangputri);
$fa=fopen($dat, 'r');
$b=fgets($fa);
fclose($fa);
$c = explode($div, $b);
echo '<div class="pgn">';
echo '<h2>Recent Search : </h2>';
foreach(array_reverse($c) as $d)
{
echo '<a style="padding:1px;margin:2px;" href="/v/'.$d.'">'.$d.'</a>|';
}
echo '</div>';
?>
