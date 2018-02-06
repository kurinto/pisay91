<?php
/* 
Main methods to use:
   
 Written by Clint Larraga, clint.larraga@gmail.com
 Read more at http://www.coolclint.tk
*/
class Search 
{
	function count_matches($qstr) {
	        $q = "SELECT COUNT(id) FROM profiles WHERE id > '0' AND (firstname LIKE '%$qstr%' OR midname LIKE '%$qstr%' OR lastname LIKE '%$qstr%' OR nickname LIKE '%$qstr%')"; 
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_fetch_row($result);

		return $row[0];
	}

 	function get_matches($qstr) {
	        $q = "SELECT id, gender, firstname, midname, lastname, gradpix FROM profiles WHERE id > '0' AND (firstname LIKE '%$qstr%' OR midname LIKE '%$qstr%' OR lastname LIKE '%$qstr%' OR nickname LIKE '%$qstr%')"; 
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

	function clean_fullname($qstr)
	{
		$fullname = strtolower(trim($qstr));
		$p = explode(" ", $fullname);
		$p[0]=trim($p[0]); 
		$p[1]=trim($p[1]); 
		$p[2]=trim($p[2]); 
		$p[3]=trim($p[3]); 
		$p[4]=trim($p[4]); 
	
		//echo $p[0]; echo $p[1]; echo $p[2]; echo $p[3]; echo $p[4];
		
		if ( !empty($p[4]) ) {
			$this->firstname=$p[0]." ".$p[1]." ".$p[2];
			$this->midname=$p[3];
			$this->lastname=$p[4];
		}
		else if ( !empty($p[3]) ) {
			$this->firstname=$p[0]." ".$p[1];
			$this->midname=$p[2];
			$this->lastname=$p[3];
		}
		else {
			$this->firstname=$p[0];
			$this->midname=$p[1];
			$this->lastname=$p[2];
		}
	return;
	}
	

}
?>