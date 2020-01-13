<?php require_once('header.php'); ?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;

    if (empty($_POST['category_name'])) {
      $valid = 0;
      $error_message .= "Category Name can not be empty<br>";
    } else {
    	// Duplicate Category check
    	$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_name=?");
    	$statement->execute(array($_POST['category_name']));
    	$total = $statement->rowCount();
    	if ($total) {
    		$valid = 0;
      	$error_message .= "Category Name already exists<br>";
    	}
    }

    if ($valid == 1) {
	  	if ($_POST['category_slug'] == '') {
	  		// generate slug
	  		$temp_string = strtolower($_POST['category_name']);
	  		$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string); // replace if the specified character is not found
	  	} else {
	  		// user defined slug
	  		$temp_string = strtolower($_POST['category_slug']);
	  		$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string); // replace if the specified character is not found
	  	}

	  	// if slug already exists, then rename it
			$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_slug=?");
			$statement->execute(array($category_slug));
			$total = $statement->rowCount();
			if ($total) {
				$category_slug .= '-1';
			}
	    	
			// Saving data into the main table tbl_category
			$statement = $pdo->prepare("INSERT INTO tbl_category (category_name, category_slug, meta_title, meta_keyword, meta_description) VALUES (?, ?, ?, ?, ?)");
			$statement->execute(array($_POST['category_name'], $category_slug, $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_description']));
		
	  	$success_message = 'Category is added successfully.';

	  	unset($_POST['category_name']);
	  	unset($_POST['category_slug']);
	  	unset($_POST['meta_title']);
	  	unset($_POST['meta_keyword']);
	  	unset($_POST['meta_description']);
    }
	}
?>

<div class="container">
	<h3>Add Category</h3>
	<a href="category.php" class="btn btn-primary btn-sm">View All</a>
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
				<label for="category_name">Category Name *</label>
			</div>
			<div class="col-md-6">	
				<input type="text" class="form-control" name="category_name" placeholder="Example: Health Tips" value="<?php if (isset($_POST['category_name'])) {echo $_POST['category_name'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="category_slug">Category Slug</label>
			</div>
			<div class="col-md-6">	
				<input type="text" class="form-control" name="category_slug" placeholder="Example: health-tips" value="<?php if (isset($_POST['category_slug'])) {echo $_POST['category_slug'];} ?>">    
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">				
				<h3 class="seo-info">SEO Information</h3>
			</div>			
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="meta_title">Meta Title</label>
			</div>
			<div class="col-md-6">	
				<input type="text" class="form-control" name="meta_title" value="<?php if (isset($_POST['meta_title'])) {echo $_POST['meta_title'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="meta_keyword">Meta Keywords</label>
			</div>
			<div class="col-md-6">	
				<textarea class="form-control" name="meta_keyword" style="height:100px;"><?php if (isset($_POST['meta_keyword'])) {echo $_POST['meta_keyword'];} ?></textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="meta_description">Meta Description</label>
			</div>
			<div class="col-md-6">	
				<textarea class="form-control" name="meta_description" style="height:100px;"><?php if (isset($_POST['meta_description'])) {echo $_POST['meta_description'];} ?></textarea>
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