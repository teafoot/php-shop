<?php require_once('header.php'); ?>

<?php
    if (!isset($_REQUEST['id'])) {
        header('location: logout.php');
        exit;
    } else {
        // Check the id is valid or not
        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE shipping_cost_id=?");
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

        if (empty($_POST['country_id'])) {
            $valid = 0;
            $error_message .= "You must have to select a country<br>";
        } else {
    		// Duplicate Shipping Cost for country check
        	$statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE shipping_cost_id=?");
    		$statement->execute(array($_REQUEST['id']));
    		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
    		foreach ($result as $row) {
    			$current_country = $row['country_id'];
    		}

    		$statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=? AND country_id!=?");
        	$statement->execute(array($_POST['country_id'], $current_country));
        	$total = $statement->rowCount();							
        	if ($total) {
        		$valid = 0;
            	$error_message .= 'Country already exists<br>';
        	}
        }

        if ($valid == 1) {    	
    		// updating into the database
    		$statement = $pdo->prepare("UPDATE tbl_shipping_cost SET country_id=?, amount=? WHERE shipping_cost_id=?");
    		$statement->execute(array($_POST['country_id'], $_POST['amount'], $_REQUEST['id']));

        	$success_message = 'Shipping Cost is updated successfully.';
        }
    }
?>

<?php
    $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE shipping_cost_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
    	$country_id = $row['country_id'];
        $amount = $row['amount'];
    }
?>

<div class="container">
    <h3>Edit Shipping Cost</h3>
    <a href="shipping-cost.php" class="btn btn-primary btn-sm">View All</a>
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
                <label for="country_id">Select Country *</label>
            </div>
            <div class="col-md-6">            
                <select name="country_id" class="form-control select2">
                    <option value="">Select a country</option>
                    <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            ?>
                            <option value="<?php echo $row['country_id']; ?>" <?php if ($row['country_id'] == $country_id) {echo 'selected';} ?>><?php echo $row['country_name']; ?></option>
                            <?php
                        }
                    ?>                    
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <label for="amount">Amount *</label>
            </div>
            <div class="col-md-6">            
                <input type="text" class="form-control" name="amount" value="<?php echo $amount; ?>">
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