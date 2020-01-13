<?php require_once('header.php'); ?>

<?php
	if (isset($_POST['form1'])) {
		$valid = 1;

		if (empty($_POST['post_title'])) {
			$valid = 0;
			$error_message .= 'Post title can not be empty<br>';
		} else {
			// Duplicate Checking
    	$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_title=?");
    	$statement->execute(array($_POST['post_title']));
    	$total = $statement->rowCount();
    	if ($total) {
    		$valid = 0;
      	$error_message .= "Post title already exists<br>";
    	}
		}

		if (empty($_POST['post_content'])) {
			$valid = 0;
			$error_message .= 'Post content can not be empty<br>';
		}

		if (empty($_POST['post_date'])) {
			$valid = 0;
			$error_message .= 'Post publish date can not be empty<br>';
		}

		if (empty($_POST['category_id'])) {
			$valid = 0;
			$error_message .= 'You must have to select a category<br>';
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
			if ($_POST['post_slug'] == '') {
    		// generate slug
    		$temp_string = strtolower($_POST['post_title']);
    		$post_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string); // replace if the specified character is not found
    	} else {
    		// user defined slug
    		$temp_string = strtolower($_POST['post_slug']);
    		$post_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string); // replace if the specified character is not found
    	}

	    // if slug already exists, then rename it
			$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_slug=?");
			$statement->execute(array($post_slug));
			$total = $statement->rowCount();
			if ($total) {
				$post_slug .= '-1';
			}

			if ($path == '') {
				// update w/o photo
				$statement = $pdo->prepare("INSERT INTO tbl_post (post_title, post_slug, post_content, post_date, photo, category_id, total_view, meta_title, meta_keyword, meta_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$statement->execute(array($_POST['post_title'], $post_slug, $_POST['post_content'], $_POST['post_date'], '', $_POST['category_id'], 0, $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_description']));
			} else {
    		// update w/ photo
				// getting next auto increment id for photo renaming
				$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_post'");
				$statement->execute();
				$result = $statement->fetchAll();
				foreach ($result as $row) {
					$auto_increment_id = $row[10];
				}

    		$final_file_name = 'post-' . $auto_increment_id . '.' . $ext;
        move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

        $statement = $pdo->prepare("INSERT INTO tbl_post (post_title, post_slug, post_content, post_date, photo, category_id, total_view, meta_title, meta_keyword, meta_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$statement->execute(array($_POST['post_title'], $post_slug, $_POST['post_content'], $_POST['post_date'], $final_file_name, $_POST['category_id'], 0, $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_description']));
			}
		
			$success_message = 'Post is added successfully!';
		}
	}
?>

<div class="container">
	<h3>Add Post</h3>
	<a href="post.php" class="btn btn-primary btn-sm">View All</a>
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
				<label for="post_title">Post Title *</label>
			</div>
			<div class="col-md-6">	
				<input type="text" class="form-control" name="post_title" placeholder="Example: Post Headline" value="<?php if (isset($_POST['post_title'])) {echo $_POST['post_title'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="post_slug">Post Slug</label>
			</div>
			<div class="col-md-6">	
				<input type="text" class="form-control" name="post_slug" placeholder="Example: post-headline" value="<?php if (isset($_POST['post_slug'])) {echo $_POST['post_slug'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="post_content">Post Content *</label>
			</div>
			<div class="col-md-6">	
				<textarea class="form-control" name="post_content" id="editor1"><?php if (isset($_POST['post_content'])) {echo $_POST['post_content'];} ?></textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="post_date">Post Publish Date *</label>
			</div>
			<div class="col-md-6">	
				<input type="text" class="form-control" name="post_date" id="datepicker" value="<?php if (isset($_POST['post_date'])) {echo $_POST['post_date'];} else {echo date('d-m-Y');} ?>">(Format: dd-mm-yy)
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="photo">Featured Photo</label>
			</div>
			<div class="col-md-6">	
				<input type="file" name="photo">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="category_id">Select Category *</label>
			</div>
			<div class="col-md-6">	
				<select class="form-control select2" name="category_id">
					<option value="">Select a category</option>
					<?php
						$statement = $pdo->prepare("SELECT * FROM tbl_category ORDER BY category_name ASC");
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);
						foreach ($result as $row) {
							if (isset($_POST['category_id']) && ($row['category_id'] == $_POST['category_id'])) {
					?>
								<option value="<?php echo $row['category_id']; ?>" selected><?php echo $row['category_name']; ?></option>
					<?php		
							} else {
					?>
								<option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
					<?php
							}
						}
					?>
				</select>                 
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">				
				<h3 class="seo-info">SEO Information</h3>
			</div>			
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="meta_title">Meta Title</label>
			</div>
			<div class="col-md-6">	       
				<input type="text" class="form-control" name="meta_title" value="<?php if (isset($_POST['meta_title'])) {echo $_POST['meta_title'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="meta_keyword">Meta Keywords</label>
			</div>
			<div class="col-md-6">	
				<input type="text" class="form-control" name="meta_keyword" value="<?php if (isset($_POST['meta_keyword'])) {echo $_POST['meta_keyword'];} ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-2">
				<label for="meta_description">Meta Description</label>
			</div>
			<div class="col-md-6">	
				<textarea class="form-control" name="meta_description" style="height:200px;"><?php if (isset($_POST['meta_description'])) {echo $_POST['meta_description'];} ?></textarea>
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

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
  })
</script>