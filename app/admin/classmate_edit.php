<?php
require_once('../../bootstrap.php');
	require_once(CONFIG_LIB_PATH."../lib/model/class_db_mysql.inc");
	include_once(CONFIG_LIB_PATH."../lib/model/class_profile.inc");
	include_once(CONFIG_LIB_PATH."../lib/model/class_post.inc");
	include_once(CONFIG_LIB_PATH."../lib/model/class_dateformat.inc");

$db = new Mysql_db;
$db->sql_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

//$_GET['id']=0;
if(!isset($_GET['id'])) $_GET['id']=0;
$CID = $_GET['id']; $SFM->assign( 'CID',$CID );

//display profile avatar + info + etc
$profile = new Profile;
include_once("edit_profile.php");

if ( !isset($_GET['act']) ) $_GET['act']='edit';
switch ($_GET['act'])
{
///////////////////////////////////////////////////////////////// CLASSMATE VIEW ////////////////////////////////////////////////////		
		case 'edit':

		//display writeup and post in post container
		//assign current tab
		$t0 = "current-cat";

		//classmate writeup
		$writeup = htmlentities($i[writeup]);
		$SFM->assign( 'writeup','edit' );
		$SFM->assign( 'pb_writeup',$writeup );
		
		//display form
		
		$pos = strpos($profile->get_gradpix($CID),"_@_");
		if ( $pos!==false ) {
			$toggle_gp = "<A HREF=\"toggle_gp.php?id=$CID&t=show\">Show Gradpix</A>";
			$SFM->assign( 'show_gp',$toggle );
		}else {
			$toggle_gp = "<A HREF=\"toggle_gp.php?id=$CID&t=hide\">Hide Gradpix</A>";
		}	
		$SFM->assign( 'toggle_gp',$toggle_gp );
		
		
		$displaytxt = $SFM->fetch('form_editprofile.htm');
		$SFM->assign( 'message',$_GET['message'] );

		break;
		

///////////////////////////////////////////////////////////////// UPDATE ////////////////////////////////////////////////////		
		case 'update':
		$id = $CID;
		$firstname = mysql_real_escape_string($_POST['pb_firstname']);
		$midname = mysql_real_escape_string($_POST['pb_midname']);
		$lastname = mysql_real_escape_string($_POST['pb_lastname']);
		$suffix = mysql_real_escape_string($_POST['pb_suffix']);
		$nickname = mysql_real_escape_string($_POST['pb_nickname']);
		$quip = mysql_real_escape_string($_POST['pb_quip']);
		$sec_1 = mysql_real_escape_string($_POST['pb_sec_1']);
		$sec_2 = mysql_real_escape_string($_POST['pb_sec_2']);
		$sec_3 = mysql_real_escape_string($_POST['pb_sec_3']);
		$sec_4 = mysql_real_escape_string($_POST['pb_sec_4']);
		$writeup = mysql_real_escape_string($_POST['pb_writeup']);
		$i_job = mysql_real_escape_string($_POST['pb_job']);
		$i_work = mysql_real_escape_string($_POST['pb_work']);
		$i_major = mysql_real_escape_string($_POST['pb_major']);
		$i_school = mysql_real_escape_string($_POST['pb_school']);
		$i_city = mysql_real_escape_string($_POST['pb_city']);
		$i_home = mysql_real_escape_string($_POST['pb_home']);
		$i_love = mysql_real_escape_string($_POST['pb_love']);
		$i_speak = mysql_real_escape_string($_POST['pb_speak']);
			if (empty($_POST['pb_birthday']) || $_POST['pb_birthday']=='0000-00-00') $i_birthday = NULL;
			else $i_birthday = mysql_real_escape_string($_POST['pb_birthday']);
		$email = mysql_real_escape_string($_POST['pb_email']);
		$u_fb = mysql_real_escape_string($_POST['pb_fb']);
		$u_tw = mysql_real_escape_string($_POST['pb_tw']);

		$inject = $profile->set_info($id, $firstname, $midname, $lastname, $suffix, $nickname, $quip, $sec_1, $sec_2, $sec_3, $sec_4, $writeup, $i_job, $i_work, $i_major, $i_school, $i_city, $i_home, $i_love, $i_home, $i_birthday, $i_speak, $email, $u_fb, $u_tw);
		if ($inject > 0) $message = "Success!";
		else $message = "Error!";

		header("Location: ?id=$CID&message=".$message); 

		break;
}	

//assign tabs		
$tabs = "<li class=\"cat-item $t0\"><a href=\"".$_SERVER['SCRIPT_NAME']."?id=$CID\">Profile</a></li>";
$tabs .= "<li class=\"cat-item $t1\"><a href=\"classmate_post_edit.php?id=$CID\">Posts</a></li>";
if ($CID==0) $tabs .= "<li class=\"cat-item $t2\"><a href=\"classmate_post_new.php?id=$CID\">New Post</a></li>";
$SFM->assign( 'tabs',$tabs );
$SFM->assign( 'SELF',CONFIG_REDIRECTURL_IN.basename($_SERVER['SCRIPT_NAME'])."?id=".$CID."&act=".$_GET['act'] );


//display writeup
$SFM->assign( 'hidewu', 'yes' );
$SFM->assign( 'posts',$displaytxt );

//display post

/*
//navi

$maxid = $profile->count_all_classmates();
$nextid = $CID + 1; 
$previd = $CID - 1;

	if ($nextid < $maxid) $SFM->assign( 'next_classmate',"<a href=\"?id=$nextid\">Next Classmate</a>" );				
	else $SFM->assign( 'next_classmate','' );

	if ($previd > 0) $SFM->assign( 'prev_classmate',"<a href=\"?id=$previd\">Previous Classmate</a>" );				
	else $SFM->assign( 'prev_classmate','' );
*/





$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('pisbuk.htm');

$db->sql_close();
?>