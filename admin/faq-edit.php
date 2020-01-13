<?php require_once('header.php'); ?>

<?php
	if (!isset($_REQUEST['id'])) {
		header('location: logout.php');
		exit;
	} else {
		// Check the id is valid or not
		$statement = $pdo->prepare("SELECT * FROM tbl_faq WHERE faq_id=?");
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

		if (empty($_POST['faq_title'])) {
			$valid = 0;
			$error_message .= 'Title can not be empty<br>';
		}

		if (empty($_POST['faq_content'])) {
			$valid = 0;
			$error_message .= 'Content can not be empty<br>';
		}

		if ($valid == 1) {
			$statement = $pdo->prepare("UPDATE tbl_faq SET faq_title=?, faq_content=? WHERE faq_id=?");
			$statement->execute(array($_POST['faq_title'], $_POST['faq_content'], $_REQUEST['id']));

	    $success_message = 'FAQ is updated successfully!';
		}
	}
?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_faq WHERE faq_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$faq_title = $row['faq_title'];
		$faq_content = $row['faq_content'];
	}
?>

<div class="container">
	<h3>Edit FAQ</h3>
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
	<form class="form-horizontal" action="" method="post" style="margin-top: 36px;">
		<div class="form-group row">
			<div class="col-md-2">
				<label for="faq_title">Title *</label>
			</div>
			<div class="col-md-6">
				<input type="text" autocomplete="off" class="form-control" name="faq_title" value="<?php echo $faq_title; ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="faq_content">Content *</label>
			</div>
			<div class="col-md-6">
				<textarea class="form-control" name="faq_content" id="editor1" style="height:140px;"><?php echo $faq_content; ?></textarea>
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