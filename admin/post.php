<?php require_once('header.php'); ?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title">View Posts</h1><br>
        <a href="post-add.php" class="btn btn-primary btn-sm" style="margin-top: 12px; margin-bottom: 12px;">Add Post</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="showSliders" class="table table-bordered table-striped"> 
            <thead>
                <tr>
									<th>ID</th>
									<th>Thumbnail</th>
									<th>Title</th>
									<th>Category</th>
									<th>Action</th>
                </tr>
            </thead>
            <tbody>
							<?php
								$statement = $pdo->prepare("SELECT t1.post_id, t1.post_title, t1.post_content, t1.photo, t1.category_id, t2.category_id, t2.category_name	FROM tbl_post t1 JOIN tbl_category t2	ON t1.category_id = t2.category_id ORDER BY t1.post_id DESC");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
								foreach ($result as $row) {
							?>
									<tr>
										<td><?php echo $row['post_id']; ?></td>
										<td>
											<?php
												if ($row['photo'] == '') {
													echo '<img src="../assets/uploads/no-photo1.jpg" alt="" style="width:180px;">';
												} else {
													echo '<img src="../assets/uploads/' . $row['photo'] . '" alt="' . $row['post_title'] . '" style="width:180px;">';
												}
											?>
										</td>
										<td><?php echo $row['post_title']; ?></td>
										<td><?php echo $row['category_name']; ?></td>
										<td>										
											<a href="post-edit.php?id=<?php echo $row['post_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
											<a href="#" class="btn btn-danger btn-xs" data-href="post-delete.php?id=<?php echo $row['post_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>  
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