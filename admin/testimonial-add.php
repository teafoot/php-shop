<?php require_once('header.php'); ?>

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
    } else {
    	$valid = 0;
      $error_message .= 'You must have to select a photo<br>';
    }

		if ($valid == 1) {
			// getting next auto increment id
			$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_testimonial'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row) {
				$auto_increment_id = $row[10];
			}

			$final_file_name = 'testimonial-' . $auto_increment_id . '.' . $ext;
      move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);
		
			$statement = $pdo->prepare("INSERT INTO tbl_testimonial (name, designation, company, photo, comment) VALUES (?, ?, ?, ?, ?)");
			$statement->execute(array($_POST['name'], $_POST['designation'], $_POST['company'], $final_file_name, $_POST['comment']));
				
			$success_message = 'Testimonial is added successfully!';

			unset($_POST['name']);
			unset($_POST['designation']);
			unset($_POST['company']);
			unset($_POST['comment']);
		}
	}
?>

<div class="container">
	<h3>Add Testimonial</h3>
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
	<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" style="margin-top: 36px;">
		<div class="form-group row">
			<div class="col-md-2">
				<label for="name">Name *</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="name" value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="designation">Designation *</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="designation" value="<?php if (isset($_POST['designation'])) {echo $_POST['designation'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="company">Company *</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="company" value="<?php if (isset($_POST['company'])) {echo $_POST['company'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="photo">Photo *</label>
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
				<textarea class="form-control" name="comment" style="height:200px;"><?php if (isset($_POST['comment'])) {echo $_POST['comment'];} ?></textarea>
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