<?php
require 'global.conf';
$db =  mysql_connect( DB_HOST, DB_USER, DB_PASS  ) or die( 'Could not open connection to server' );
       mysql_select_db( DB_NAME, $db ) or die( 'Could not select database' );
		
	$query = "SELECT name FROM sections"; 
	$result = mysql_query($query) or die("error: ".mysql_error()); 
       	while($row = mysql_fetch_array($result)){ 
            $i++;
	    echo "<li>".$row[name]."</li>"; 
	}
	echo "retrieved $i records from ".DB_NAME;

?>
