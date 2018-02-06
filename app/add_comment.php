<?php 
require_once('../conf/global.conf');
$db =  mysql_connect( DB_HOST, DB_USER, DB_PASS  ) or die( 'Could not open connection to server' );
       mysql_select_db( DB_NAME, $db ) or die( 'Could not select database' );
$p = $_POST;
	$c_author = mysql_real_escape_string(strip_tags($p[c_author]));
	$c_email = mysql_real_escape_string(strip_tags($p[c_email]));
	$c_url = mysql_real_escape_string(strip_tags($p[c_url]));
	$c_note = mysql_real_escape_string(strip_tags($p[c_note]));
	$c_ip = getenv("REMOTE_ADDR");

if (CONFIG_RECAPTCHA_ENABLE=='1') {
	//recaptcha
	require_once(CONFIG_LIB_PATH."recaptcha/recaptchalib.php");
	$privatekey = "6LfGssUSAAAAANZxV8IQFkbybf_VXgkrfjmCA24j"; 
	$resp = recaptcha_check_answer ($privatekey,
	                                $_SERVER["REMOTE_ADDR"],
	                                $_POST["recaptcha_challenge_field"],
	                                $_POST["recaptcha_response_field"]);
	
	if (!$resp->is_valid) {
	  // incorrect
	  	die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
	       "(reCAPTCHA said: " . $resp->error . ")");
	} else {
	  // correct
		$query = "INSERT INTO comments SET pid='$p[pid]', c_date='$p[c_date]', c_author='$c_author', c_url='$c_url', c_email='$c_email', c_note='$c_note', c_ip='$c_ip'";	
	        $result = mysql_query($query) or die("error: ".mysql_error()); 
		if ($result) header("Location: ".$_SERVER['HTTP_REFERER']."#comment-".mysql_insert_id());
	}
} 
elseif (CONFIG_SECURIMAGE_ENABLE=='1') {
session_start();
	//secureimage
	require_once(CONFIG_LIB_PATH."securimage/securimage.php");
	$securimage = new Securimage();

	if ($securimage->check($_POST['captcha_code']) == false) {
	  echo "The security code entered was incorrect.<br /><br />";
	  echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
	  exit;
	} else {
	  // correct
		$query = "INSERT INTO comments SET pid='$p[pid]', c_date='$p[c_date]', c_author='$c_author', c_url='$c_url', c_email='$c_email', c_note='$c_note', c_ip='$c_ip'";	
	        $result = mysql_query($query) or die("error: ".mysql_error()); 
		if ($result) header("Location: ".$_SERVER['HTTP_REFERER']."#comment-".mysql_insert_id());
	}
} 
else {
	$query = "INSERT INTO comments SET pid='$p[pid]', c_date='$p[c_date]', c_author='$c_author', c_url='$c_url', c_email='$c_email', c_note='$c_note', c_ip='$c_ip'";	
        $result = mysql_query($query) or die("error: ".mysql_error()); 
	if ($result) header("Location: ".$_SERVER['HTTP_REFERER']."#comment-".mysql_insert_id());
}

?>