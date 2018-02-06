<?php
require_once('../bootstrap.php');
	require(CONFIG_LIB_PATH."model/class_db_mysql.inc");
	include_once(CONFIG_LIB_PATH."model/class_profile.inc");
	include_once(CONFIG_LIB_PATH."model/class_post.inc");
	include_once(CONFIG_LIB_PATH."model/class_dateformat.inc");

$db = new Mysql_db;
$db->sql_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$_GET['id']=0;
if(!isset($_GET['id'])) $_GET['id']=0;
$CID = $_GET['id'];

//display profile avatar + info + etc
$profile = new Profile;
include_once("display_profile.php");

//birthday
$df = new DateFormat;
include_once("display_birthdays.php");

$SFM->assign( 'SELF',CONFIG_REDIRECTURL.basename($_SERVER['SCRIPT_NAME']) );
$SFM->assign( 'SELFAV',"http://".$_SERVER['SERVER_NAME'].$pic2 );

///////////////////////////////////////////////////////////////// INDEX ////////////////////////////////////////////////////		
		//display writeup and post in post container
		//assign current tab
		$t0 = "current-cat";

		//classmate writeup
		if ( !empty($i[writeup])  )  $writeup = nl2br($i[writeup]);
		$SFM->assign( 'writeup',$writeup );
		
		//display posts
		$post = new Post;
		include_once("display_posts.php");
		$SFM->assign( 'fb_comments','yes' );

//assign tabs		
$tabs = "<li class=\"cat-item $t0\"><a href=\"index.php\">Wall</a></li>";
$tabs .= "<li class=\"cat-item $t1\"><a href=\"index_all.php\">Classmates</a></li>";
$tabs .= "<li class=\"cat-item $t2\"><a href=\"index_litratuwaan.php\">Litratuwaan</a></li>";
//$tabs .= "<li class=\"cat-item $t3\"><a href=\"\"></a></li>";
$tabs .= "<li class=\"cat-item $t4\"><a href=\"index_about.php\">About</a></li>";
$SFM->assign( 'tabs',$tabs );

$SFM->assign( 'hidewu', 'yes' );



//navi


$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('pisbuk.htm');

$db->sql_close();
?>