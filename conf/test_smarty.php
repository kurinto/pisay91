<?php
require '../bootstrap.php';

$smarty = new SFM;

$smarty->compile_check = true;
$smarty->debugging = true;

$smarty->assign("Name","Crispulo Merino Larraga, Jr.");
$smarty->assign("FirstName",array("Clint","Wini","Titus"));
$smarty->assign("LastName",array("Larraga","Villanueva","Larraga"));
$smarty->assign("Class",array(array("A","B","C","D"), array("E", "F", "G", "H"),
	  array("I", "J", "K", "L"), array("M", "N", "O", "P")));

$smarty->assign("contacts", array(array("phone" => "1", "fax" => "2", "cell" => "3"),
	  array("phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234")));

$smarty->assign("option_values", array("NY","NE","KS","IA","OK","TX"));
$smarty->assign("option_output", array("New York","Nebraska","Kansas","Iowa","Oklahoma","Texas"));
$smarty->assign("option_selected", "NE");

$smarty->display('test/index.tpl');

?>
