<?php require_once('header.php'); ?>

<?php
	if (!isset($_REQUEST['id'])) {
		header('location: logout.php');
		exit;
	} else {
		// Check the id is valid or not
		$statement = $pdo->prepare("SELECT * FROM tbl_testimonial WHERE id=?");
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

		if (empty($_POST['name'])) {
			$valid = 0;
			$error_message .= 'Name can not be empty<br>';
		}

		if (empty($_POST['designation'])) {
			$valid = 0;
			$error_message .= 'Designation can not be empty<br>';
		}

		if (empty($_POST['company'])) {
			$valid = 0;
			$error_message .= 'Company Name can not be empty<br>';
		}

		if (empty($_POST['comment'])) {
			$valid = 0;
			$error_message .= 'Comment can not be empty<br>';
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
				// update w/o photo
				$statement = $pdo->prepare("UPDATE tbl_testimonial SET name=?, designation=?, company=?, comment=? WHERE id=?");
    		$statement->execute(array($_POST['name'], $_POST['designation'], $_POST['company'], $_POST['comment'], $_REQUEST['id']));
			} else {
				unlink('../assets/uploads/' . $_POST['current_photo']);

				$final_file_name = 'testimonial-' . $_REQUEST['id'] . '.' . $ext;
      	move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

      	// update w/ photo
      	$statement = $pdo->prepare("UPDATE tbl_testimonial SET name=?, designation=?, company=?, photo=?, comment=? WHERE id=?");
    		$statement->execute(array($_POST['name'], $_POST['designation'], $_POST['company'], $final_file_name, $_POST['comment'], $_REQUEST['id']));
			}	   

	    $success_message = 'Testimonial is updated successfully!';
		}
	}
?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_testimonial WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$name        = $row['name'];
		$designation = $row['designation'];
		$company     = $row['company'];
		$photo       = $row['photo'];
		$comment     = $row['comment'];
	}
?>

<div class="container">
	<h3>Edit Testimonial</h3>
	<a href="testimonial.php" class="btn btn-primary btn-sm">View All</a>
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
		<input type="hidden" name="current_photo" value="<?php echo $photo; ?>">
		<div class="form-group row">
			<div class="col-md-2">
				<label for="name">Name *</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="name" value="<?php echo $name; ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="designation">Designation *</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="designation" value="<?php echo $designation; ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="company">Company *</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="company" value="<?php echo $company; ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="">Existing Photo</label>
			</div>
			<div class="col-md-6">
				<img src="../assets/uploads/<?php echo $photo; ?>" alt="Slider Photo" style="width:180px;">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="photo">Photo</label>
			</div>
			<div class="col-md-6">
				<input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed)
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="comment">Comment *</label>
			</div>
			<div class="col-md-6">
				<textarea class="form-control" name="comment" style="height:140px;"><?php echo $comment; ?></textarea>
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