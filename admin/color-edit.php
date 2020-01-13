<?php require_once('header.php'); ?>

<?php
    if (!isset($_REQUEST['id'])) {
        header('location: logout.php');
        exit;
    } else {
        // Check the id is valid or not
        $statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
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

        if (empty($_POST['color_name'])) {
            $valid = 0;
            $error_message .= "Color Name can not be empty<br>";
        } else {
    		// Duplicate Color check
        	$statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
    		$statement->execute(array($_REQUEST['id']));
    		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
    		foreach ($result as $row) {
    			$current_color_name = $row['color_name'];
    		}

    		$statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_name=? and color_name!=?");
        	$statement->execute(array($_POST['color_name'], $current_color_name));
        	$total = $statement->rowCount();							
        	if ($total) {
        		$valid = 0;
            	$error_message .= 'Color name already exists<br>';
        	}
        }

        if ($valid == 1) {    	
    		// updating into the database
    		$statement = $pdo->prepare("UPDATE tbl_color SET color_name=? WHERE color_id=?");
    		$statement->execute(array($_POST['color_name'], $_REQUEST['id']));

        	$success_message = 'Color is updated successfully.';
        }
    }
?>

<?php							
    $statement = $pdo->prepare("SELECT * FROM tbl_color WHERE color_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
    	$color_name = $row['color_name'];
    }
?>

<div class="container">
    <h3>Edit Color</h3>
    <a href="color.php" class="btn btn-primary btn-sm">View All</a>
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
                <label for="color_name">Color Name *</label>
            </div>
            <div class="col-md-6">          
                <input type="text" class="form-control" name="color_name" value="<?php echo $color_name; ?>">
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