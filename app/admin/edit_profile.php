<?php
require_once('../../bootstrap.php');

$i = $profile->get_info($CID);
//non-existent profile
if (empty($i)) header('Location: ../index_all.php');
//print_r($i);

$SFM->assign( 'author_id',$CID );
if ( empty($i[nickname])  ) $i[nickname]=$i[firstname];

//get gradpix
if ( $CID==0 ) $pic1 = CONFIG_DATA_URL."avatars/$i[gradpix]";
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
$fullname = "$i[nickname] $i[lastname]";
$SFM->assign( 'fullname',"Edit Profile › ".$fullname );
$SFM->assign( 'nickname',$i[nickname] );
$SFM->assign( 'pb_nickname',$i[nickname] );
$SFM->assign( 'pb_firstname',$i[firstname] );
$SFM->assign( 'pb_midname',$i[midname] );
$SFM->assign( 'pb_lastname',$i[lastname] );
$SFM->assign( 'pb_suffix',$i[wifename] );


//display sections
$SFM->assign( 'pb_sec_1',$i[sec_1] );
$SFM->assign( 'pb_sec_2',$i[sec_2] );
$SFM->assign( 'pb_sec_3',$i[sec_3] );
$SFM->assign( 'pb_sec_4',$i[sec_4] );


//get quip
$quip = htmlentities($i[quip]);
$SFM->assign( 'pb_quip',$quip );

// edit profile sentence
$SFM->assign( 'pb_job',$i[i_job] );
$SFM->assign( 'pb_work',$i[i_work] );
$SFM->assign( 'pb_major',$i[i_major] );
$SFM->assign( 'pb_school',$i[i_school] );
$SFM->assign( 'pb_city',$i[i_city] );
$SFM->assign( 'pb_home',$i[i_home] );
$SFM->assign( 'pb_love',htmlentities($i[i_love]) );
$SFM->assign( 'pb_speak',$i[i_speak] );
$SFM->assign( 'pb_birthday',$i[i_birthday] );
$SFM->assign( 'pb_email',$i[email] );
$SFM->assign( 'pb_fb',$i[u_fb] );
$SFM->assign( 'pb_tw',$i[u_tw] );

?>