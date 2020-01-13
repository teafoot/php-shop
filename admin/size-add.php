<?php require_once('header.php'); ?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;

    if (empty($_POST['size_name'])) {
      $valid = 0;
      $error_message .= "Size Name can not be empty<br>";
    } else {
    	// Duplicate Size check
    	$statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_name=?");
    	$statement->execute(array($_POST['size_name']));
    	$total = $statement->rowCount();
    	if ($total) {
    		$valid = 0;
        $error_message .= "Size Name already exists<br>";
    	}
    }

    if ($valid == 1) {
			// Saving data into the main table tbl_size
			$statement = $pdo->prepare("INSERT INTO tbl_size (size_name) VALUES (?)");
			$statement->execute(array($_POST['size_name']));
		
    	$success_message = 'Size is added successfully.';

    	unset($_POST['size_name']);
    }
	}
?>

<div class="container">
	<h3>Add Size</h3>
	<a href="size.php" class="btn btn-primary btn-sm">View All</a>
	<?php if ($error_message): ?>
		<div class="callout callout-danger">
			<p><?php echo $error_message; ?></p>
		</div>
	<?php endif; ?>
	<?php if ($success_message): ?>
		<div class="callout callout-success">
			<p><?php echo $success_message; ?></p>
		</div>
	<?php endif; ?>
	<form class="form-horizontal" action="" method="post" style="margin-top: 36px;">
		<div class="form-group row">
			<div class="col-md-2">
				<label for="size_name">Size Name *</label>
			</div>
			<div class="col-md-6">			
				<input type="text" class="form-control" name="size_name" value="<?php if (isset($_POST['size_name'])) {echo $_POST['size_name'];} ?>">
			</div>
		</div>
		<div class="form-group row">											
			<div class="col-md-offset-2 col-md-6">					
				<button type="submit" class="btn btn-success" name="form1">Submit</button>
			</div>
		</div>
	</form>	
</div>

<?php require_once('footer.php'); ?>