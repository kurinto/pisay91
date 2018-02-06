<?php
require_once('../../bootstrap.php');
	require(CONFIG_LIB_PATH."model/class_db_mysql.inc");
	include_once(CONFIG_LIB_PATH."model/class_profile.inc");


$db = new Mysql_db;
$db->sql_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if(!isset($_GET['act'])) $_GET['act']='new';
switch ($_GET['act'])
{
	case 'add':
	
		$nickname = strtolower($_POST[nickname]);
		
		$fullname = ucwords(strtolower(trim($_POST[fullname])));
		$p = explode(" ", $fullname);
		$p[0]=trim($p[0]); 
		$p[1]=trim($p[1]); 
		$p[2]=trim($p[2]); 
		$p[3]=trim($p[3]); 
		$p[4]=trim($p[4]); 
		
		//echo $p[0]; echo $p[1]; echo $p[2]; echo $p[3]; echo $p[4];
		
		if ( !empty($p[4]) ) {
			$firstname=$p[0]." ".$p[1]." ".$p[2];
			$midname=$p[3];
			$lastname=$p[4];
		}
		else if ( !empty($p[3]) ) {
			$firstname=$p[0]." ".$p[1];
			$midname=$p[2];
			$lastname=$p[3];
		}
		else {
			$firstname=$p[0];
			$midname=$p[1];
			$lastname=$p[2];
		}
		
		$sections = strtolower(trim($_POST[sections]));
		$s = explode("*", $sections);
		$fr=trim($s[0]); 
		$so=trim($s[1]); 
		$ju=trim($s[2]); 
		$se=trim($s[3]); 
		
		$writeup=$_POST[writeup];
		$i_birthday=$_POST[i_birthday];
		$id=$_POST[id];
		$gp = strtolower($lastname).".jpg";
		$gender=$_POST[gender];
		
//		$q = "INSERT INTO profiles SET id='$id', nickname='$nickname', firstname='$firstname', midname='$midname', lastname='$lastname', sec_1='$fr', sec_2='$so', sec_3='$ju', sec_4='$se', writeup='$writeup', i_birthday='$i_birthday', gradpix='$gp'";
		$q = "INSERT INTO profiles SET id='$id', nickname='$nickname', firstname='$firstname', midname='$midname', lastname='$lastname', sec_1='$fr', sec_2='$so', sec_3='$ju', sec_4='$se', i_birthday='$i_birthday', gradpix='$gp', gender='$gender'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
		if ($result) {
			$nextid = $id + 1;
			$messages = " $nickname profile: added successfully! <a href=\"new_profile.php?nextid=$nextid\">add more</a>";
		}

		header("Location: ?nextid=$nextid&messages=$messages");
	break;	

	case 'new':
		$SFM->assign( 'nextid',$_GET['nextid'] );
		$SFM->assign( 'messages',$_GET['messages'] );
		$SFM->assign( 'action_url',"?act=add" );
		$ITEM = $SFM->fetch( 'form_addprofile.htm' );
	break;	
}
$SFM->assign( 'ITEM',$ITEM );
$SFM->assign( 'messages',$messages );

$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('blank.htm');

$db->sql_close();
?>