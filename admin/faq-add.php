<?php require_once('header.php'); ?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;

		if (empty($_POST['faq_title'])) {
			$valid = 0;
			$error_message .= 'Title can not be empty<br>';
		}

		if (empty($_POST['faq_content'])) {
			$valid = 0;
			$error_message .= 'Content can not be empty<br>';
		}

		if ($valid == 1) {
			$statement = $pdo->prepare("INSERT INTO tbl_faq (faq_title, faq_content) VALUES (?, ?)");
			$statement->execute(array($_POST['faq_title'], $_POST['faq_content']));
				
			$success_message = 'FAQ is added successfully!';

			unset($_POST['faq_title']);
			unset($_POST['faq_content']);
		}
	}
?>

<div class="container">
	<h3>Add FAQ</h3>
	<a href="faq.php" class="btn btn-primary btn-sm">View All</a>
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
				<label for="faq_title">Title *</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="faq_title" value="<?php if (isset($_POST['faq_title'])) {echo $_POST['faq_title'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="faq_content">Content *</label>
			</div>
			<div class="col-md-6">
				<textarea class="form-control" name="faq_content" id="editor1" style="height:200px;"><?php if (isset($_POST['faq_content'])) {echo $_POST['faq_content'];} ?></textarea>
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