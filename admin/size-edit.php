<?php require_once('header.php'); ?>

<?php
    if (!isset($_REQUEST['id'])) {
        header('location: logout.php');
        exit;
    } else {
        // Check the id is valid or not
        $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
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

        if (empty($_POST['size_name'])) {
            $valid = 0;
            $error_message .= "Size Name can not be empty<br>";
        } else {
    		// Duplicate Size checking
        	$statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
    		$statement->execute(array($_REQUEST['id']));
    		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
    		foreach($result as $row) {
    			$current_size_name = $row['size_name'];
    		}

    		$statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_name=? and size_name!=?");
        	$statement->execute(array($_POST['size_name'], $current_size_name));
        	$total = $statement->rowCount();							
        	if ($total) {
        		$valid = 0;
            	$error_message .= 'Size name already exists<br>';
        	}
        }

        if ($valid == 1) {    	
    		// updating into the database
    		$statement = $pdo->prepare("UPDATE tbl_size SET size_name=? WHERE size_id=?");
    		$statement->execute(array($_POST['size_name'], $_REQUEST['id']));

        	$success_message = 'Size is updated successfully.';
        }
    }
?>

<?php			
    $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);				
    foreach ($result as $row) {
    	$size_name = $row['size_name'];
    }
?>

<div class="container">
    <h3>Edit Size</h3>
    <a href="size.php" class="btn btn-primary btn-sm">View All</a>
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
                <label for="size_name">Size Name *</label>
            </div>
            <div class="col-md-6">                              
                <input type="text" class="form-control" name="size_name" value="<?php echo $size_name; ?>">
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