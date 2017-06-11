<?php

require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
require ('database.php');
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
if(isset($_POST['Submit'])){

	$mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet'];
	if(in_array($_FILES["file"]["type"],$mimes)){

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		
		$uploadFilePath = 'uploads/'.basename($_FILES['file']['name']);
		move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

		$Reader = new SpreadsheetReader($uploadFilePath);

		/* echo "<pre>";
		print_r($Reader);
		exit; */
		
		$totalSheet = count($Reader->sheets());

		echo "You have total ".$totalSheet." sheets".

		$html="<table border='1'>";
		$html.="<tr><th>S.no</th><th>Name</th><th>Salary</th><th>Languages</th></tr>";

		/* For Loop for all sheets */
		for($i=0;$i<$totalSheet;$i++){

			$Reader->ChangeSheet($i);
			
			/* echo "<pre>";
			print_r($Reader);
			exit; */
			$j = 0;
			foreach ($Reader as $Row)
	        {
				if($j != 0) {
					$html.="<tr>";
					/* Check If sheet not emprt */
					$name = isset($Row[0]) ? $Row[0] : '';
					$salary = isset($Row[1]) ? $Row[1] : '';
					$languages = isset($Row[2]) ? $Row[2] : '';
					$html.="<td>".$j."</td>";
					$html.="<td>".$name."</td>";
					$html.="<td>".$salary."</td>";
					$html.="<td>".$languages."</td>";
					$html.="</tr>";				
					$sql = "INSERT INTO customers (name,salary,languages) values(?,?,?)";
					$q = $pdo->prepare($sql);
					$q->execute(array($name,$salary,$languages)); 
				}		
				$j++;
	        }
			Database::disconnect();
		}

		$html.="</table>";
		echo $html;
		//echo "<br />Data Inserted in dababase";
		header("Location: index.php?msg=Inserted");

	}else { 
		die("<br/>Sorry, File type is not allowed. Only Excel file."); 
	}

}

?>