<?php require_once('header.php'); ?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;

    if (empty($_POST['country_name'])) {
      $valid = 0;
      $error_message .= "Country Name can not be empty<br>";
    } else {
    	// Duplicate Country check
    	$statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_name=?");
    	$statement->execute(array($_POST['country_name']));
    	$total = $statement->rowCount();
    	if ($total) {
    		$valid = 0;
      	$error_message .= "Country Name already exists<br>";
    	}
    }

    if ($valid == 1) {
			// Saving data into the main table tbl_country
			$statement = $pdo->prepare("INSERT INTO tbl_country (country_name) VALUES (?)");
			$statement->execute(array($_POST['country_name']));
	
    	$success_message = 'Country is added successfully.';
    }
	}
?>

<div class="container">
	<h3>Add Country</h3>
	<a href="country.php" class="btn btn-primary btn-sm">View All</a>
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
	<form class="" action="" method="post" style="margin-top: 36px;">
		<div class="form-group row">
			<div class="col-md-2">
				<label for="country_name">Country Name *</label>
			</div>
			<div class="col-md-6">			
				<input type="text" class="form-control" name="country_name">
			</div>
		</div>
		<div class="form-group row">											
			<div class="col-md-offset-2 col-md-6">	
				<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
			</div>
		</div>
	</form>
</div>

<?php require_once('footer.php'); ?>