<?php require_once('header.php'); ?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;

    if (empty($_POST['caption'])) {
      $valid = 0;
      $error_message .= "Photo Caption Name can not be empty<br>";
    }

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if ($path == '') {
    	$valid = 0;
      $error_message .= "You must have to select a photo<br>";
    } else {
    	$ext = pathinfo($path, PATHINFO_EXTENSION);
      // $file_name = basename($path, '.' . $ext);
      if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
        $valid = 0;
        $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
      }
    }
    
    if ($valid == 1) {
    	// getting next auto increment id
			$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_photo'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row) {
				$auto_increment_id = $row[10];
			}

			// uploading the photo into the main location and giving it a final name
			$final_file_name = 'photo-' . $auto_increment_id . '.' . $ext;
      move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

			// saving into the database
			$statement = $pdo->prepare("INSERT INTO tbl_photo (caption, photo) VALUES (?, ?)");
			$statement->execute(array($_POST['caption'], $final_file_name));

    	$success_message = 'Photo is added successfully.';
    }
	}
?>

<div class="container">
	<h3>Add Photo</h3>
	<a href="photo.php" class="btn btn-primary btn-sm">View All</a>
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
	<form class="" action="" method="post" enctype="multipart/form-data" style="margin-top: 36px;">
		<div class="form-group row">
			<div class="col-md-2">
				<label for="caption">Photo Caption *</label>
			</div>
			<div class="col-md-6">		
				<input type="text" class="form-control" name="caption" value="<?php if (isset($_POST['caption'])) {echo $_POST['caption'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="photo">Upload Photo *</label>
			</div>
			<div class="col-md-6">		
				<input type="file" name="photo">
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