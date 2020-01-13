<?php require_once('header.php'); ?>

<?php
	if (isset($_POST['form1'])) {
		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['facebook'], 'Facebook'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['twitter'], 'Twitter'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['linkedin'], 'LinkedIn'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['googleplus'], 'Google Plus'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['pinterest'], 'Pinterest'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['youtube'], 'YouTube'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['instagram'], 'Instagram'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['tumblr'], 'Tumblr'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['flickr'], 'Flickr'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['reddit'], 'Reddit'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['snapchat'], 'Snapchat'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['whatsapp'], 'WhatsApp'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['quora'], 'Quora'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['stumbleupon'], 'StumbleUpon'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['delicious'], 'Delicious'));

		$statement = $pdo->prepare("UPDATE tbl_social SET social_url=? WHERE social_name=?");
		$statement->execute(array($_POST['digg'], 'Digg'));

		$success_message = 'Social Media URLs are updated successfully.';
	}
?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_social");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		if ($row['social_name'] == 'Facebook') {
			$facebook = $row['social_url'];
		}

		if ($row['social_name'] == 'Twitter') {
			$twitter = $row['social_url'];
		}

		if ($row['social_name'] == 'LinkedIn') {
			$linkedin = $row['social_url'];
		}

		if ($row['social_name'] == 'Google Plus') {
			$googleplus = $row['social_url'];
		}

		if ($row['social_name'] == 'Pinterest') {
			$pinterest = $row['social_url'];
		}

		if ($row['social_name'] == 'YouTube') {
			$youtube = $row['social_url'];
		}

		if ($row['social_name'] == 'Instagram') {
			$instagram = $row['social_url'];
		}

		if ($row['social_name'] == 'Tumblr') {
			$tumblr = $row['social_url'];
		}

		if ($row['social_name'] == 'Flickr') {
			$flickr = $row['social_url'];
		}

		if ($row['social_name'] == 'Reddit') {
			$reddit = $row['social_url'];
		}

		if ($row['social_name'] == 'Snapchat') {
			$snapchat = $row['social_url'];
		}

		if ($row['social_name'] == 'WhatsApp') {
			$whatsapp = $row['social_url'];
		}

		if ($row['social_name'] == 'Quora') {
			$quora = $row['social_url'];
		}

		if ($row['social_name'] == 'StumbleUpon') {
			$stumbleupon = $row['social_url'];
		}

		if ($row['social_name'] == 'Delicious') {
			$delicious = $row['social_url'];
		}

		if ($row['social_name'] == 'Digg') {
			$digg = $row['social_url'];
		}
	}
?>

<div class="container">
  <h3>Social Media</h3>
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
	<p style="padding-bottom: 20px;">If you do not want to show a social media in your front end page, just leave the input field blank.</p>
	<form class="form-horizontal" action="" method="post">
		<div class="form-group row">
			<div class="col-md-3">
				<label for="">Facebook</label>
			</div>
			<div class="col-md-6">		
				<input type="text" class="form-control" name="facebook" value="<?php echo $facebook; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Twitter</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="twitter" value="<?php echo $twitter; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">LinkedIn</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="linkedin" value="<?php echo $linkedin; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Google Plus</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="googleplus" value="<?php echo $googleplus; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Pinterest</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="pinterest" value="<?php echo $pinterest; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">YouTube</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="youtube" value="<?php echo $youtube; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Instagram</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="instagram" value="<?php echo $instagram; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Tumblr</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="tumblr" value="<?php echo $tumblr; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Flickr</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="flickr" value="<?php echo $flickr; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Reddit</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="reddit" value="<?php echo $reddit; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Snapchat</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="snapchat" value="<?php echo $snapchat; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">WhatsApp</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="whatsapp" value="<?php echo $whatsapp; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Quora</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="quora" value="<?php echo $quora; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">StumbleUpon</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="stumbleupon" value="<?php echo $stumbleupon; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Delicious</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="delicious" value="<?php echo $delicious; ?>">
			</div>
		</div>
		<div class="form-group row">
      <div class="col-md-3">
      	<label for="">Digg</label>
      </div>
      <div class="col-md-6">
				<input type="text" class="form-control" name="digg" value="<?php echo $digg; ?>">
			</div>
		</div>
		<div class="form-group row">                                            
		  <div class="col-md-offset-3 col-md-6">
				<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
			</div>
		</div>
	</form>	
</div>

<?php require_once('footer.php'); ?>