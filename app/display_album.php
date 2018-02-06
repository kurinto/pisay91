<?php
require_once('../bootstrap.php');

$pix_count=0; $pix_size=0;
$pix = "this folder: ".CONFIG_DATA_URL ."litratuwaan/$folder/ contains:<BR><BR>";
	if ($handle = opendir(CONFIG_DATA_PATH . "litratuwaan/$folder/")) {
	    while (false !== ($file = readdir($handle))) {
	        if ($file != "." && $file != "..") {
			$filename[$pix_count] = $file;			
			$pix_count++;	
			$pix_size = $pix_size + filesize(CONFIG_DATA_PATH."litratuwaan/$folder/$file");
	        }
	    }
	    closedir($handle);
	}
	//random view each load
	if ($folder=='now' or $folder=='then') shuffle($filename);
	
	foreach ($filename as $file)	{
		//thumb
		$pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$file?width=70&height=70&cropratio=1:1&image=".CONFIG_DATA_URL."litratuwaan/$folder/$file";
		//actual resized
		$pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$file?width=800&cropratio=1.6:1&image=".CONFIG_DATA_URL."litratuwaan/$folder/$file";
		$pix .= "<span class=\"pix\"><a href=\"$pic2\" rel=\"Litratuwaan[$folder]\"><img src=\"$pic1\" /></a></span>";
	}	

$SFM->assign( 'pix',$pix );
$display_album = $SFM->fetch('item_album.htm');

?>