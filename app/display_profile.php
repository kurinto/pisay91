<?php
require_once('../bootstrap.php');

$i = $profile->get_info($CID);
//non-existent profile
if (empty($i)) header('Location: index_all.php');
//print_r($i);

$SFM->assign( 'author_id',$CID );
if ( empty($i[nickname])  ) $i[nickname]=$i[firstname];

//get gradpixif ( $CID==0 ) $pic1 = CONFIG_DATA_URL."avatars/$i[gradpix]";
elseif ( !is_file(CONFIG_DATA_PATH."avatars/".$i[gradpix]) && strtolower($_GET[gender])=='m') $pic1 = CONFIG_DATA_URL."avatars/DEFAULTGP_M.jpg";
elseif ( !is_file(CONFIG_DATA_PATH."avatars/".$i[gradpix]) && strtolower($_GET[gender])=='f') $pic1 = CONFIG_DATA_URL."avatars/DEFAULTGP_F.jpg";
else $pic1 = CONFIG_LIB_URL."model/thumbnail.php/pic1_$i[gradpix]?width=180&cropratio=1:1.25&image=".CONFIG_DATA_URL."avatars/$i[gradpix]";
$gradpix = "<img src=\"$pic1\" alt=\"$i[nickname]\" />";
$SFM->assign( 'gradpix',$gradpix );


//get avatar
if ( $CID==0 ) $pic2 = CONFIG_DATA_URL."avatars/$i[avatar]";
elseif ( !is_file(CONFIG_DATA_PATH."avatars/".$i[gradpix]) && strtolower($_GET[gender])=='m') $pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$i[gradpix]?width=50&height=50&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_M.jpg";
elseif ( !is_file(CONFIG_DATA_PATH."avatars/".$i[gradpix]) && strtolower($_GET[gender])=='f') $pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$i[gradpix]?width=50&height=50&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_F.jpg";
else $pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$i[gradpix]?width=50&height=50&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/$i[gradpix]";
$avatar = "<img src=\"$pic2\" alt=\"$i[nickname]\" />";
$SFM->assign( 'avatar',$avatar );


//display fullname
if ( !empty($i[wifename]) ) $fullname = "$i[firstname] $i[midname] $i[lastname] $i[wifename]";
else $fullname = "$i[firstname] $i[midname] $i[lastname]";
$SFM->assign( 'nickname',$i[nickname] );
$SFM->assign( 'fullname',$fullname );

//get quip
if ( empty($i[quip])  )  {
//get random fotune instead
	include_once(CONFIG_LIB_PATH."model/class_fortune.inc");
	$fortune = new Fortune;
	$SFM->assign( 'quip',$fortune->quoteFromDir(CONFIG_DATA_PATH."fortunes/") );
}
//elseif ( basename($_SERVER['SCRIPT_NAME'])=='index_all.php' or basename($_SERVER['SCRIPT_NAME'])=='index_search.php' or basename($_SERVER['SCRIPT_NAME'])=='index_about.php') $SFM->assign( 'quip','' );
else $SFM->assign( 'quip',$i[quip] );

// construct profile sentence
//job
if ( !empty($i[i_work]) || !empty($i[i_job]) )  {
	$i_work = "Works";
	if ( !empty($i[i_job]) ) $i_work .= " as $i[i_job]"; 
	if ( !empty($i[i_job]) ) $i_work .= " at <a href=\"http://www.google.com/search?q=$i[i_work]&btnI\" target=\"_blank\">$i[i_work]</a>";
}
$SFM->assign( 'i_work',$i_work );

//school
if ( !empty($i[i_school]) || !empty($i[i_major]) )  {
	$i_school = "Studied";
	if ( !empty($i[i_major]) ) $i_school .= " $i[i_major]"; 
	if ( !empty($i[i_school]) ) $i_school .= " at <a href=\"http://www.google.com/search?q=$i[i_school]&btnI\" target=\"_blank\">$i[i_school]</a>";
}
$SFM->assign( 'i_school',$i_school );
//city
if ( !empty($i[i_city])  )  $i_city = "Lives in <a href=\"http://www.google.com/search?q=$i[i_city]&btnI\" target=\"_blank\">$i[i_city]</a>";
$SFM->assign( 'i_city',$i_city );
//hometown
if ( !empty($i[i_home])  )  $i_home = "From <a href=\"http://www.google.com/search?q=$i[i_home]&btnI\" target=\"_blank\">$i[i_home]</a>";
$SFM->assign( 'i_home',$i_home );
//relationship
if ( !empty($i[i_love])  )  $i_love = "$i[i_love]";
$SFM->assign( 'i_love',$i_love );
//languages
if ( !empty($i[i_speak])  )  $i_speak = "Speaks <a href=\"http://www.google.com/search?q=$i[i_speak]&btnI\" target=\"_blank\">$i[i_speak]</a>";
$SFM->assign( 'i_speak',$i_speak );
//birthday
if ( $i[i_birthday]=='0000-00-00'  )  {
	$i_birthday = '';
}
elseif ( !empty($i[i_birthday])  )  {
	if (CONFIG_HIDEBDAYYR==1) $i_date=substr(date("F d, Y",strtotime($i[i_birthday])),0,-6);
	else $i_date = date("M d, Y",strtotime($i[i_birthday]));
	
	if ( trim(substr($todey,5,-8)) == trim(substr($i[i_birthday],5)) ) {		$i_birthday = "<strong STYLE=\"color:#FF0000\">Happy Birthday $i[nickname]!</strong>";		$og_description = "Happy Birthday $i[nickname]!";	}
	else {		$og_description = "--";		$i_birthday = "Born on <a href=\"http://www.wolframalpha.com/input/?i=$i_date\" target=\"_blank\">$i_date</a>";	}
}
$SFM->assign( 'i_birthday',$i_birthday );
$SFM->assign( 'i_fb',$i[u_fb] );
$SFM->assign( 'i_tw',$i[u_tw] );

?>