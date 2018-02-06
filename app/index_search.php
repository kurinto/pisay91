<?php
require_once('../bootstrap.php');
	require(CONFIG_LIB_PATH."model/class_db_mysql.inc");
	include_once(CONFIG_LIB_PATH."model/class_profile.inc");
	include_once(CONFIG_LIB_PATH."model/class_search.inc");
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

//fortunes
include_once(CONFIG_LIB_PATH."model/class_fortune.inc");
$fortune = new Fortune;

$SFM->assign( 'SELF',CONFIG_REDIRECTURL.basename($_SERVER['SCRIPT_NAME']) );
$SFM->assign( 'SELFAV',"http://".$_SERVER['SERVER_NAME'].$pic2 );


///////////////////////////////////////////////////////////////// INDEX-SEARCH ////////////////////////////////////////////////////		
$search = new Search;
$qstr = $_POST['q'];
//echo $qstr;

		//display writeup and post in post container
		//assign current tab
		//$t1 = "current-cat";


		//display classmates
//get classmates
$faces ="";
$match_count = $search->count_matches($qstr);

if ($match_count > 0) {
	$fs = $search->get_matches($qstr);
	//print_r($faces);
	
	foreach ($fs as $f)
	{
		if ( !is_file(CONFIG_DATA_PATH."avatars/".$f[gradpix]) && strtolower($f[gender])=='m') $pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$f[gradpix]?width=75&height=75&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_M.jpg";
		elseif ( !is_file(CONFIG_DATA_PATH."avatars/".$f[gradpix]) && strtolower($f[gender])=='f') $pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$f[gradpix]?width=75&height=75&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_F.jpg";
		else $pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$f[gradpix]?width=75&height=75&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/$f[gradpix]";

		if ($f[gender]==m) $faces .= "<span class=\"boy\"><a class=\"faces\" href=\"classmate.php?id=$f[id]\" title=\"$f[firstname] $f[midname] $f[lastname]\"><img src=\"$pic1\" alt=\"$f[firstname] $f[midname] $f[lastname]\" /></a></span>\n\r";
		else $faces .= "<span class=\"girl\"><a class=\"faces\" href=\"classmate.php?id=$f[id]\" title=\"$f[firstname] $f[midname] $f[lastname]\"><img src=\"$pic1\" alt=\"$f[firstname] $f[midname] $f[lastname]\" /></a></span>\n\r";
	}
	//echo $faces_count;
	$SFM->assign( 'faces',$faces );
	$SFM->assign( 'faces_count',$faces_count );

	$SFM->assign( 'quip',$fortune->getRandomQuote(CONFIG_DATA_PATH."fortunes/unused/fortunes.dat") );
} 
else {
	$SFM->assign( 'quip','' );
	$SFM->assign( 'faces',"<br><br>".$fortune->getRandomQuote(CONFIG_DATA_PATH."fortunes/unused/fortunes.dat")."<br><br>" );
}


//assign tabs		
$tabs = "<li class=\"cat-item $t0\"><a href=\"index.php\">Wall</a></li>";
$tabs .= "<li class=\"cat-item $t1\"><a href=\"index_all.php\">Classmates</a></li>";
$tabs .= "<li class=\"cat-item $t2\"><a href=\"index_litratuwaan.php\">Litratuwaan</a></li>";
//$tabs .= "<li class=\"cat-item $t3\"><a href=\"\"></a></li>";
$tabs .= "<li class=\"cat-item $t4\"><a href=\"index_about.php\">About</a></li>";
$SFM->assign( 'tabs',$tabs );


//display writeup
//$SFM->assign( 'writeup',$writeup );
$note="Found $match_count search matches for <a href='#'>$qstr</a>";
$SFM->assign( 'note',$note );

//display post

//navi


$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('pisbuk.htm');

$db->sql_close();
?>