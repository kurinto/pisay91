<?php
/*
include_once('conf/global.conf');

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
	$URL_WRAP = 'https://';
    } else {
    	$URL_WRAP = 'http://';
}
if ($_SERVER["SERVER_PORT"]!=80 || $_SERVER["SERVER_PORT"]!=443) $URL_WRAP .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].URI_BASE; 
else $URL_WRAP .= $_SERVER["SERVER_NAME"].URI_BASE; 
*/
if (!isset($_SERVER['argv'][0])) $action="redirect"; else $action=$_SERVER['argv'][0];
switch ($action)
{
		case 'php':
			header('Location: conf/test_php.php');
		break;

		case 'mysql':
			header('Location: conf/test_mysql.php');
		break;

		case 'smarty':
			header('Location: conf/test_smarty.php');
		break;

		case 'thumbcache':
			header('Location: conf/test_thumbcache.php');
		break;

		case 'redirect':
			header('Location: app/');
		break;
}
if (isset($_GET['id'])) header('Location: app/');
?>
Oi! Something is wrong with the PHP installation :-(

