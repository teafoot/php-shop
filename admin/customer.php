<?php require_once('header.php'); ?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title">View Customers</h1><br>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="showSliders" class="table table-bordered table-striped"> 
            <thead>
                <tr>
									<th width="30">ID</th>
									<th width="180">Name</th>
									<th width="180">Email Address</th>
									<th width="180">Country, City, State</th>
									<th>Status</th>
									<th width="100">Change Status</th>
									<th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
							<?php
								$statement = $pdo->prepare("SELECT * FROM tbl_customer t1 JOIN tbl_country t2 ON t1.cust_country = t2.country_id");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);						
								foreach ($result as $row) {
									?>
									<tr class="<?php if ($row['cust_status'] == 1) {echo 'bg-g';} else {echo 'bg-r';} ?>">
										<td><?php echo $row['cust_id']; ?></td>
										<td><?php echo $row['cust_name']; ?></td>
										<td><?php echo $row['cust_email']; ?></td>
										<td>
											<?php echo $row['country_name']; ?><br>
											<?php echo $row['cust_city']; ?><br>
											<?php echo $row['cust_state']; ?>
										</td>
										<td><?php if ($row['cust_status'] == 1) {echo 'Active';} else {echo 'Inactive';} ?></td>
										<td>
											<a href="customer-change-status.php?id=<?php echo $row['cust_id']; ?>" class="btn btn-success btn-xs">Change Status</a>
										</td>
										<td>
											<a href="#" class="btn btn-danger btn-xs" data-href="customer-delete.php?id=<?php echo $row['cust_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
										</td>
									</tr>
									<?php
								}
							?>							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
	</div>
</section>

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