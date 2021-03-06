<?php require_once('header.php'); ?>

<div class="box">
  <div class="box-header">
        <h1 class="box-title">View Photos</h1><br>
        <a href="photo-add.php" class="btn btn-primary btn-sm" style="margin-top: 12px; margin-bottom: 12px;">Add Photo</a>
    </div>
  <!-- /.box-header -->
  <div class="box-body">
        <table id="showSliders" class="table table-bordered table-striped"> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Caption</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_photo");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
                    foreach ($result as $row) {
                ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['caption']; ?></td>
                            <td>
                                <img src="../assets/uploads/<?php echo $row['photo']; ?>" width="140">
                            </td>
                            <td>
                                <a href="photo-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                <a href="#" class="btn btn-danger btn-xs" data-href="photo-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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