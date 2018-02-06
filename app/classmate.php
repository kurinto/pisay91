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


if ( !isset($_GET['s']) ) $year='0';
else {
	$section = $_GET['s'];
	$year = $profile->get_section_year($section);
	//echo $section.":".$year;
}

$SFM->assign( 'SELF',CONFIG_REDIRECTURL.basename($_SERVER['SCRIPT_NAME'])."?id=".$CID );
//$SFM->assign( 'SELFAV',"http://".$_SERVER['SERVER_NAME'].$pic1 );
//facebook recommends 200x200 as new og.image --20131202
$tiny = file_get_contents("http://tinyurl.com/api-create.php?url=http://$_SERVER[SERVER_NAME]$pic1");
$SFM->assign( 'SELFAV',$tiny );

switch ($year)
{
///////////////////////////////////////////////////////////////// CLASSMATE VIEW ////////////////////////////////////////////////////		
		case '0':
		//display writeup and post in post container
		//assign current tab
		$t0 = "current-cat";

		//classmate writeup
		if ( !empty($i[writeup])  )  $writeup = nl2br($i[writeup]);
		
		//display posts
		$post = new Post;
		include_once("display_posts.php");
		//comment line below to hide fb_comments
		$SFM->assign( 'fb_comments','yes' );
	
		break;
		

///////////////////////////////////////////////////////////////// FRESHMAN ////////////////////////////////////////////////////		
		case '1':
		//display writeup and post in post container
		//assign current tab
		$t1 = "current-cat";

		//get writeup
		$note="$i[nickname]'s freshman classmates in <a class=\"cp\" id=\"$section\" href=\"#\">$section</a>";

		//display classmates
		include_once("display_faces.php");

		break;

///////////////////////////////////////////////////////////////// SOPHOMORE ////////////////////////////////////////////////////		
		case '2':
		//display writeup and post in post container
		//assign current tab
		$t2 = "current-cat";

		//get writeup
		$note="$i[nickname]'s sophomore classmates in <a class=\"cp\" id=\"$section\" href=\"#\">$section</a>";

		//display classmates
		include_once("display_faces.php");


		break;

///////////////////////////////////////////////////////////////// JUNIOR ////////////////////////////////////////////////////		
		case '3':
		//display writeup and post in post container
		//assign current tab
		$t3 = "current-cat";

		//get writeup
		$note="$i[nickname]'s junior classmates in <a class=\"cp\" id=\"$section\" href=\"#\">$section</a>";

		//display classmates
		include_once("display_faces.php");

		break;

///////////////////////////////////////////////////////////////// SENIOR ////////////////////////////////////////////////////		
		case '4':
		//display writeup and post in post container
		//assign current tab
		$t4 = "current-cat";

		//get writeup
		$note="$i[nickname]'s senior classmates in <a class=\"cp\" id=\"$section\" href=\"#\">$section</a>";

		//display classmates
		include_once("display_faces.php");

		break;

}	

//assign tabs		
$tabs = "<li class=\"cat-item $t0\"><a href=\"".$_SERVER['SCRIPT_NAME']."?id=".$CID."\">Wall</a></li>";
if ( !empty($i[sec_1]) )  $tabs .= "<li class=\"cat-item $t1\"><a href=\"?id=$CID&s=$i[sec_1]\">$i[sec_1]</a></li>";
if ( !empty($i[sec_2]) )  $tabs .= "<li class=\"cat-item $t2\"><a href=\"?id=$CID&s=$i[sec_2]\">$i[sec_2]</a></li>";
if ( !empty($i[sec_3]) )  $tabs .= "<li class=\"cat-item $t3\"><a href=\"?id=$CID&s=$i[sec_3]\">$i[sec_3]</a></li>";
if ( !empty($i[sec_4]) )  $tabs .= "<li class=\"cat-item $t4\"><a href=\"?id=$CID&s=$i[sec_4]\">$i[sec_4]</a></li>";
$SFM->assign( 'tabs',$tabs );
$SFM->assign( 'CID',$CID );

//display writeup
$SFM->assign( 'writeup',$writeup );
$SFM->assign( 'note',$note );

//display post

//navi

$maxid = $profile->count_all_classmates();
$nextid = $CID + 1; 
$previd = $CID - 1;

	if ($nextid < $maxid) $SFM->assign( 'next_classmate',"<a href=\"?id=$nextid\">Next Classmate</a>" );				
	else $SFM->assign( 'next_classmate','' );

	if ($previd > 0) $SFM->assign( 'prev_classmate',"<a href=\"?id=$previd\">Previous Classmate</a>" );				
	else $SFM->assign( 'prev_classmate','' );


//og.description -- SMS limit minus 3
if ($og_description == '--') $og_description = substr($i[writeup],0,157)."...";
$SFM->assign( 'og_description',$og_description );



$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('pisbuk.htm');

$db->sql_close();
?>