<?php
require_once('../bootstrap.php');
	require_once(CONFIG_LIB_PATH."model/class_db_mysql.inc");
	include_once(CONFIG_LIB_PATH."model/class_post.inc");
	include_once(CONFIG_LIB_PATH."model/class_dateformat.inc");

$com="";

$db = new Mysql_db;
$db->sql_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

//$_GET['pid']=1;

if(isset($_GET['pid'])) {
	$like = new Post;
	$like_count = $like->get_likes_post($_GET['pid']);
		$like->set_likes_post($_GET['pid']);
	$new_count = $like->get_likes_post($_GET['pid']);

if ($new_count == 1) $SFM->assign( 'ITEM',"<div class='text'><a name='ok'>You</a> like this? Why?</div>");
elseif ($new_count == 2) $SFM->assign( 'ITEM',"<div class='text'><a name='ok'>You and $like_count other person</a> likes this... Hmmmm... </div>");
else $SFM->assign( 'ITEM',"<div class='text'><a name='ok'>You and $like_count other people</a> likes this. Sige click mo pa!</div>");
}

$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('blank.htm');

$db->sql_close();
?>