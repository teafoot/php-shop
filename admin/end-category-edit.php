<?php require_once('header.php'); ?>

<?php
    if (!isset($_REQUEST['id'])) {
        header('location: logout.php');
        exit;
    } else {
        // Check the id is valid or not
        $statement = $pdo->prepare("SELECT * FROM tbl_end_category t1 JOIN tbl_mid_category t2 ON t1.mcat_id = t2.mcat_id JOIN tbl_top_category t3 ON t2.tcat_id = t3.tcat_id WHERE t1.ecat_id=?");
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

        if (empty($_POST['mcat_id'])) {
            $valid = 0;
            $error_message .= "You must have to select a mid level category<br>";
        }

        if (empty($_POST['ecat_name'])) {
            $valid = 0;
            $error_message .= "End level category name can not be empty<br>";
        }

        if ($valid == 1) {    	
    		// updating into the database
    		$statement = $pdo->prepare("UPDATE tbl_end_category SET ecat_name=?, mcat_id=? WHERE ecat_id=?");
    		$statement->execute(array($_POST['ecat_name'], $_POST['mcat_id'], $_REQUEST['id']));

        	$success_message = 'End Level Category is updated successfully.';
        }
    }
?>

<?php		
    $statement = $pdo->prepare("SELECT * FROM tbl_end_category t1 JOIN tbl_mid_category t2 ON t1.mcat_id = t2.mcat_id JOIN tbl_top_category t3 ON t2.tcat_id = t3.tcat_id WHERE t1.ecat_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);					
    foreach ($result as $row) {
    	$ecat_name = $row['ecat_name'];
        $mcat_id = $row['mcat_id'];
        $tcat_id = $row['tcat_id'];
    }
?>

<div class="container">
    <h3>Edit End Level Category</h3>
    <a href="end-category.php" class="btn btn-primary btn-sm">View All</a>
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
            <div class="col-md-3">
                <label for="tcat_id">Top Level Category Name *</label>
            </div>
            <div class="col-md-6">                  
                <select name="tcat_id" class="form-control select2 top-cat">
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
            <div class="col-md-3">
                <label for="mcat_id">Mid Level Category Name *</label>
            </div>
            <div class="col-md-6">                  
                <select name="mcat_id" class="form-control select2 mid-cat">
                    <option value="">Select Mid Level Category</option>
                    <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=? ORDER BY mcat_name ASC");
                        $statement->execute(array($tcat_id));
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                        foreach ($result as $row) {
                            ?>
                            <option value="<?php echo $row['mcat_id']; ?>" <?php if ($row['mcat_id'] == $mcat_id) {echo 'selected';} ?>><?php echo $row['mcat_name']; ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="ecat_name">End Level Category Name *</label>
            </div>
            <div class="col-md-6">                  
                <input type="text" class="form-control" name="ecat_name" value="<?php echo $ecat_name; ?>">
            </div>
        </div>
        <div class="form-group row">                                            
            <div class="col-md-offset-3 col-md-6">                  
                <button type="submit" class="btn btn-success" name="form1">Update</button>
            </div>
        </div>
    </form>    
</div>

<?php require_once('footer.php'); ?>

<script>
    $(".top-cat").on('change', function() {
        var id = $(this).val();
        var dataString = 'id='+ id;
        $.ajax({
            type: "POST",
            url: "get-mid-category.php",
            data: dataString,
            cache: false,
            success: function(html) {
                $(".mid-cat").html(html);
            }
        });         
    });
</script>