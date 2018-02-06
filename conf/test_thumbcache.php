<?php
require_once('../bootstrap.php');

$faces = "You should be seeing a bunch of pictures here, if not then you don't have the correct GD version<BR><BR>\n\r";
$faces .= "folder: ".CONFIG_DATA_PATH ."avatars/ contains:<BR>";
if ($handle = opendir(CONFIG_DATA_PATH . 'avatars/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
		//gradpix
		$pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$file?width=180&cropratio=1:1.25&image=".CONFIG_DATA_URL."avatars/$file";
		$faces .= "<span><img src=\"$pic1\" /></span>";
		//index-all
		$pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$file?width=75&height=75&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/$file";
		$faces .= "<span><img src=\"$pic2\" /></span>";
		//avatar
		$pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic3_$file?width=50&height=50&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/$file";
		$faces .= "<span><img src=\"$pic2\" /></span>";
        }
    }
    closedir($handle);
}

$faces .= "<BR><BR>folder: ".CONFIG_DATA_PATH ."classpix/ contains:<BR>";
if ($handle = opendir(CONFIG_DATA_PATH . 'classpix/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
		//classpix
		$pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$file?width=550&height=330&cropratio=1.6:1&image=".CONFIG_DATA_URL."classpix/$file";
		$faces .= "<span><img src=\"$pic1\" /></span>";
        }
    }
    closedir($handle);
}

$faces .= "<BR><BR>folder: ".CONFIG_DATA_PATH ."litratuwaan/then/ contains:<BR>";
if ($handle = opendir(CONFIG_DATA_PATH . 'litratuwaan/then/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
		//thumb
		$pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$file?width=70&height=70&cropratio=1:1&image=".CONFIG_DATA_URL."litratuwaan/then/$file";
		$faces .= "<span><img src=\"$pic1\" /></span>";
		//actual
		$pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$file?width=800&cropratio=1.6:1&image=".CONFIG_DATA_URL."litratuwaan/then/$file";
		$faces .= "<span><img src=\"$pic1\" /></span>";
        }
    }
    closedir($handle);
}

$faces .= "<BR><BR>folder: ".CONFIG_DATA_PATH ."litratuwaan/now/ contains:<BR>";
if ($handle = opendir(CONFIG_DATA_PATH . 'litratuwaan/now/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
		//thumb
		$pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$file?width=70&height=70&cropratio=1:1&image=".CONFIG_DATA_URL."litratuwaan/now/$file";
		$faces .= "<span><img src=\"$pic1\" /></span>";
		//actual
		$pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$file?width=800&cropratio=1.6:1&image=".CONFIG_DATA_URL."litratuwaan/now/$file";
		$faces .= "<span><img src=\"$pic1\" /></span>";
        }
    }
    closedir($handle);
}

$SFM->assign( 'ITEM',$faces );

$SFM->compile_check = true;
//$SFM->debugging = true;
$SFM->display('blank.htm');
?>