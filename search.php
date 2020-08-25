<?php
include 'includes/func.php';
if(!empty($_GET['q']))
{
$url='/v/'.$_GET['q'].'';
}
else
{
$url='/';
}
header('location:'.$url.''); 
?>