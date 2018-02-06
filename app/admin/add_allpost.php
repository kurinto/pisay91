<?php
require_once('../../bootstrap.php');
	require(CONFIG_LIB_PATH."model/class_db_mysql.inc");
	include_once(CONFIG_LIB_PATH."model/class_profile.inc");
	include_once(CONFIG_LIB_PATH."model/class_post.inc");


$db = new Mysql_db;
$db->sql_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);


if(!isset($_GET['act'])) $_GET['act']='new';
switch ($_GET['act'])
{
	case 'add':

		$profile = new Profile;
		$post = new Post;
		$p_title=$_POST['p_title'];
		$p_type=$_POST['p_type'];
		$p_note=$_POST['p_note'];
		$p_date=$todey;
	
		$people_count = $profile->count_all_classmates();
		
		if ($people_count > 0) 
		{
			$fs = $profile->get_all_classmates();
			$i=0;
			foreach ($fs as $f)
			{
				$name = $f[nickname]." ".$f[lastname];
				$p_author = $f[id];
				if (empty($_POST['p_title'])) $p_title = ucwords($name);
				$post->set_post($p_author, $p_type, $p_date, $p_title, $p_note);
				$i++;
			}
			$messages="created $i posts for $people_count authors";		

		} else $messages="no classmate. no posts made.";		

		header("Location: ?messages=$messages");
	break;	

	case 'new':
		$SFM->assign( 'messages',$_GET['messages'] );
		$SFM->assign( 'action_url',"?act=add" );
		$ITEM = $SFM->fetch( 'form_addallpost.htm' );
	break;	
}
$SFM->assign( 'ITEM',$ITEM );
$SFM->assign( 'messages',$messages );

$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('blank.htm');

$db->sql_close();
?>