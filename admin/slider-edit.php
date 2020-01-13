<?php require_once('header.php'); ?>

<?php
	if (!isset($_REQUEST['id'])) {
		header('location: logout.php');
		exit;
	} else {
		// Check the id is valid or not
		$statement = $pdo->prepare("SELECT * FROM tbl_slider WHERE id=?");
		$statement->execute(array($_REQUEST['id']));
		$total = $statement->rowCount();
		if($total == 0) {
			header('location: logout.php');
			exit;
		}
	}
?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;
		
    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        // $file_name = basename( $path, '.' . $ext );
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif' ) {
          $valid = 0;
          $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

		if ($valid == 1) {
			if ($path == '') {
				// Update w/o photo
				$statement = $pdo->prepare("UPDATE tbl_slider SET heading=?, content=?, button_text=?, button_url=?, position=? WHERE id=?");
	    	$statement->execute(array($_POST['heading'], $_POST['content'], $_POST['button_text'], $_POST['button_url'], $_POST['position'], $_REQUEST['id']));
			} else {
				unlink('../assets/uploads/' . $_POST['current_photo']);

				$final_file_name = 'slider-' . $_REQUEST['id'] . '.' . $ext;
      	move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

      	// Update w/ photo
      	$statement = $pdo->prepare("UPDATE tbl_slider SET photo=?, heading=?, content=?, button_text=?, button_url=?, position=? WHERE id=?");
    		$statement->execute(array($final_file_name, $_POST['heading'], $_POST['content'], $_POST['button_text'], $_POST['button_url'], $_POST['position'], $_REQUEST['id']));
			}	   

	    $success_message = 'Slider is updated successfully!';
		}
	}
?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_slider WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$photo       = $row['photo'];
		$heading     = $row['heading'];
		$content     = $row['content'];
		$button_text = $row['button_text'];
		$button_url  = $row['button_url'];
		$position    = $row['position'];
	}
?>

<div class="container">
	<h3>Edit Slider</h3>
	<a href="slider.php" class="btn btn-primary btn-sm">View All</a>

	<?php if ($error_message): ?>
		<div class="callout callout-danger">
			<p><?php echo $error_message; ?></p>
		</div>
	<?php endif; ?>
	<?php if($success_message): ?>
		<div class="callout callout-success">
			<p><?php echo $success_message; ?></p>
		</div>
	<?php endif; ?>

	<form class="" action="" method="post" enctype="multipart/form-data" style="margin-top: 36px;">
		<input type="hidden" name="current_photo" value="<?php echo $photo; ?>">
		<div class="form-group row">
			<div class="col-md-2">
				<label for="">Existing Photo</label>
			</div>
			<div class="col-md-6">
				<img src="../assets/uploads/<?php echo $photo; ?>" alt="Slider Photo" style="width:400px;">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="">Photo</label>
			</div>
			<div class="col-md-6">
				<input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed)
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="">Heading</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="heading" value="<?= $heading ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="">Content</label>
			</div>
			<div class="col-md-6">
				<textarea class="form-control" name="content" style="height:140px;"><?php echo $content; ?></textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="">Button Text</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="button_text" value="<?php echo $button_text; ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="">Button URL</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="button_url" value="<?php echo $button_url; ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="">Position</label>
			</div>
			<div class="col-md-6">
				<select name="position" class="form-control">
					<option value="Left" <?php if ($position == 'Left') {echo 'selected';} ?>>Left</option>
					<option value="Center" <?php if ($position == 'Center') {echo 'selected';} ?>>Center</option>
					<option value="Right" <?php if ($position == 'Right') {echo 'selected';} ?>>Right</option>
				</select>
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