<?php require_once('header.php'); ?>

<?php
	if (!isset($_REQUEST['id'])) {
		header('location: logout.php');
		exit;
	} else {
		// Check the id is valid or not
		$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE id=?");
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
    }

		if ($valid == 1) {
			if ($path == '') {
				// update w/o photo
				$statement = $pdo->prepare("UPDATE tbl_service SET title=?, content=? WHERE id=?");
	    	$statement->execute(array($_POST['title'], $_POST['content'], $_REQUEST['id']));
			} else {
				unlink('../assets/uploads/' . $_POST['current_photo']);

				$final_file_name = 'service-' . $_REQUEST['id'] . '.' . $ext;
      	move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

      	// update w/ photo
      	$statement = $pdo->prepare("UPDATE tbl_service SET title=?, content=?, photo=? WHERE id=?");
    		$statement->execute(array($_POST['title'], $_POST['content'], $final_file_name, $_REQUEST['id']));
			}	   

	    $success_message = 'Service is updated successfully!';
		}
	}
?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_service WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$title = $row['title'];
		$content = $row['content'];
		$photo = $row['photo'];
	}
?>

<div class="container">
	<h3>Edit Service</h3>
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
		<input type="hidden" name="current_photo" value="<?php echo $photo; ?>">
		<div class="form-group row">
			<div class="col-md-2">
				<label for="title">Title *</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="title" value="<?php echo $title; ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="content">Content *</label>
			</div>
			<div class="col-md-6">
				<textarea class="form-control" name="content" style="height:140px;"><?php echo $content; ?></textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="">Existing Photo</label>
			</div>
			<div class="col-md-6">
				<img src="../assets/uploads/<?php echo $photo; ?>" alt="Service Photo" style="width:180px;">
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
			<div class="col-md-offset-2 col-md-6">
				<button type="submit" class="btn btn-success" name="form1">Submit</button>
			</div>
		</div>
	</form>
</div>

<?php require_once('footer.php'); ?>