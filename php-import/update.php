<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$salaryError = null;
		$languagesError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$salary = $_POST['salary'];
		$languages = $_POST['languages'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter the Name';
			$valid = false;
		}
		
		if (empty($salary)) {
			$salaryError = 'Please enter the salary';
			$valid = false;
		}  
		
		if (empty($languages)) {
			$languagesError = 'Please enter the languages';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE customers  set name = ?, salary = ?, languages =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$salary,$languages,$id));
			Database::disconnect();
			header("Location: index.php?msg=Updated");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM customers where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['name'];
		$salary = $data['salary'];
		$languages = $data['languages'];
		Database::disconnect();
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($salaryError)?'error':'';?>">
					    <label class="control-label">salary</label>
					    <div class="controls">
					      	<input name="salary" type="text" placeholder="salary" value="<?php echo !empty($salary)?$salary:'';?>">
					      	<?php if (!empty($salaryError)): ?>
					      		<span class="help-inline"><?php echo $salaryError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($languagesError)?'error':'';?>">
					    <label class="control-label">Languages</label>
					    <div class="controls">
					      	<input name="languages" type="text"  placeholder="Languages" value="<?php echo !empty($languages)?$languages:'';?>">
					      	<?php if (!empty($languagesError)): ?>
					      		<span class="help-inline"><?php echo $languagesError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>