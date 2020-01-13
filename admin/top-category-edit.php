<?php require_once('header.php'); ?>

<?php
    if (!isset($_REQUEST['id'])) {
        header('location: logout.php');
        exit;
    } else {
        // Check the id is valid or not
        $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id=?");
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

        if (empty($_POST['tcat_name'])) {
            $valid = 0;
            $error_message .= "Top Category Name can not be empty<br>";
        } else {
    		// Duplicate Top Category check
        	$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id=?");
    		$statement->execute(array($_REQUEST['id']));
    		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
    		foreach ($result as $row) {
    			$current_tcat_name = $row['tcat_name'];
    		}

    		$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_name=? and tcat_name!=?");
        	$statement->execute(array($_POST['tcat_name'], $current_tcat_name));
        	$total = $statement->rowCount();							
        	if ($total) {
        		$valid = 0;
            	$error_message .= 'Top Category name already exists<br>';
        	}
        }

        if ($valid == 1) {    	
    		// updating into the database
    		$statement = $pdo->prepare("UPDATE tbl_top_category SET tcat_name=?, show_on_menu=? WHERE tcat_id=?");
    		$statement->execute(array($_POST['tcat_name'], $_POST['show_on_menu'], $_REQUEST['id']));

        	$success_message = 'Top Category is updated successfully.';
        }
    }
?>

<?php							
    $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
    	$tcat_name = $row['tcat_name'];
        $show_on_menu = $row['show_on_menu'];
    }
?>

<div class="container">
    <h3>Edit Top Level Category</h3>
    <a href="top-category.php" class="btn btn-primary btn-sm">View All</a>
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
                <label for="tcat_name">Top Category Name *</label>
            </div>
            <div class="col-md-6">               
                <input type="text" class="form-control" name="tcat_name" value="<?php echo $tcat_name; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="show_on_menu">Show on Menu? *</label>
            </div>
            <div class="col-md-6">       
                <select name="show_on_menu" class="form-control" style="width:auto;">
                    <option value="0" <?php if ($show_on_menu == 0) {echo 'selected';} ?>>No</option>
                    <option value="1" <?php if ($show_on_menu == 1) {echo 'selected';} ?>>Yes</option>
                </select>
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