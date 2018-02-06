<?php
require_once('../bootstrap.php');

//get classmates
$faces ="";
$faces_count = $profile->count_section_classmates($year,$section);

//echo $faces_count;
if ($faces_count > 0) 
{
	$fs = $profile->get_section_classmates($year,$section);
	//print_r($faces);
	
	foreach ($fs as $f)
	{
		//echo $f[gradpix];
		if ( !is_file(CONFIG_DATA_PATH."avatars/".$f[gradpix]) && strtolower($f[gender])=='m') $pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$f[gradpix]?width=75&height=75&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_M.jpg";
		elseif ( !is_file(CONFIG_DATA_PATH."avatars/".$f[gradpix]) && strtolower($f[gender])=='f') $pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$f[gradpix]?width=75&height=75&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_F.jpg";
		else $pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$f[gradpix]?width=75&height=75&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/$f[gradpix]";

		//current classmate not included in the list
		if (  ($f[id] == $i[id]) ) $faces .="";
		elseif ($f[gender]==m) $faces .= "<span class=\"boy\"><a class=\"faces\" href=\"classmate.php?id=$f[id]\" title=\"$f[firstname] $f[lastname]\"><img src=\"$pic1\" alt=\"$f[firstname] $f[lastname]\" /></a></span>\n\r";
		else $faces .= "<span class=\"girl\"><a class=\"faces\" href=\"classmate.php?id=$f[id]\" title=\"$f[firstname] $f[lastname]\"><img src=\"$pic1\" alt=\"$f[firstname] $f[lastname]\" /></a></span>\n\r";
	}
	//echo $faces_count;
	$SFM->assign( 'faces',$faces );
	$SFM->assign( 'faces_count',$faces_count );

} else $SFM->assign( 'faces',"<br><br>no classmates... weh?<br><br>" );


?>