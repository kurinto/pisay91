<?php
require_once('../bootstrap.php');

//get classmates
$names ="";
$names_count = $profile->count_all_classmates();

//echo $names_count;
if ($names_count > 0) 
{
	$fs = $profile->get_all_classmates();
	//print_r($names);
	
	foreach ($fs as $f)
	{
		if ($f[id]== 0) $names .="";
		else {
			$fullname = ucwords($f[nickname]." ".$f[lastname]);
			$names .= " <a class=\"names\" href=\"classmate.php?id=$f[id]\">$fullname</a>,";
		}
	}$names = substr($names,0,-2);
	//echo $names_count;
	$SFM->assign( 'names',$names );
	$SFM->assign( 'names_count',$names_count );

} else $SFM->assign( 'names',"no classmates... weh?" );


?>