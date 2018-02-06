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

if ( !isset($_GET['act']) ) $_GET['act']='new';
switch ($_GET['act'])
{
///////////////////////////////////////////////////////////////// CLASSMATE VIEW ////////////////////////////////////////////////////		
		case 'new':

		//display writeup and post in post container
		//assign current tab
		$t2 = "current-cat";

		//classmate writeup
//		$writeup = htmlentities($i[writeup]);
		$SFM->assign( 'writeup','edit' );
//		$SFM->assign( 'pb_writeup',$writeup );

		//display posts
		$df = new DateFormat;
		$post = new Post;
//		include_once("edit_posts.php");
		$posts .= $SFM->fetch( 'item_post4.htm' );
		
		$SFM->assign( 'message',$_GET['message'] );
		$SFM->assign( 'fullname',"New Post -> ".$fullname );
		break;
		

///////////////////////////////////////////////////////////////// ADD ////////////////////////////////////////////////////		
		case 'add':
		$pid = $_GET['pid'];

		$p_author = $CID;
		$p_type = mysql_real_escape_string($_POST['p_type']);
		$p_topic = mysql_real_escape_string($_POST['p_topic']);
		$p_note = mysql_real_escape_string($_POST['p_note']);

		$post = new Post;
		$inject = $post->set_post($p_author, $p_type, $todey, $p_topic, $p_note);
		if ($inject > 0) $message = "Success!";
		else $message = "Error!";

		header("Location: ../classmate.php?id=$CID&message=".$message); 

		break;
}	

//assign tabs		
$tabs = "<li class=\"cat-item $t0\"><a href=\"classmate_edit.php?id=$CID\">Profile</a></li>";
$tabs .= "<li class=\"cat-item $t1\"><a href=\"classmate_post_edit.php?id=$CID\">Posts</a></li>";
if ($CID==0) $tabs .= "<li class=\"cat-item $t2\"><a href=\"".$_SERVER['SCRIPT_NAME']."?id=$CID\">New Post</a></li>";
$SFM->assign( 'tabs',$tabs );
$SFM->assign( 'SELF',CONFIG_REDIRECTURL_IN.basename($_SERVER['SCRIPT_NAME'])."?id=".$CID."&act=".$_GET['act'] );


//display writeup
$SFM->assign( 'hidewu', 'yes' );
$SFM->assign( 'posts',$posts );



$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('pisbuk.htm');

$db->sql_close();
?>