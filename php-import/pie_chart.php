<?php 
include 'database.php';
$pdo = Database::connect();
$sql = 'SELECT * FROM customers ORDER BY id DESC';

$languageArray = array();
$count = 1;
$numberArray = $data = array();
 
foreach ($pdo->query($sql) as $row) {
	$languageArray = explode(",",$row['languages']);
		foreach($languageArray as $language) {
			if (!in_array($language, $data)) {
				$data[] = $language;
			}				
			if(!isset($numberArray[$language])) {
			  $numberArray[$language] = 0;
			}
			if (in_array($language, $languageArray)) {
				$numberArray[$language]++;
			}
		}
	
}


foreach($data as $key => $value) {	
	$rows[] = array(
			 "c"=>
				array(
				"0"=>array("v"=>$data[$key],"f"=>NULL),
				"1"=>array("v"=>$numberArray[$value],"f" =>NULL)
				)
			);
	$count++;				
} 

echo $format = '{
"cols":
[
{"id":"","label":"Subject","pattern":"","type":"string"},
{"id":"","label":"Number","pattern":"","type":"number"}
],
"rows":'.json_encode($rows).'}';

Database::disconnect();


?>
