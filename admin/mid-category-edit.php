<?php require_once('header.php'); ?>

<?php
    if (!isset($_REQUEST['id'])) {
        header('location: logout.php');
        exit;
    } else {
        // Check the id is valid or not
        $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id=?");
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

        if (empty($_POST['tcat_id'])) {
            $valid = 0;
            $error_message .= "You must have to select a top level category<br>";
        }

        if (empty($_POST['mcat_name'])) {
            $valid = 0;
            $error_message .= "Mid Level Category Name can not be empty<br>";
        }

        if ($valid == 1) {    	
    		// updating into the database
    		$statement = $pdo->prepare("UPDATE tbl_mid_category SET mcat_name=?, tcat_id=? WHERE mcat_id=?");
    		$statement->execute(array($_POST['mcat_name'], $_POST['tcat_id'], $_REQUEST['id']));

        	$success_message = 'Mid Level Category is updated successfully.';
        }
    }
?>

<?php							
    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
    	$mcat_name = $row['mcat_name'];
        $tcat_id = $row['tcat_id'];
    }
?>

<div class="container">
    <h3>Edit Mid Level Category</h3>
    <a href="mid-category.php" class="btn btn-primary btn-sm">View All</a>
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
                <label for="tcat_id">Top Level Category Name *</label>
            </div>
            <div class="col-md-6">                   
                <select name="tcat_id" class="form-control select2">
                    <option value="">Select Top Level Category</option>
                    <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                        foreach ($result as $row) {
                            ?>
                            <option value="<?php echo $row['tcat_id']; ?>" <?php if ($row['tcat_id'] == $tcat_id) {echo 'selected';} ?>><?php echo $row['tcat_name']; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="mcat_name">Mid Level Category Name *</label>
            </div>
            <div class="col-md-6">           
                <input type="text" class="form-control" name="mcat_name" value="<?php echo $mcat_name; ?>">
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