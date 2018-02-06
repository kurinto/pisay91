<?php 
require_once('../conf/global.conf');
$db =  mysql_connect( DB_HOST, DB_USER, DB_PASS  ) or die( 'Could not open connection to server' );
       mysql_select_db( DB_NAME, $db ) or die( 'Could not select database' );
		
if(isset($_POST['queryString'])) { 
    $queryString = $_POST['queryString'];   
    if(strlen($queryString) > 0) { 
        $query = "SELECT id, firstname, midname, lastname FROM profiles WHERE id > '0' AND (firstname LIKE '%$queryString%' OR midname LIKE '%$queryString%' OR lastname LIKE '%$queryString%' OR nickname LIKE '%$queryString%') LIMIT 10"; 
        $result = mysql_query($query) or die("error: ".mysql_error()); 
        while($row = mysql_fetch_array($result)){ 
        	$fullname = $row[firstname]." ".$row[midname]." ".$row[lastname]; 
        	$id = $row[id];
        	$i++;
 
//	    echo "<li onclick=\"fill('".$fullname."');\">".$fullname."</li>"; 
	    echo "<li onclick=\"window.location = 'classmate.php?id=".$id."'\">".$fullname."</li>"; 
 	}  
    } 
} 

?>


