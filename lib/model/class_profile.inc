<?php
/* 
Main methods to use:
   
 Written by Clint Larraga, clint.larraga@gmail.com
 Read more at http://www.coolclint.tk
*/
class Profile
{
	function get_message() {
		return $this->message;
	}

	function get_error() {
		return $this->error;
	}

	function get_gradpix($id) {
		$q = "SELECT gradpix FROM profiles WHERE id='$id'";
		$result = mysql_query($q);
		$row = mysql_fetch_row($result);

		return $row[0];
	}

	function hide_gradpix($id) {
		$q = "SELECT gradpix FROM profiles WHERE id='$id'";
		$result = mysql_query($q);
		$row = mysql_fetch_row($result);

		$rename = "_@_".$row[0];
		
		$q2 = "UPDATE profiles SET gradpix='$rename' WHERE id='$id'";
		$result2 = mysql_query($q2);
		$row2 = mysql_affected_rows();

		return $row2;
	}

	function show_gradpix($id) {
		$q = "SELECT gradpix FROM profiles WHERE id='$id'";
		$result = mysql_query($q);
		$row = mysql_fetch_row($result);

		$rename = substr($row[0],3);
		
		$q2 = "UPDATE profiles SET gradpix='$rename' WHERE id='$id'";
		$result2 = mysql_query($q2);
		$row2 = mysql_affected_rows();

		return $row2;
	}


	function get_avatar($id) {
		$q = "SELECT nickname, gender, avatar FROM profiles WHERE id='$id'";
		$result = mysql_query($q);
		$row = mysql_fetch_row($result);
		
		if ( !is_file(CONFIG_DATA_PATH."avatars/".$row[avatar]) && strtolower($row[gender])=='m' )  {
			$row[avatar] = "DEFAULTAV_M.jpg";
		}	
		if ( !is_file(CONFIG_DATA_PATH."avatars/".$row[avatar]) && strtolower($row[gender])=='f' )  {
			$row[avatar] = "DEFAULTAV_F.jpg";
		}	
		return $row;
	}

	function get_info($id) {
		$q = "SELECT * FROM profiles WHERE id='$id'";
		$result = mysql_query($q);
		$row = mysql_fetch_assoc($result);
		
		if ( !is_file(CONFIG_DATA_PATH."avatars/".$row[gradpix])  && strtolower($row[gender])=='m' )  {
			$row[gradpix] = "DEFAULTGP_M.jpg";
		}	
		if ( !is_file(CONFIG_DATA_PATH."avatars/".$row[gradpix])  && strtolower($row[gender])=='f' )  {
			$row[gradpix] = "DEFAULTGP_F.jpg";
		}	

		if ( !is_file(CONFIG_DATA_PATH."avatars/".$row[avatar]) && strtolower($row[gender])=='m' )  {
			$row[avatar] = "DEFAULTAV_M.jpg";
		}	
		if ( !is_file(CONFIG_DATA_PATH."avatars/".$row[avatar]) && strtolower($row[gender])=='f' )  {
			$row[avatar] = "DEFAULTAV_F.jpg";
		}	
		return $row;
	}

	function count_all_classmates() {
		$q = "SELECT COUNT(id) FROM profiles";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_fetch_row($result);

		return $row[0];
	}

	function count_all_sections() {
		$q = "SELECT id FROM sections";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_fetch_array($result);

		return $row;
	}

	function get_section_year($section) {
		$q = "SELECT year FROM sections WHERE name='$section'";
		$result = mysql_query($q);
		$row = mysql_fetch_row($result);
		
		return $row[0];
	}

	function get_section_info($section) {
		$q = "SELECT * FROM sections WHERE name='$section'";
		$result = mysql_query($q);
		$row = mysql_fetch_assoc($result);
		
		if ( !is_file(CONFIG_DATA_PATH."classpix/".$row[classpix]) ) {
			$row[classpix] = "DEFAULTCP.jpg";
		}	
		return $row;
	}

 	function get_section_classmates($year,$section) {
		$y = "sec_".$year;
		$q = "SELECT id, firstname, lastname, gender, gradpix, nickname FROM profiles WHERE $y='$section' ORDER by lastname";
		$result = mysql_query($q);
                while($row = mysql_fetch_assoc($result)){ 
	        	$classmates[$i] = $row; 
			if ( !is_file(CONFIG_DATA_PATH."avatars/".$row[gradpix])  && strtolower($row[gender])=='m' )  {
				$row[gradpix] = "DEFAULTGP_M.jpg";
			}	
			if ( !is_file(CONFIG_DATA_PATH."avatars/".$row[gradpix])  && strtolower($row[gender])=='f' )  {
				$row[gradpix] = "DEFAULTGP_F.jpg";
			}	
	        	$i++;
		}
		return $classmates;
	}

	function count_section_classmates($year,$section) {
		$y = "sec_".$year;
		$q = "SELECT COUNT(id) FROM profiles WHERE $y='$section'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_fetch_row($result);

		return $row[0];
	}

 	function get_all_classmates() {
		$q = "SELECT id, firstname, lastname, gender, gradpix, nickname FROM profiles ORDER by lastname";
		$result = mysql_query($q);
                while($row = mysql_fetch_assoc($result)){ 
	        	$classmates[$i] = $row; 
			if ( !is_file(CONFIG_DATA_PATH."avatars/".$row[gradpix])  && strtolower($row[gender])=='m' )  {
				$row[gradpix] = "DEFAULTGP_M.jpg";
			}	
			if ( !is_file(CONFIG_DATA_PATH."avatars/".$row[gradpix])  && strtolower($row[gender])=='f' )  {
				$row[gradpix] = "DEFAULTGP_F.jpg";
			}	
	        	$i++;
		}
		return $classmates;
	}

	function get_classpix($section) {
		$s=strtolower($section);
		$q = "SELECT name, year, classpix, notes FROM sections WHERE name='$s'";
		$result = mysql_query($q);
		$row = mysql_fetch_assoc($result);
		
		if ( !is_file(CONFIG_DATA_PATH."classpix/".$row[classpix]) )  {
			$row[classpix] = "DEFAULTCP.jpg";
		}	
	return $row;
	}

	function set_info($id, $firstname, $midname, $lastname, $suffix, $nickname, $quip, $sec_1, $sec_2, $sec_3, $sec_4, $writeup, $i_job, $i_work, $i_major, $i_school, $i_city, $i_home, $i_love, $i_home, $i_birthday, $i_speak, $email, $u_fb, $u_tw) {
		if ($i_birthday==NULL || $i_birthday=='0000-00-00') $q = "UPDATE profiles SET firstname='$firstname', midname='$midname', lastname='$lastname', wifename='$suffix', nickname='$nickname', quip='$quip', sec_1='$sec_1', sec_2='$sec_2', sec_3='$sec_3', sec_4='$sec_4', writeup='$writeup', i_job='$i_job', i_work='$i_work', i_major='$i_major', i_school='$i_school', i_city='$i_city', i_home='$i_home', i_love='$i_love', i_speak='$i_speak', i_birthday=NULL, email='$email', u_fb='$u_fb', u_tw='$u_tw' WHERE id='$id'";
		else $q = "UPDATE profiles SET firstname='$firstname', midname='$midname', lastname='$lastname', wifename='$suffix', nickname='$nickname', quip='$quip', sec_1='$sec_1', sec_2='$sec_2', sec_3='$sec_3', sec_4='$sec_4', writeup='$writeup', i_job='$i_job', i_work='$i_work', i_major='$i_major', i_school='$i_school', i_city='$i_city', i_home='$i_home', i_love='$i_love', i_speak='$i_speak', i_birthday='$i_birthday', email='$email', u_fb='$u_fb', u_tw='$u_tw' WHERE id='$id'";
		$result = mysql_query($q) or die(mysql_error());
		$row = mysql_affected_rows();
		
		return $row;
	}


}
?>