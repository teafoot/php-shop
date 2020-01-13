<?php require_once('header.php'); ?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;

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
			// getting next auto incremented id
			$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_slider'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row) {
				$auto_increment_id = $row[10];
			}

			$final_file_name = 'slider-' . $auto_increment_id . '.' . $ext;
      move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);
		
			$statement = $pdo->prepare("INSERT INTO tbl_slider (photo, heading, content, button_text, button_url, position) VALUES (?, ?, ?, ?, ?, ?)");
			$statement->execute(array($final_file_name, $_POST['heading'], $_POST['content'], $_POST['button_text'], $_POST['button_url'], $_POST['position']));
				
			$success_message = 'Slider is added successfully!';

			unset($_POST['heading']);
			unset($_POST['content']);
			unset($_POST['button_text']);
			unset($_POST['button_url']);
			unset($_POST['position']);
		}
	}
?>

<div class="container">
	<h3>Add Slider</h3>
	<a href="slider.php" class="btn btn-primary btn-sm">View All</a>
	<?php if ($error_message): ?>
		<div class="callout callout-danger">
			<p>
				<?php echo $error_message; ?>
			</p>
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
				<label for="photo">Photo *</label>
			</div>
			<div class="col-md-6">
				<input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed)
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="heading">Heading</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="heading" value="<?php if (isset($_POST['heading'])) {echo $_POST['heading'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="content">Content</label>
			</div>
			<div class="col-md-6">
				<textarea class="form-control" name="content" style="height:140px;"><?php if (isset($_POST['content'])) {echo $_POST['content'];} ?></textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="button_text">Button Text</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="button_text" value="<?php if (isset($_POST['button_text'])) {echo $_POST['button_text'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="button_url">Button URL</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="button_url" value="<?php if (isset($_POST['button_url'])) {echo $_POST['button_url'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="position">Position</label>
			</div>
			<div class="col-md-6">
				<select name="position" class="form-control">
						<option value="Left" <?php if (isset($_POST['position']) && ($_POST['position'] == 'Left')) {echo 'selected';} ?>>Left</option>
						<option value="Center" <?php if (isset($_POST['position']) && ($_POST['position'] == 'Center')) {echo 'selected';} ?>>Center</option>
						<option value="Right" <?php if (isset($_POST['position']) && ($_POST['position'] == 'Right')) {echo 'selected';} ?>>Right</option>
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