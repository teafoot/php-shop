<?php require_once('header.php'); ?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;

		if (empty($_POST['title'])) {
			$valid = 0;
			$error_message .= 'Title can not be empty<br>';
		}

		if (empty($_POST['content'])) {
			$valid = 0;
			$error_message .= 'Content can not be empty<br>';
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
			$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_service'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach ($result as $row) {
				$auto_increment_id = $row[10];
			}

			$final_file_name = 'service-' . $auto_increment_id . '.' . $ext;
      move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);
		
			$statement = $pdo->prepare("INSERT INTO tbl_service (title, content, photo) VALUES (?, ?, ?)");
			$statement->execute(array($_POST['title'], $_POST['content'], $final_file_name));
				
			$success_message = 'Service is added successfully!';

			unset($_POST['title']);
			unset($_POST['content']);
		}
	}
?>

<div class="container">
	<h3>Add Service</h3>
	<a href="service.php" class="btn btn-primary btn-sm">View All</a>
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
				<label for="title">Title *</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="title" value="<?php if (isset($_POST['title'])) {echo $_POST['title'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="content">Content *</label>
			</div>
			<div class="col-md-6">
				<textarea class="form-control" name="content" style="height:200px;"><?php if (isset($_POST['content'])) {echo $_POST['content'];} ?></textarea>
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
			<div class="col-md-offset-2 col-md-6">
				<button type="submit" class="btn btn-success" name="form1">Submit</button>
			</div>
		</div>
	</form>
</div>

<?php require_once('footer.php'); ?>