<?php
require_once('../../bootstrap.php');
	require_once(CONFIG_LIB_PATH."model/class_db_mysql.inc");
	include_once(CONFIG_LIB_PATH."model/class_post.inc");
	include_once(CONFIG_LIB_PATH."model/class_dateformat.inc");
	include_once(CONFIG_LIB_PATH."model/class_profile.inc");

$com="";

$db = new Mysql_db;
$db->sql_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$profile = new Profile;

$CID=$_GET['id'];

switch ($_GET['t'])
{
	case 'hide':
		if ($profile->hide_gradpix($CID)) $message = "gradpix is now invisible";	
		else $message = "FAIL can't rename gradpix";	
	break;

	case 'show':
		if ($profile->show_gradpix($CID)) $message = "gradpix is now visible";	
		else $message = "FAIL can't rename gradpix";	
	break;
}

header("Location: classmate_edit.php?id=$CID&message=".$message); 



$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('blank.htm');

$db->sql_close();
?>