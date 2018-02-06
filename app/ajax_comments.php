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
	$comment = new Post;
	$df = new DateFormat;

	$count_com = $comment->count_all_comments($_GET['pid']);
	
	if ($count_com > 0) {
		$com = $comment->get_all_comments($_GET['pid']);
	//	print_r($com);
		
		foreach ($com as $val)
		{
			$gravatar=md5(strtolower(trim($val[c_email])));	
		
			$SFM->assign( comment_id,$val[id] );
			$SFM->assign( comment_email,$gravatar );
			$SFM->assign( comment_author,$val[c_author] );
			$SFM->assign( comment_url,$val[c_url] );
			$SFM->assign( comment_note,$val[c_note] );
				$comment_date = $df->ago($val[c_date],$todey); 
			$SFM->assign( comment_date,$comment_date );
		
			$comments .= $SFM->fetch( 'item_comment.htm' );
		}
		$SFM->assign( 'ITEM',$comments );
	}
}


$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('blank.htm');

$db->sql_close();
?>