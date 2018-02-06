<?php
/* 
Main methods to use:
 
 Written by luck.lil.leprechaun@gmail.com  
 Modified by Clint Larraga, clint.larraga@gmail.com
 Read more at http://www.coolclint.tk

It can be used in the following ways:
echo compare_dates($start_date,$end_date);
echo compare_dates($end_date,$start_date);
echo compare_dates($start_date); //end date will be assumed as time(); 

*/
Class DateFormat 
{
	function ago( $date1, $date2, $l = 1 )
	{
	$blocks = array(
	    array('name'=>'year','amount'    =>    60*60*24*365    ),
	    array('name'=>'month','amount'    =>    60*60*24*31    ),
	    array('name'=>'week','amount'    =>    60*60*24*7    ),
	    array('name'=>'day','amount'    =>    60*60*24    ),
	    array('name'=>'hour','amount'    =>    60*60        ),
	    array('name'=>'minute','amount'    =>    60        ),
	    array('name'=>'second','amount'    =>    1        )
	    );

	$date1 = $this->s2p($date1);
	$date2 = $this->s2p($date2);
	$diff = abs($date1-$date2);
	
	$levels = $l;
	$current_level = 1;
	$result = array();
	foreach($blocks as $block)
	    {
	    if ($current_level > $levels) {break;}
	    if ($diff/$block['amount'] >= 1)
	        {
	        $amount = floor($diff/$block['amount']);
	        if ($amount>1) {$plural='s';} else {$plural='';}
	        $result[] = $amount.' '.$block['name'].$plural;
	        $diff -= $amount*$block['amount'];
	        $current_level++;
	        }
	    }
	return implode(' ',$result).' ago';
	} 
	


	function s2p ($mysqldate) {
		$phpdate = strtotime( $mysqldate );
		return $phpdate;
	}
	
	function p2s ($phpdate) {
		$mysqldate = date( 'Y-m-d H:i:s', $phpdate );
		return $mysqldate;
	}
	
	function s2rss ($date1) {
		//Fri, 01 Sep 2006 21:08:00 +0000
		$date1 = $this->s2p($date1);
		$date2 = date ("D, d M Y H:i:s O", $date1); 
		
		return $date2;
	}

 	function get_bday_classmates($date) {

		$bday = trim(substr($date,5,-9));
	
	        $q = "SELECT id, gender, nickname, firstname, midname, lastname, gradpix FROM profiles WHERE id > '0' AND i_birthday LIKE '%$bday'"; 
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

	function count_bday_classmates($date) {

		$bday = trim(substr($date,5,-9));

		$q = "SELECT COUNT(id) FROM profiles WHERE id > '0' AND i_birthday LIKE '%$bday'";
		$result = mysql_query($q) or die("error: ".mysql_error()); 
	        $row = mysql_fetch_row($result);

		return $row[0];
	}

	function formatBytes($bytes, $precision = 2) { 
		$units = array('B', 'KB', 'MB', 'GB', 'TB'); 
		
		$bytes = max($bytes, 0); 
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
		$pow = min($pow, count($units) - 1); 
		
		// Uncomment one of the following alternatives
		$bytes /= pow(1024, $pow);
		// $bytes /= (1 << (10 * $pow)); 
		
		return round($bytes, $precision) . ' ' . $units[$pow]; 
	} 	

	

}
?>