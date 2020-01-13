<?php require_once('header.php'); ?>

<?php
    // Add Shipping Cost
    if (isset($_POST['form1'])) {
        $valid = 1;

        if (empty($_POST['country_id'])) {
            $valid = 0;
            $error_message .= 'You must have to select a country.<br>';
        }

        if ($_POST['amount'] == '') {
            $valid = 0;
            $error_message .= 'Amount can not be empty.<br>';
        } else {
            if (!is_numeric($_POST['amount'])) {
                $valid = 0;
                $error_message .= 'You must have to enter a valid number.<br>';
            }
        }

        if ($valid == 1) {
            $statement = $pdo->prepare("INSERT INTO tbl_shipping_cost (country_id, amount) VALUES (?, ?)");
            $statement->execute(array($_POST['country_id'], $_POST['amount']));

            $success_message = 'Shipping cost is added successfully.';
        }
    }

    // Add Shipping Cost (Rest of the world)
    if (isset($_POST['form2'])) {
        $valid = 1;

        if ($_POST['amount'] == '') {
            $valid = 0;
            $error_message .= 'Amount can not be empty.<br>';
        } else {
            if (!is_numeric($_POST['amount'])) {
                $valid = 0;
                $error_message .= 'You must have to enter a valid number.<br>';
            }
        }

        if ($valid == 1) {
            $statement = $pdo->prepare("UPDATE tbl_shipping_cost_all SET amount=? WHERE sca_id=1");
            $statement->execute(array($_POST['amount']));

            $success_message = 'Shipping cost for rest of the world is updated successfully.';
        }
    }
?>

<div class="container">
    <h3>Add Shipping Cost</h3>
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
                            $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                            $statement->execute(array($row['country_id']));
                            $total = $statement->rowCount();
                            // If country already in tbl_shipping_cost, skip.
                            if ($total) {
                                continue;
                            }
                            ?>
                            <option value="<?php echo $row['country_id']; ?>"><?php echo $row['country_name']; ?></option>
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
                <input type="text" class="form-control" name="amount">
            </div>
        </div>
        <div class="form-group row">                                            
            <div class="col-md-offset-2 col-md-6">  
                <button type="submit" class="btn btn-success" name="form1">Add</button>
            </div>
        </div>
    </form>
</div>

<div class="container">    
    <?php
        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $amount = $row['amount'];
        }
    ?>
    <h3>Shipping Cost (Rest of the world)</h3>
    <form class="" action="" method="post" style="margin-top: 36px;">
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
                <button type="submit" class="btn btn-success pull-left" name="form2">Update</button>
            </div>
        </div>
    </form>
</div>

<div class="box">
    <div class="box-header">
        <h1 class="box-title">View Shipping Costs</h1><br>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="showSliders" class="table table-bordered table-striped"> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Country Name</th>
                    <th>Country Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost t1 JOIN tbl_country t2 ON t1.country_id = t2.country_id ORDER BY t2.country_name ASC");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
                    foreach ($result as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['shipping_cost_id']; ?></td>
                            <td><?php echo $row['country_name']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                            <td>
                                <a href="shipping-cost-edit.php?id=<?php echo $row['shipping_cost_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                <a href="#" class="btn btn-danger btn-xs" data-href="shipping-cost-delete.php?id=<?php echo $row['shipping_cost_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    Are you sure want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <h4 style="padding: 15px;">Note: If a country does not exist in the above list, the following "Rest of the World" shipping cost will be applied upon that.</h4>
</div> 

<?php require_once('footer.php'); ?>

<script>
  $(function () {
    $('#showSliders').DataTable()
    // $('#example2').DataTable({
    //   'paging'      : true,
    //   'lengthChange': false,
    //   'searching'   : false,
    //   'ordering'    : true,
    //   'info'        : true,
    //   'autoWidth'   : false
    // })
  });

  $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
  });
</script>