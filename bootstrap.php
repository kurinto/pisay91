<?php
//bruteforce php ini, almost never work except on old php..
//ini_set('register_globals',0);  
//ini_set('post_max_size','500M') ;
//ini_set('upload_max_filesize','500M');
//ini_set('memory_limit','500M');
//ini_set('session.use_trans_sid', true);
//require_once('smarty_ajax.php');

//sfm base
$absolutepath=str_replace("\\","/",dirname(__FILE__));
define('ABSPATH', $absolutepath . '/');

/** Smarty configuration */
require_once( ABSPATH . 'conf/global.conf');		//absolute path to global conf
require_once( CONFIG_LIB_PATH . 'SFM.class.php');

$max_filesize = CONFIG_MAXFILESIZE * pow(1024,2);

$SFM = new SFM();

//read & assign PATHS and URL (template stuff)
$SFM->assign('CONFIG_BASE', CONFIG_BASEURL);
$SFM->assign('CONFIG_URL', CONFIG_URL);
$SFM->assign('INDEX_URL', CONFIG_REDIRECTURL);
$SFM->assign('CONFIG_IMG_URL', CONFIG_IMG_URL);
$SFM->assign('CONFIG_CSS_URL', CONFIG_CSS_URL);
$SFM->assign('CONFIG_JS_URL', CONFIG_JS_URL);
$SFM->assign('CONFIG_ADMIN_EMAIL', CONFIG_ADMIN_EMAIL);
$SFM->assign('CONFIG_DATA_URL', CONFIG_DATA_URL);
$SFM->assign('CONFIG_LIB_URL', CONFIG_LIB_URL);

$SFM->assign("LANG_NAME",CONFIG_SFM_NAME);
$SFM->assign("LANG_BUILD",CONFIG_SFM_VERSION);

if( function_exists("date_default_timezone_set") ) date_default_timezone_set(CONFIG_SFM_TZ);

$today = date ("l, F d, Y")." @ "; $today .= date ("h:i:s A T"); $SFM->assign("today",$today);
$todey = date ("Y-m-d H:i:s"); $SFM->assign("todey",$todey);
$random = md5(time());
?>