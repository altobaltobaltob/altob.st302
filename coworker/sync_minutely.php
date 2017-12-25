<?php
/*
file: sync minutely       �۰ʩI�s
*/           
                                                    
// �����@�γ]�w��
require_once '/home/bigbang/apps/coworker/station.config.php'; 

define('APP_NAME', 'sync_minutely');    // application name

// �o�Ϳ��~�ɶ����b���B�z
function error_handler($errno, $errstr, $errfile, $errline, $errcontext)
{         
	$str = date('H:i:s')."|{$errstr}|{$errfile}|{$errline}|{$errno}\n";               
	error_log($str, 3, LOG_PATH.APP_NAME . '.' . date('Ymd').'.log.txt');   // 3�N��Ѧҫ᭱���ɦW
}

set_error_handler('error_handler', E_ALL);

trigger_error('..start..');

try
{
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost/carpark.html/sync_minutely");			// TASK: sync
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, FALSE);
    $output = curl_exec($ch);
    curl_close($ch);
}
catch(Exception $e)
{
	trigger_error('ERROR: ' . $e->getMessage());
}

sleep(1);

try
{
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost/mitac_service.html/echo_mitac_alive");	// TASK: MITAC alive check
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_POST, FALSE);
    $output = curl_exec($ch);
    curl_close($ch);
}
catch(Exception $e)
{
	trigger_error('ERROR: ' . $e->getMessage());
}

trigger_error('..completed..');