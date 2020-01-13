<?php require_once('header.php'); ?>

<div class="container">
  <h3>Select Customer</h3>
	<form class="form-horizontal" action="" method="post" style="margin-top: 36px;">
    <div class="form-group row">
      <div class="col-md-2">
      	<label for="cust_id">Select a Customer *</label>
      </div>
      <div class="col-md-6">		
				<select name="cust_id" class="form-control select2">
					<?php
						$statement = $pdo->prepare("SELECT * FROM tbl_customer ORDER BY cust_id ASC");
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);
						foreach ($result as $row) {
							?>
							<option value="<?php echo $row['cust_id']; ?>"><?php echo $row['cust_name']; ?> - <?php echo $row['cust_email']; ?></option>
							<?php
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group row">                                            
			<div class="col-md-offset-2 col-md-6">        				
				<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
			</div>
		</div>
	</form>
</div>

<?php if (isset($_POST['form1'])): ?>
	<div class="box">
    <div class="box-header">
        <h1 class="box-title">View All Customer Messages</h1><br>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table id="showSliders" class="table table-bordered table-striped"> 
				<thead>
					<tr>
						<th width="30">ID</th>
						<th width="100">Subject</th>
						<th width="200">Message</th>
						<th width="200">Order Details</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$statement = $pdo->prepare("SELECT * FROM tbl_customer_message WHERE cust_id=?");
						$statement->execute(array($_POST['cust_id']));
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);
						foreach ($result as $row) {
						?>
							<tr>
								<td><?php echo $row['customer_message_id']; ?></td>
								<td><?php echo $row['subject']; ?></td>
								<td><?php echo nl2br($row['message']); ?></td>
								<td><?php echo $row['order_detail']; ?></td>
							</tr>
						<?php
						}
					?>							
				</tbody>
			</table>
		</div>
	</div>
<?php endif; ?>

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
  })
</script>