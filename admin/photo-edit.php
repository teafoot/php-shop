<?php require_once('header.php'); ?>

<?php
	if (!isset($_REQUEST['id'])) {
		header('location: logout.php');
		exit;
	} else {
		// Check the id is valid or not
		$statement = $pdo->prepare("SELECT * FROM tbl_photo WHERE id=?");
		$statement->execute(array($_REQUEST['id']));
		$total = $statement->rowCount();
		if ($total == 0) {
			header('location: logout.php');
			exit;
		}
	}
?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;

		if (empty($_POST['caption'])) {
      $valid = 0;
      $error_message .= "Photo Caption Name can not be empty<br>";
    }

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if ($path != '') {
    	$ext = pathinfo($path, PATHINFO_EXTENSION);
      // $file_name = basename( $path, '.' . $ext );
      if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
        $valid = 0;
        $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
      }
    }
	       
    if ($valid == 1) {
    	if ($path == '') {
    		// updating into the database w/o photo
				$statement = $pdo->prepare("UPDATE tbl_photo SET caption=? WHERE id=?");
				$statement->execute(array($_POST['caption'], $_REQUEST['id']));
    	} else {
    		unlink('../assets/uploads/' . $_POST['previous_photo']);

    		$final_file_name = 'photo-' . $_REQUEST['id'] . '.' . $ext;
        move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

        // updating into the database w/ photo
				$statement = $pdo->prepare("UPDATE tbl_photo SET caption=?, photo=? WHERE id=?");
				$statement->execute(array($_POST['caption'], $final_file_name, $_REQUEST['id']));
    	}
    	
    	$success_message = 'Photo is updated successfully.';
    }
	}
?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_photo WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$caption = $row['caption'];
		$photo = $row['photo'];
	}
?>

<div class="container">
	<h3>Edit Photo</h3>
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
				<input type="text" class="form-control" name="caption" value="<?php echo $caption; ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="">Existing Photo</label>
			</div>
			<div class="col-md-6">		
				<img src="../assets/uploads/<?php echo $photo; ?>" class="existing-photo" style="width:300px;">
			</div>
		</div>
		<input type="hidden" name="previous_photo" value="<?php echo $photo; ?>">
		<div class="form-group row">
			<div class="col-md-2">
				<label for="photo">Upload New Photo *</label>
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