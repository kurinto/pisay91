<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
require_once('../../conf/global.conf');
include_once(CONFIG_LIB_PATH."model/class_rss_reader.inc");

$rss_url =CONFIG_REDIRECTURL."rss.php";
?>
<title>RSS Feed Reader</title></head>
<body bgcolor="#FFFFFF">
<h1>RSS Feed Reader</h1>
<p>loads a remote RSS feed and displays the content below.<br>
<FORM name="rss" method="POST" action="rss_read.php">
    <input type="text" name="dyn" size="48" value="<?php echo $rss_url; ?>">
    <input type="submit" value="Go">
</FORM>
<?php
if (isset( $_POST ))
	$posted= &$_POST ;			
else
	$posted= &$HTTP_POST_VARS ;	
if($posted!= false && count($posted) > 0)
{	
	$url= $posted["dyn"];
	if($url != false)
	{
		echo "<hr>";
		echo RSS_Display($url, 15, true, true);
	}
}
/*
require_once('../../conf/global.conf');
include_once(CONFIG_LIB_PATH."model/class_rss_reader.inc");

//echo RSS_Display("http://www.xul.fr/rss.xml", 15);
//echo RSS_Display("http://localhost/pisay91/app/rss2.php", 15, true, true);
//echo RSS_Links("http://localhost/pisay91/app/rss.php", 15);
//echo RSS_Display("http://localhost/rsslib/rss.xml", 15, true, true);

echo RSS_Display("http://localhost/pisay91/app/rss.php", 15, true, true);
*/ 
?>

</body>
</html>