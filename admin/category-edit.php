<?php require_once('header.php'); ?>

<?php
    if (!isset($_REQUEST['id'])) {
        header('location: logout.php');
        exit;
    } else {
        // Check the id is valid or not
        $statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_id=?");
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

        if (empty($_POST['category_name'])) {
            $valid = 0;
            $error_message .= "Category Name can not be empty<br>";
        } else {
    		// Duplicate Category check
        	$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_id=?");
    		$statement->execute(array($_REQUEST['id']));
    		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
    		foreach ($result as $row) {
    			$current_category_name = $row['category_name'];
    		}

    		$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_name=? AND category_name!=?");
        	$statement->execute(array($_POST['category_name'], $current_category_name));
        	$total = $statement->rowCount();							
        	if ($total) {
        		$valid = 0;
            	$error_message .= 'Category name already exists<br>';
        	}
        }

        if ($valid == 1) {
        	if ($_POST['category_slug'] == '') {
        		// generate slug
        		$temp_string = strtolower($_POST['category_name']);
        		$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string); // replace if the specified character is not found
        	} else {
                // user defined slug
        		$temp_string = strtolower($_POST['category_slug']);
        		$category_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $temp_string); // replace if the specified character is not found
        	}

        	// if slug already exists, then rename it
    		$statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_slug=? AND category_name!=?");
    		$statement->execute(array($category_slug, $current_category_name));
    		$total = $statement->rowCount();
    		if ($total) {
    			$category_slug .= '-1';
    		}
        	
    		// updating into the database
    		$statement = $pdo->prepare("UPDATE tbl_category SET category_name=?, category_slug=?, meta_title=?, meta_keyword=?, meta_description=? WHERE category_id=?");
    		$statement->execute(array($_POST['category_name'], $category_slug, $_POST['meta_title'], $_POST['meta_keyword'], $_POST['meta_description'], $_REQUEST['id']));

        	$success_message = 'Category is updated successfully.';
        }
    }
?>

<?php							
    $statement = $pdo->prepare("SELECT * FROM tbl_category WHERE category_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
    	$category_name = $row['category_name'];
    	$category_slug = $row['category_slug'];
    	$meta_title = $row['meta_title'];
    	$meta_keyword = $row['meta_keyword'];
    	$meta_description = $row['meta_description'];
    }
?>

<div class="container">
    <h3>Edit Category</h3>
    <a href="category.php" class="btn btn-primary btn-sm">View All</a>
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
                <label for="category_name">Category Name *</label>
            </div>
            <div class="col-md-6">          
                <input type="text" class="form-control" name="category_name" value="<?php echo $category_name; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="category_slug">Category Slug</label>
            </div>
            <div class="col-md-6">          
                <input type="text" class="form-control" name="category_slug" value="<?php echo $category_slug; ?>">
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
                <textarea class="form-control" name="meta_keyword" style="height:100px;"><?php echo $meta_keyword; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="meta_description">Meta Description</label>
            </div>
            <div class="col-md-6">          
                <textarea class="form-control" name="meta_description" style="height:100px;"><?php echo $meta_description; ?></textarea>
            </div>
        </div>
        <div class="form-group row">                                            
            <div class="col-md-offset-2 col-md-6">          
                <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
            </div>
        </div>
    </form>
</div>

<?php require_once('footer.php'); ?>