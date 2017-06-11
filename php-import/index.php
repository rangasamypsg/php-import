<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">	
			<div class="row">
    			<h4 class="main_title">Import Xls to PHP MySQL </h4>
    		</div>
			<?php  if(isset($_GET['msg'])) { ?>
				<div class="alert alert-success">
					<strong>Success!</strong> The Record was succesfully <?php echo $_GET['msg']; ?> 
				</div>
			<?php } ?>	
		    <form method="POST" action="excelUpload.php" enctype="multipart/form-data">
				<div class="form-group">
					<label>Upload Excel File</label>
					<input type="file" name="file" class="form-control">
				</div>
				<div class="form-group">
					<button type="submit" name="Submit" class="btn btn-success">Upload</button>
				</div>
			</form>	
    		
			<div class="row">
				<p><a class="btn btn-success" href="graph.php">View Chart</a></p>
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
						  <th>S.no</th>
		                  <th>Name</th>
		                  <th>Salary</th>
		                  <th>Languages</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM customers ORDER BY id DESC';
					   $i = 1;
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $i . '</td>';
								echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['salary'] . '</td>';
							   	echo '<td>'. $row['languages'] . '</td>';
							   	echo '<td width=250>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
							   	echo '</td>';
							   	echo '</tr>';
						$i++;		
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>