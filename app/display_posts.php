<?php
require_once('../bootstrap.php');

//get posts
$posts="";	
$post_count = $post->count_all_posts($CID);
//echo $post_count;
if ($post_count > 0) 
{
	$ps = $post->get_post_author($CID);
//	print_r($ps);

//recaptcha
if (CONFIG_RECAPTCHA_ENABLE=='1')
{
	require_once(CONFIG_LIB_PATH."recaptcha/recaptchalib.php");
	$publickey = "6LfGssUSAAAAAM-kEjXY7OegIBBJhh_pIeh1VZQW"; 
	$recaptcha=recaptcha_get_html($publickey);

	$SFM->assign( 'recaptcha',$recaptcha );
}

//securimage
if (CONFIG_SECURIMAGE_ENABLE=='1') 
{		
	include(CONFIG_LIB_PATH.'securimage/securimage.php');
	$captcha = new Securimage();
	
	$SFM->assign('securimage','Yes');
	$SFM->assign('captcha_url',CONFIG_LIB_URL.'securimage/');
	$SFM->assign('captcha_path',CONFIG_LIB_PATH.'securimage/');
	$SFM->assign('captcha_sid',$random);
}

	
	foreach ($ps as $p)
	{
	$pid=$p[id];
	$SFM->assign( 'post_id',$pid );


			if(is_numeric($p[p_type])){
				$yo=$profile->get_info($p[p_type]);
				//print_r($yo);
				$p_type="via ".ucwords("$yo[nickname] $yo[lastname]");
				$aka=CONFIG_REDIRECTURL."classmate.php?id=$p[p_type]";
				//get avatar
				if ( !is_file(CONFIG_DATA_PATH."avatars/".$yo[gradpix]) && strtolower($_GET[gender])=='m') $pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$yo[gradpix]?width=50&height=50&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_M.jpg";
				elseif ( !is_file(CONFIG_DATA_PATH."avatars/".$yo[gradpix]) && strtolower($_GET[gender])=='f') $pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$yo[gradpix]?width=50&height=50&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_F.jpg";
				else $pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$yo[gradpix]?width=50&height=50&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/$yo[gradpix]";
				$avatar = "<img src=\"$pic2\" alt=\"$yo[nickname]\" />";
				$SFM->assign( 'avatar',$avatar );
			}else {
				$p_type=$p[p_type];		
				$aka='#';
				//get avatar
				if ( $CID==0 ) $pic2 = CONFIG_DATA_URL."avatars/$i[avatar]";
				elseif ( !is_file(CONFIG_DATA_PATH."avatars/".$i[gradpix]) && strtolower($_GET[gender])=='m') $pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$i[gradpix]?width=50&height=50&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_M.jpg";
				elseif ( !is_file(CONFIG_DATA_PATH."avatars/".$i[gradpix]) && strtolower($_GET[gender])=='f') $pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$i[gradpix]?width=50&height=50&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/DEFAULTGP_F.jpg";
				else $pic2 = CONFIG_LIB_URL."model/thumbnail.php/pic2_$i[gradpix]?width=50&height=50&cropratio=1:1&image=".CONFIG_DATA_URL."avatars/$i[gradpix]";
				$avatar = "<img src=\"$pic2\" alt=\"$i[nickname]\" />";
				$SFM->assign( 'avatar',$avatar );
			}		
		$SFM->assign( 'post_type',$p_type ); 	
		$SFM->assign( 'aka',$aka );
			$post_date = $df->ago($p[p_date],$todey); 
		$SFM->assign( 'post_date',$post_date );
		$SFM->assign( 'post_title',$p[p_title] );
		$SFM->assign( 'post_note',nl2br($p[p_note]) );
			if ($p[p_likes]>1) $p_likes="<a name='ok'>$p[p_likes] people</a> likes this.";
			elseif ($p[p_likes]==1) $p_likes="<a name='ok'>$p[p_likes] person</a> likes this.";
			else $p_likes="";
		$SFM->assign( 'post_likes', $p_likes);
	
			$comments="";	
			$comment_count = $post->count_all_comments($pid);
			if ($comment_count > 0) 
			{
				$cs = $post->get_comments($pid);
				//print_r($cs);
				
				foreach ($cs as $c)
				{
				$gravatar=md5(strtolower(trim($c[c_email])));
					
					$SFM->assign( 'comment_id',$c[id] );
					$SFM->assign( 'comment_email',$gravatar );
					$SFM->assign( 'comment_author',$c[c_author] );
					$SFM->assign( 'comment_url',$c[c_url] );
					$SFM->assign( 'comment_note',$c[c_note] );
						$comment_date = $df->ago($c[c_date],$todey); 
					$SFM->assign( comment_date,$comment_date );

					$comments .= $SFM->fetch( 'item_comment.htm' );
				}
				//echo $comment_count;
				$SFM->assign( 'comments',$comments );
				$SFM->assign( 'comment_count',$comment_count );
				
			}else $SFM->assign( 'comments',"" );

		$posts .= $SFM->fetch( 'item_post.htm' );
	}
	//echo $post_count;
	$SFM->assign( 'posts',$posts );
	$SFM->assign( 'post_count',$post_count );

} else $SFM->assign( 'posts',"<br><br>no post yet.<br><br>" );


?>