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

$post = new Post;

if ( !isset($_GET['act']) ) $_GET['act']='edit';
switch ($_GET['act'])
{
///////////////////////////////////////////////////////////////// CLASSMATE VIEW ////////////////////////////////////////////////////		
		case 'edit':

		//display writeup and post in post container
		//assign current tab
		$t1 = "current-cat";

		//classmate writeup
//		$writeup = htmlentities($i[writeup]);
		$SFM->assign( 'writeup','edit' );
//		$SFM->assign( 'pb_writeup',$writeup );

		//display posts
		$df = new DateFormat;
		include_once("edit_posts.php");
		
		$SFM->assign( 'message',$_GET['message'] );
		$SFM->assign( 'fullname',"Edit Posts -> ".$fullname );
		break;
		
///////////////////////////////////////////////////////////////// REMOVE POST ////////////////////////////////////////////////////		
		case 'rp':
		$pid = $_GET['pid'];

		$inject = $post->remove_post($pid);
		if ($inject > 0) $message = "Success!";
		else $message = "Error!";

		header("Location: ?id=$CID&message=".$message); 

///////////////////////////////////////////////////////////////// REMOVE COMMENT ////////////////////////////////////////////////////		
		case 'rc':
		$cid = $_GET['cid'];

		$inject = $post->remove_comment($cid);
		if ($inject > 0) $message = "Success!";
		else $message = "Error!";

		header("Location: ?id=$CID&message=".$message); 

		break;

///////////////////////////////////////////////////////////////// UPDATE ////////////////////////////////////////////////////		
		case 'update':
		$pid = $_GET['pid'];

		$p_type = mysql_real_escape_string($_POST['p_type']);
		$p_topic = mysql_real_escape_string($_POST['p_topic']);
		$p_note = mysql_real_escape_string($_POST['p_note']);

		$inject = $post->update_post($pid, $p_type, $p_topic, $p_note);
		if ($inject > 0) $message = "Success!";
		else $message = "Error!";

		header("Location: ?id=$CID&message=".$message); 

		break;
}	

//assign tabs		
$tabs = "<li class=\"cat-item $t0\"><a href=\"classmate_edit.php?id=$CID\">Profile</a></li>";
$tabs .= "<li class=\"cat-item $t1\"><a href=\"".$_SERVER['SCRIPT_NAME']."?id=$CID\">Posts</a></li>";
if ($CID==0) $tabs .= "<li class=\"cat-item $t2\"><a href=\"classmate_post_new.php?id=$CID\">New Post</a></li>";
$SFM->assign( 'tabs',$tabs );
$SFM->assign( 'SELF',CONFIG_REDIRECTURL_IN.basename($_SERVER['SCRIPT_NAME'])."?id=".$CID."&act=".$_GET['act'] );


//display writeup
$SFM->assign( 'hidewu', 'yes' );
$SFM->assign( 'posts',$posts );

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