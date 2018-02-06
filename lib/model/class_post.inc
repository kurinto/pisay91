<?php
/* 
Main methods to use:
   
 Written by Clint Larraga, clint.larraga@gmail.com
 Read more at http://www.coolclint.tk
*/
class Post
{
	function get_message() {
		return $this->message;
	}

	function get_error() {
		return $this->error;
	}

	function get_author_info($author) {
		$q = "SELECT id, nickname, firstname, lastname, gradpix FROM profiles WHERE id='$author_id'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
		$row = mysql_fetch_assoc($result);
		
		return $row;
	}

	function get_post($post_id) {
		$q = "SELECT * FROM posts WHERE id='$post_id'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
		$row = mysql_fetch_assoc($result);
		
		return $row;
	}

	function get_post_author($author) {
		$q = "SELECT * FROM posts WHERE p_author='$author' ORDER BY id DESC LIMIT 10";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
                while($row = mysql_fetch_assoc($result)){ 
	        	$posts[$i] = $row; 
	        	$i++;
		}
		return $posts;
	}

	function set_post($p_author, $p_type, $p_date, $p_title, $p_note) {
		$q = "INSERT INTO posts SET id=NULL, p_author='$p_author', p_type='$p_type', p_date='$p_date', p_title='$p_title', p_note='$p_note'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
                $row = mysql_affected_rows();
                
		return $row;
	}

	function count_all_posts($author) {
		$q = "SELECT COUNT(*)FROM posts WHERE p_author='$author'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_fetch_row($result);
		return $row[0];
	}

	function get_comments($post_id) {
		$c = $this->count_all_comments($post_id);
		if ($c > 5) $lim = $c - 5; else $lim = 0;
		 
		$q = "SELECT * FROM comments WHERE pid='$post_id' ORDER BY c_date ASC LIMIT $lim, 5";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
                //while($row = mysql_fetch_array($result)){ 
                while($row = mysql_fetch_assoc($result)){ 
	        	$comments[$i] = $row; 
	        	$i++;
		}
		return $comments;
	}

	function get_all_comments($post_id) {
		$q = "SELECT * FROM comments WHERE pid='$post_id' ORDER BY c_date ASC";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
                while($row = mysql_fetch_assoc($result)){ 
	        	$comments[$i] = $row; 
	        	$i++;
		}
		return $comments;
	}

	function count_all_comments($post_id) {
		$q = "SELECT COUNT(id) FROM comments WHERE pid='$post_id'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_fetch_row($result);
		return $row[0];
	}

	function get_rss_comments() {
		$q = "SELECT * FROM comments LEFT JOIN posts ON comments.pid=posts.id ORDER BY c_date DESC LIMIT 100";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
                while($row = mysql_fetch_assoc($result)){ 
	        	$comments[$i] = $row; 
	        	$i++;
		}
		return $comments;
	}

	function count_rss_comments() {
		$q = "SELECT COUNT(id) FROM comments";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_fetch_row($result);
		return $row[0];
	}

	function get_likes_post($post_id) {
		$q = "SELECT p_likes FROM posts WHERE id='$post_id'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_fetch_row($result); if ($row[0]==NULL) $row[0]=0;
		return $row[0];
	}

	function set_likes_post($post_id) {
		$old = $this->get_likes_post($post_id);
		$new = $old+1;

		$q = "UPDATE posts SET p_likes='$new' WHERE id='$post_id'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_affected_rows();
		return $row;
	}

	function remove_comment($comment_id) {

		$q = "DELETE FROM comments WHERE id='$comment_id'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_affected_rows();
		return $row;
	}

	function remove_post($post_id) {

		$q1 = "DELETE FROM comments WHERE pid='$post_id'";
		$result1 = mysql_query($q1) or die("error: ".mysql_error()); 

		$q2 = "DELETE FROM posts WHERE id='$post_id'";
		$result2 = mysql_query($q2) or die("error: ".mysql_error()); 

	        $row = mysql_affected_rows();
		return $row;
	}

	function update_post($post_id, $p_type, $p_topic, $p_note) {

		$q = "UPDATE posts SET p_type='$p_type', p_title='$p_topic', p_note='$p_note', p_date=NOW() WHERE id='$post_id'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_affected_rows();
		return $row;
	}
}
?>