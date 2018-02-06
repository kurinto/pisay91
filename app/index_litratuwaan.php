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

if ( !isset($_GET['f']) ) $_GET['f']='2011';

$SFM->assign( 'SELF',CONFIG_REDIRECTURL.basename($_SERVER['SCRIPT_NAME']) );
$SFM->assign( 'SELFAV',"http://".$_SERVER['SERVER_NAME'].$pic2 );

switch ($_GET['f'])
{
///////////////////////////////////////////////////////////////// HC2011 ////////////////////////////////////////////////////		
		case '2011':
		//display pics
		$folder = 'hc2011';
		include_once("display_album.php");

		break;

///////////////////////////////////////////////////////////////// THEN ////////////////////////////////////////////////////		
		case 'then':
		//display pics
		$folder = 'then';
		include_once("display_album.php");

		break;
		

///////////////////////////////////////////////////////////////// NOW ////////////////////////////////////////////////////		
		case 'now':
		//display pics
		$folder = 'now';
		include_once("display_album.php");

		break;

///////////////////////////////////////////////////////////////// MIXED MEDIA ////////////////////////////////////////////////////		
		case 'retro':
		//display pics
		$folder = 'retrospect';
		include_once("display_albumdummy.php");

		break;

}	
//alternate quip
$pix_count = $pix_count * 1000;
$pix_size = $df->formatBytes($pix_size,2);
$SFM->assign( 'quip',"if a picture is worth a thousand words, then there are approximately $pix_count words in this album<br><br> ...and exactly $pix_size worth of data." );

//assign current tab
$t2 = "current-cat";
//assign tabs		
$tabs = "<li class=\"cat-item $t0\"><a href=\"index.php\">Wall</a></li>";
$tabs .= "<li class=\"cat-item $t1\"><a href=\"index_all.php\">Classmates</a></li>";
$tabs .= "<li class=\"cat-item $t2\"><a href=\"index_litratuwaan.php\">Litratuwaan</a></li>";
//$tabs .= "<li class=\"cat-item $t3\"><a href=\"\"></a></li>";
$tabs .= "<li class=\"cat-item $t4\"><a href=\"index_about.php\">About</a></li>";
$SFM->assign( 'tabs',$tabs );

$SFM->assign( 'litratuwaan','yes' );

$SFM->assign( 'displaytxt',$display_album );
$SFM->assign( 'post_id',501 );




//navi


$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('wide.htm');

$db->sql_close();
?>