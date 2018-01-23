<?php
$endereco_web = "localhost";
$data_hora_atual = date("Y-m-d H:i:s");

$accessKEY = "06725231"; 

//Dados API SMS ClickAtell
$ClickAtellEnabled = 0 ;
$UserClickAtell = urlencode("jrmcassa");
$PassClickAtell = urlencode("jr519cas601");
$APIClickAtell   = urlencode("3599126");

//Dados API SMS LocaSMS
$LocaSMSEnabled = 1 ;
$UserLocaSMS = urlencode(" ");
$PassLocaSMS = urlencode(" ");



date_default_timezone_set("America/Sao_Paulo");								
define('DEBUG', true);
error_reporting(E_ALL);
ini_set('display_errors', DEBUG ? 'On' : 'Off');
ini_set('log_errors', 0);
set_time_limit(0);
error_reporting(0);



	

?>