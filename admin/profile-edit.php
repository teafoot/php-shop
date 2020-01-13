<?php require_once('header.php'); ?>

<?php
	// UPDATE USER INFORMATION
	if (isset($_POST['form1'])) {
		if ($_SESSION['user']['role'] == 'Super Admin') {
			$valid = 1;

			if (empty($_POST['full_name'])) {
				$valid = 0;
				$error_message .= "Name can not be empty<br>";
			}

			if (empty($_POST['email'])) {
				$valid = 0;
				$error_message .= 'Email address can not be empty<br>';
			} else {
				if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
					$valid = 0;
					$error_message .= 'Email address must be valid<br>';
				} else {
					// current email address that is in the database
					$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
					$statement->execute(array($_SESSION['user']['id']));
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result as $row) {
						$current_email = $row['email'];
					}

					$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? AND email!=?");
					$statement->execute(array($_POST['email'], $current_email));
					$total = $statement->rowCount();

					if ($total) {
						$valid = 0;
						$error_message .= 'Email address already exists<br>';
					}
				}
			}

			if ($valid == 1) {
				$_SESSION['user']['full_name'] = $_POST['full_name'];
				$_SESSION['user']['email'] = $_POST['email'];

				$statement = $pdo->prepare("UPDATE tbl_user SET full_name=?, email=?, phone=? WHERE id=?");
				$statement->execute(array($_POST['full_name'], $_POST['email'], $_POST['phone'], $_SESSION['user']['id']));

				$success_message = 'User Information is updated successfully.';
			}
		}	else {
			$_SESSION['user']['phone'] = $_POST['phone'];

			$statement = $pdo->prepare("UPDATE tbl_user SET phone=? WHERE id=?");
			$statement->execute(array($_POST['phone'], $_SESSION['user']['id']));

			$success_message = 'User Information is updated successfully.';	
		}
	}

	// UPDATE PHOTO
	if(isset($_POST['form2'])) {
		$valid = 1;

		$path = $_FILES['photo']['name'];
		$path_tmp = $_FILES['photo']['tmp_name'];

		if ($path != '') {
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			// $file_name = basename($path, '.' . $ext);

			if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
				$valid = 0;
				$error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
			}
		}

		if ($valid == 1) {
			// removing the existing photo
			if ($_SESSION['user']['photo'] != '') {
				unlink('../assets/uploads/' . $_SESSION['user']['photo']);	
			}

			// updating the data
			$final_file_name = 'user-' . $_SESSION['user']['id'] . '.' . $ext;
			move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);
			$_SESSION['user']['photo'] = $final_file_name;

			$statement = $pdo->prepare("UPDATE tbl_user SET photo=? WHERE id=?");
			$statement->execute(array($final_file_name, $_SESSION['user']['id']));

			$success_message = 'User Photo is updated successfully.';
		}
	}

	// UPDATE PASSWORD
	if (isset($_POST['form3'])) {
		$valid = 1;

		if (empty($_POST['password']) || empty($_POST['re_password']) ) {
			$valid = 0;
			$error_message .= "Password can not be empty<br>";
		}

		if (!empty($_POST['password']) && !empty($_POST['re_password']) ) {
			if ($_POST['password'] != $_POST['re_password']) {
				$valid = 0;
				$error_message .= "Passwords do not match<br>";	
			}        
		}

		if ($valid == 1) {
			$_SESSION['user']['password'] = md5($_POST['password']);

			$statement = $pdo->prepare("UPDATE tbl_user SET password=? WHERE id=?");
			$statement->execute(array(md5($_POST['password']), $_SESSION['user']['id']));

			$success_message = 'User Password is updated successfully.';
		}
	}
?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=?");
	$statement->execute(array($_SESSION['user']['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$full_name = $row['full_name'];
		$email     = $row['email'];
		$phone     = $row['phone'];
		$photo     = $row['photo'];
		$role      = $row['role'];
	}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Profile</h1>
	</div>
</section>

<div class="row">
	<div class="col-md-12">
	    <div class="panel with-nav-tabs panel-default">
	        <div class="panel-heading">
	            <ul class="nav nav-tabs">
	                <li class="active"><a href="#tab1primary" data-toggle="tab">Update Information</a></li>
	                <li><a href="#tab2primary" data-toggle="tab">Update Photo</a></li>
	                <li><a href="#tab3primary" data-toggle="tab">Update Password</a></li>
	            </ul>
	        </div>
	        <div class="panel-body">
	            <div class="tab-content">
	                <div class="tab-pane fade in active" id="tab1primary">
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

	                	<form action="" method="post">
	                		<div class="form-group row">
												<div class="col-md-2">	
													<label for="" class="control-label">Name <span>*</span></label>
												</div>
												<?php
													if ($_SESSION['user']['role'] == 'Super Admin') {
													?>
														<div class="col-md-6">
															<input type="text" class="form-control" name="full_name" value="<?php echo $full_name; ?>">
														</div>
													<?php
													} else {
													?>
														<div class="col-md-6">
															<?php echo $full_name; ?>
														</div>
													<?php
													}
												?>
											</div>
	                		<div class="form-group row">
	                			<div class="col-md-2">
		                			<label for="">Profile Picture</label>
		                		</div>
		                		<div class="col-md-6">
													<img src="<?= BASE_URL ?>assets/uploads/<?= $photo ?>" class="existing-photo" width="140">
												</div>
											</div>
											<div class="form-group row">
												<div class="col-md-2">	
													<label for="email" class="control-label">Email Address <span>*</span></label>
												</div>
												<?php
													if ($_SESSION['user']['role'] == 'Super Admin') {
													?>
														<div class="col-md-6">
															<input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
														</div>
													<?php
													} else {
													?>
														<div class="col-md-6">
															<?php echo $email; ?>
														</div>
													<?php
													}
												?>
											</div>
											<div class="form-group row">
												<div class="col-md-2">
													<label for="phone">Phone</label>
												</div>
												<div class="col-md-6">
													<input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
												</div>
											</div>
											<div class="form-group row">
												<div class="col-md-2">	
													<label for="" class="control-label">Role <span>*</span></label>
												</div>
												<div class="col-md-6">
													<?php echo $role; ?>
												</div>
											</div>
											<div class="form-group row">											
												<div class="col-md-offset-2 col-md-6">
													<button type="submit" class="btn btn-success" name="form1">Update Information</button>
												</div>
											</div>
										</form>
	                </div>
	                <div class="tab-pane fade" id="tab2primary">
	                	<form action="" method="post" enctype="multipart/form-data">
	                		<div class="form-group row">
	                			<div class="col-md-2">	
	                				<label for="photo">New Photo</label>
	                			</div>
	                			<div class="col-md-6">
	                				<input type="file" name="photo">
	                			</div>
	                		</div>											
											<div class="form-group row">											
												<div class="col-md-offset-2 col-md-6">
													<button type="submit" class="btn btn-success pull-left" name="form2">Update Photo</button>
												</div>
											</div>
										</form>
	                </div>
	                <div class="tab-pane fade" id="tab3primary">
	                	<form action="" method="post">
	                		<div class="form-group row">
	                			<div class="col-md-2">	
	                				<label for="password">New Password</label>
												</div>
												<div class="col-md-6">
													<input type="password" class="form-control" name="password">
												</div>
											</div>
											<div class="form-group row">
	                			<div class="col-md-2">	
	                				<label for="re_password">Retype Password</label>
												</div>
												<div class="col-md-6">
													<input type="password" class="form-control" name="re_password">
												</div>
											</div>
											<div class="form-group row">		
												<div class="col-md-offset-2 col-md-6">									
													<button type="submit" class="btn btn-success" name="form3">Update Password</button>
												</div>
											</div>
										</form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>

<?php require_once('footer.php'); ?>