<?php
require_once('../bootstrap.php');

$count_bd = $df->count_bday_classmates($todey);

if ($count_bd > 0) {
	$bd = $df->get_bday_classmates($todey);
	foreach ($bd as $b)
	{
		//echo $b[gradpix];
		if ( !is_file(CONFIG_DATA_PATH."avatars/".$b[gradpix]) && strtolower($b[gender])=='m') $pic3 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$b[gradpix]?width=38&height=38&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_M.jpg";
		elseif ( !is_file(CONFIG_DATA_PATH."avatars/".$b[gradpix]) && strtolower($b[gender])=='f') $pic3 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$b[gradpix]?width=38&height=38&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_F.jpg";
		else $pic3 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$b[gradpix]?width=38&height=38&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/$b[gradpix]";
	
		$name = ucwords("$b[nickname] $b[lastname]");
	//	$bday .= "<span><a class=\"faces\" href=\"classmate.php?id=$b[id]\" title=\"$name\"><img src=\"$pic3\" alt=\"$name\" /></a></span></span>$name</span><br>\n\r";
		$bday .= "<a href=\"classmate.php?id=$b[id]\" title=\"$name\">$name</a>, \n\r";
			
	}$bday = substr($bday,0,-6);
	$SFM->assign( 'birthdays','<a class=\"celebrant\">'.$bday.'</a>' );
}
?>