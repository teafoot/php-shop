<?php require_once('header.php'); ?>

<div class="box">
  <div class="box-header">
		<h1 class="box-title">View Testimonials</h1><br>
		<a href="testimonial-add.php" class="btn btn-primary btn-sm" style="margin-top: 12px; margin-bottom: 12px;">Add Testimonial</a>
	</div>
  <!-- /.box-header -->
  <div class="box-body">
		<table id="showSliders" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th width="30">ID</th>
					<th>Photo</th>
					<th width="100">Name</th>
					<th width="100">Designation</th>
					<th width="100">Company</th>
					<th>Comment</th>
					<th width="80">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$statement = $pdo->prepare("SELECT id, name, designation, company, photo,	comment	FROM tbl_testimonial");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
					foreach ($result as $row) {
				?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td style="width:130px;">
								<img src="../assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>" style="width:120px;">
							</td>
							<td><?php echo $row['name']; ?></td>
							<td><?php echo $row['designation']; ?></td>
							<td><?php echo $row['company']; ?></td>
							<td><?php echo $row['comment']; ?></td>
							<td>										
								<a href="testimonial-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
								<a href="#" class="btn btn-danger btn-xs" data-href="testimonial-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>  
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