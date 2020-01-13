<?php require_once('header.php'); ?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;

    if (empty($_POST['title'])) {
      $valid = 0;
      $error_message .= "Video title can not be empty<br>";
    }

    if (empty($_POST['iframe_code'])) {
      $valid = 0;
      $error_message .= "Video iframe code can not be empty<br>";
    }
    
    if ($valid == 1) {
			// saving into the database
			$statement = $pdo->prepare("INSERT INTO tbl_video (title, iframe_code) VALUES (?, ?)");
			$statement->execute(array($_POST['title'], $_POST['iframe_code']));

	  	$success_message = 'Video is added successfully.';
    }
	}
?>

<div class="container">
	<h3>Add Video</h3>
	<a href="video.php" class="btn btn-primary btn-sm">View All</a>
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
	<form class="form-horizontal" action="" method="post" style="margin-top: 36px;">
		<div class="form-group row">
			<div class="col-md-2">
				<label for="title">Video Title *</label>
			</div>
			<div class="col-md-6">				
				<input type="text" class="form-control" name="title" value="<?php if (isset($_POST['title'])) {echo $_POST['title'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="iframe_code">iframe Code *</label>
			</div>
			<div class="col-md-6">				
				<textarea class="form-control" name="iframe_code" style="height:200px;"><?php if (isset($_POST['iframe_code'])) {echo $_POST['iframe_code'];} ?></textarea>
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