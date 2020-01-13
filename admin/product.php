<?php require_once('header.php'); ?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title">View Products</h1><br>
        <a href="product-add.php" class="btn btn-primary btn-sm" style="margin-top: 12px; margin-bottom: 12px;">Add Product</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="showSliders" class="table table-bordered table-striped"> 
            <thead>
                <tr>
									<th width="30">ID</th>
									<th>Photo</th>
									<th width="200">Product Name</th>
									<th width="60">Old Price</th>
									<th width="60">Current Price</th>
									<th width="60">Quantity</th>
									<th>Is Featured?</th>
									<th>Is Active?</th>
									<th>Category</th>
									<th width="80">Action</th>
                </tr>
            </thead>
            <tbody>
							<?php
								$statement = $pdo->prepare("SELECT t1.p_id, t1.p_name, t1.p_old_price, t1.p_current_price, t1.p_qty, t1.p_featured_photo, t1.p_is_featured, t1.p_is_active, t1.ecat_id, t2.ecat_id, t2.ecat_name, t3.mcat_id, t3.mcat_name, t4.tcat_id,	t4.tcat_name FROM tbl_product t1 JOIN tbl_end_category t2 ON t1.ecat_id = t2.ecat_id JOIN tbl_mid_category t3	ON t2.mcat_id = t3.mcat_id JOIN tbl_top_category t4 ON t3.tcat_id = t4.tcat_id ORDER BY t1.p_id DESC");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);
								foreach ($result as $row) {
									?>
										<tr>
											<td><?php echo $row['p_id']; ?></td>
											<td style="width: 130px;"><img src="../assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="<?php echo $row['p_name']; ?>" style="width: 100px;"></td>
											<td><?php echo $row['p_name']; ?></td>
											<td><?php echo $row['p_old_price']; ?></td>
											<td><?php echo $row['p_current_price']; ?></td>
											<td><?php echo $row['p_qty']; ?></td>
											<td><?php if ($row['p_is_featured'] == 1) {echo 'Yes';} else {echo 'No';} ?></td>
											<td><?php if ($row['p_is_active'] == 1) {echo 'Yes';} else {echo 'No';} ?></td>
											<td><?php echo $row['tcat_name']; ?><br><?php echo $row['mcat_name']; ?><br><?php echo $row['ecat_name']; ?></td>
											<td>										
												<a href="product-edit.php?id=<?php echo $row['p_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
												<a href="#" class="btn btn-danger btn-xs" data-href="product-delete.php?id=<?php echo $row['p_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>  
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
	                <p>Are you sure want to delete this item?</p>
	                <p style="color:red;">Be careful! This product will be deleted from the order table, payment table, size table, color table and rating table also.</p>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	                <a class="btn btn-danger btn-ok">Delete</a>
	            </div>
	        </div>
	    </div>
		</div>
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