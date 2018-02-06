<?php
require_once('../bootstrap.php');
	require_once(CONFIG_LIB_PATH."model/class_db_mysql.inc");
	include_once(CONFIG_LIB_PATH."model/class_profile.inc");
	include_once(CONFIG_LIB_PATH."model/class_post.inc");
	include_once(CONFIG_LIB_PATH."model/class_dateformat.inc");

$db = new Mysql_db;
$db->sql_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

//$_GET['id']=0;
if(!isset($_GET['id'])) $_GET['id']=0;
$CID = $_GET['id'];
if ($CID == 0) header('Location: index.php');

//display profile avatar + info + etc
$profile = new Profile;
include_once("display_profile.php");

//birthday
$df = new DateFormat;
include_once("display_birthdays.php");

$SFM->assign( 'SELF',CONFIG_REDIRECTURL.basename($_SERVER['SCRIPT_NAME'])."?id=".$CID );
$SFM->assign( 'SELFAV',"http://".$_SERVER['SERVER_NAME'].$pic2 );

///////////////////////////////////////////////////////////////// CLASSMATE VIEW ////////////////////////////////////////////////////		

		$SFM->assign( 'fb_note',"$i[u_fb]'s latest FBposts" );
		$SFM->assign( 'u_fb',$i[u_fb] );
		$SFM->assign( 'tw_note',"$i[u_tw]'s latest tweets" );
		$SFM->assign( 'u_tw',$i[u_tw] );

		$posts = $SFM->fetch("item_feed.htm");

//assign tabs		
$tabs = "<li class=\"cat-item $t0\"><a href=\"classmate.php?id=".$CID."\">Wall</a></li>";
if ( !empty($i[sec_1]) )  $tabs .= "<li class=\"cat-item $t1\"><a href=\"classmate.php?id=$CID&s=$i[sec_1]\">$i[sec_1]</a></li>";
if ( !empty($i[sec_2]) )  $tabs .= "<li class=\"cat-item $t2\"><a href=\"classmate.php?id=$CID&s=$i[sec_2]\">$i[sec_2]</a></li>";
if ( !empty($i[sec_3]) )  $tabs .= "<li class=\"cat-item $t3\"><a href=\"classmate.php?id=$CID&s=$i[sec_3]\">$i[sec_3]</a></li>";
if ( !empty($i[sec_4]) )  $tabs .= "<li class=\"cat-item $t4\"><a href=\"classmate.php?id=$CID&s=$i[sec_4]\">$i[sec_4]</a></li>";
$SFM->assign( 'tabs',$tabs );

$SFM->assign( 'CID',$CID );

//display writeup
$SFM->assign( 'posts',$posts );

//display post

//navi

$maxid = $profile->count_all_classmates();
$nextid = $CID + 1; 
$previd = $CID - 1;

	if ($nextid < $maxid) $SFM->assign( 'next_classmate',"<a href=\"?id=$nextid\">Next Classmate</a>" );				
	else $SFM->assign( 'next_classmate','' );

	if ($previd > 0) $SFM->assign( 'prev_classmate',"<a href=\"?id=$previd\">Previous Classmate</a>" );				
	else $SFM->assign( 'prev_classmate','' );


$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('pisbuk.htm');

$db->sql_close();
?>