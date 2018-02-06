<?php
require_once('../bootstrap.php');
	require_once(CONFIG_LIB_PATH."model/class_db_mysql.inc");
	include_once(CONFIG_LIB_PATH."model/class_profile.inc");

$db = new Mysql_db;
$db->sql_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);


$_GET['r']="classmate";

if (!isset($_GET['r'])) $_GET['r']="classmate";
switch ($_GET['r'])
{
	case 'classmate':
		$profile = new Profile;
		$count = $profile->count_all_classmates();
		$id=rand( 1,($count - 1) );
		$redirect="classmate.php?id=$id";
		header('Location: '.$redirect);
//		$SFM->assign( 'ITEM',"classmate.php?id=".$id );
		break;	
/*
	case 'section':
		$profile = new Profile;
		$count = count($profile->count_sections());
		$id=rand($count);
		$SFM->assign( 'ITEM',$id );
		break;	
*/
}

//$SFM->compile_check = true;
//$SFM->debugging = true;
//$SFM->display('blank.htm');

$db->sql_close();
?>