<?php
require_once('../bootstrap.php');
	require_once(CONFIG_LIB_PATH."model/class_db_mysql.inc");
	include_once(CONFIG_LIB_PATH."model/class_profile.inc");

$db = new Mysql_db;
$db->sql_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

if(isset($_GET['name'])) {
	$section = $_GET['name'];
	$profile = new Profile;
	
	$s = $profile->get_section_info($section);
	$year = $s[year];
	
	$name_count = $profile->count_section_classmates($year,$section);
	if ($name_count > 0) 
	{
		$ns = $profile->get_section_classmates($year,$section);
		//print_r($ns);
		
		foreach ($ns as $n)
		{
			$names .= " <a href=\"classmate.php?id=$n[id]\">$n[firstname] $n[lastname]</a>, ";
		}$names = substr($names,0,-2);

		if ( !is_file(CONFIG_DATA_PATH."classpix/".$s[classpix]) ) $pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$s[classpix]?width=550&height=330&cropratio=1.6:1&image=".CONFIG_DATA_URL."classpix/DEFAULTCP.jpg";
		else $pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$s[classpix]?width=550&height=330&cropratio=1.6:1&image=".CONFIG_DATA_URL."classpix/$s[classpix]";
		$photo = "<img src=\"$pic1\" alt=\"$s[name]\" />";

	} else $names="no classmates... weh?";	
}
$SFM->assign('photo', $photo);
$SFM->assign('photo_note', $s[notes]);
$SFM->assign('photo_tags', $names);
$classpix=$SFM->fetch('item_photo.htm');

$SFM->assign('ITEM',$classpix);
//$SFM->assign( 'ITEM',"$photo <br><br><p class=\"wp_caption\">$s[notes]</p><br><br><p class=\"cpholder tagged\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In this Photo: $names</p>" );

$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('blank.htm');

//$db->sql_close();
?>