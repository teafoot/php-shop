<?php require_once('header.php'); ?>

<?php
	if (!isset($_REQUEST['id'])) {
		header('location: logout.php');
		exit;
	} else {
		// Check the id is valid or not
		$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=?");
		$statement->execute(array($_REQUEST['id']));
		$total = $statement->rowCount();
		if ($total == 0) {
			header('location: logout.php');
			exit;
		}
	}
?>

<?php
	if(isset($_POST['form1'])) {
		$valid = 1;

		if (empty($_POST['post_title'])) {
			$valid = 0;
			$error_message .= 'Post title can not be empty<br>';
		} else {
			// Duplicate Post title check
	    $statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=?");
			$statement->execute(array($_REQUEST['id']));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $row) {
				$current_post_title = $row['post_title'];
			}

			$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_title=? AND post_title!=?");
    	$statement->execute(array($_POST['post_title'], $current_post_title));
    	$total = $statement->rowCount();							
    	if ($total) {
    		$valid = 0;
      	$error_message .= 'Post title already exists<br>';
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
			$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_slug=? AND post_title!=?");
			$statement->execute(array($post_slug, $current_post_title));
			$total = $statement->rowCount();
			if ($total) {
				$post_slug .= '-1';
			}

			$previous_photo = $_POST['previous_photo'];

			// If previous image not found and user do not want to change the photo
	    if ($previous_photo == '' && $path == '') {
	    	$statement = $pdo->prepare("UPDATE tbl_post SET post_title=?, post_slug=?, post_content=?, post_date=?, category_id=?, meta_title=?, meta_keyword=?, meta_description=? WHERE post_id=?");
	    	$statement->execute(array($_POST['post_title'], $post_slug, $_POST['post_content'], $_POST['post_date'], $_POST['category_id'], $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_description'], $_REQUEST['id']));
	    }

			// If previous image found and user do not want to change the photo
	    if ($previous_photo != '' && $path == '') {
	    	$statement = $pdo->prepare("UPDATE tbl_post SET post_title=?, post_slug=?, post_content=?, post_date=?, category_id=?, meta_title=?, meta_keyword=?, meta_description=? WHERE post_id=?");
	    	$statement->execute(array($_POST['post_title'], $post_slug, $_POST['post_content'], $_POST['post_date'], $_POST['category_id'], $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_description'], $_REQUEST['id']));
	    }

	    // If previous image not found and user want to change the photo
	    if ($previous_photo == '' && $path != '') {
	    	$final_file_name = 'post-' . $_REQUEST['id'] . '.' . $ext;
        move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

	    	$statement = $pdo->prepare("UPDATE tbl_post SET post_title=?, post_slug=?, post_content=?, post_date=?, photo=?, category_id=?, meta_title=?, meta_keyword=?, meta_description=? WHERE post_id=?");
	    	$statement->execute(array($_POST['post_title'], $post_slug, $_POST['post_content'], $_POST['post_date'], $final_file_name, $_POST['category_id'], $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_description'], $_REQUEST['id']));
	    }
		    
		  // If previous image found and user want to change the photo
			if ($previous_photo != '' && $path != '') {
	    	unlink('../assets/uploads/' . $previous_photo);

	    	$final_file_name = 'post-' . $_REQUEST['id'] . '.' . $ext;
        move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

	    	$statement = $pdo->prepare("UPDATE tbl_post SET post_title=?, post_slug=?, post_content=?, post_date=?, photo=?, category_id=?, meta_title=?, meta_keyword=?, meta_description=? WHERE post_id=?");
	    	$statement->execute(array($_POST['post_title'], $post_slug, $_POST['post_content'], $_POST['post_date'], $final_file_name, $_POST['category_id'], $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_description'], $_REQUEST['id']));
	    }

	    $success_message = 'Post is updated successfully!';
		}
	}
?>

<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$post_title       = $row['post_title'];
		$post_slug        = $row['post_slug'];
		$post_content     = $row['post_content'];
		$post_date        = $row['post_date'];
		$photo            = $row['photo'];
		$category_id      = $row['category_id'];
		$meta_title       = $row['meta_title'];
		$meta_keyword     = $row['meta_keyword'];
		$meta_description = $row['meta_description'];
	}
?>

<div class="container">
    <h3>Edit Post</h3>
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
`		<form class="" action="" method="post" enctype="multipart/form-data" style="margin-top: 36px;">
			<div class="form-group row">
        <div class="col-md-2">
          <label for="post_title">Post Title *</label>
        </div>
        <div class="col-md-6">          			
					<input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
				</div>
			</div>
			<div class="form-group row">
        <div class="col-md-2">
          <label for="post_slug">Post Slug</label>
        </div>
        <div class="col-md-6">          			
					<input type="text" class="form-control" name="post_slug" value="<?php echo $post_slug; ?>">
				</div>
			</div>
			<div class="form-group row">
        <div class="col-md-2">
          <label for="post_content">Post Content *</label>
        </div>
        <div class="col-md-6">          			
					<textarea class="form-control" name="post_content" id="editor1"><?php echo $post_content; ?></textarea>                            
				</div>
			</div>
			<div class="form-group row">
        <div class="col-md-2">
          <label for="post_date">Post Publish Date *</label>
        </div>
        <div class="col-md-6">          			
					<input type="text" class="form-control" name="post_date" id="datepicker" value="<?php echo $post_date; ?>">(Format: dd-mm-yy)
				</div>
			</div>
			<div class="form-group row">
        <div class="col-md-2">
          <label for="">Existing Featured Photo</label>
        </div>
        <div class="col-md-6">      
					<?php
						if ($photo == '') {
							echo 'No photo found';
						} else {
							echo '<img src="../assets/uploads/' . $photo . '" class="existing-photo" style="width:200px;">';	
						}
					?>
				</div>
			</div>
			<input type="hidden" name="previous_photo" value="<?php echo $photo; ?>">
			<div class="form-group row">
        <div class="col-md-2">
          <label for="photo">Change Featured Photo</label>
        </div>
        <div class="col-md-6">          			
					<input type="file" name="photo">
				</div>
			</div>      
			<div class="form-group row">
        <div class="col-md-2">
          <label for="category_id">Categories *</label>
        </div>
        <div class="col-md-6">          			
					<select class="form-control select2" name="category_id">
						<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_category ORDER BY category_name ASC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
							?>
								<option value="<?php echo $row['category_id']; ?>" <?php if ($row['category_id'] == $category_id) {echo 'selected';} ?>><?php echo $row['category_name']; ?></option>
						<?php
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
					<input type="text" class="form-control" name="meta_title" value="<?php echo $meta_title; ?>">
				</div>
			</div>
			<div class="form-group row">
        <div class="col-md-2">
          <label for="meta_keyword">Meta Keywords</label>
        </div>
        <div class="col-md-6">          			
					<input type="text" class="form-control" name="meta_keyword" value="<?php echo $meta_keyword; ?>">
				</div>
			</div>
			<div class="form-group row">
        <div class="col-md-2">
          <label for="meta_description">Meta Description</label>
        </div>
        <div class="col-md-6">          			
					<textarea class="form-control" name="meta_description" style="height:200px;"><?php echo $meta_description; ?></textarea>
				</div>
			</div>
			<div class="form-group row">                                            
        <div class="col-md-offset-2 col-md-6">   
					<button type="submit" class="btn btn-success" name="form1">Update</button>
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