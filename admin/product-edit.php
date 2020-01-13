<?php require_once('header.php'); ?>

<?php
  if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
  } else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
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

    if (empty($_POST['ecat_id'])) {
      $valid = 0;
      $error_message .= "You must have to select an end level category<br>";
    }

    if (empty($_POST['p_name'])) {
      $valid = 0;
      $error_message .= "Product name can not be empty<br>";
    }

    if (empty($_POST['p_current_price'])) {
      $valid = 0;
      $error_message .= "Current Price can not be empty<br>";
    }

    if (empty($_POST['p_qty'])) {
      $valid = 0;
      $error_message .= "Quantity can not be empty<br>";
    }

    $p_featured_photo_path = $_FILES['p_featured_photo']['name'];
    $p_featured_photo_path_tmp = $_FILES['p_featured_photo']['tmp_name'];

    if ($p_featured_photo_path != '') {
      $p_featured_photo_ext = pathinfo($p_featured_photo_path, PATHINFO_EXTENSION);
      // $file_name = basename( $p_featured_photo_path, '.' . $p_featured_photo_ext );
      if ($p_featured_photo_ext != 'jpg' && $p_featured_photo_ext != 'png' && $p_featured_photo_ext != 'jpeg' && $p_featured_photo_ext != 'gif') {
        $valid = 0;
        $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
      }
    }

    if ($valid == 1) {
      // Update product featured photo
      if ($p_featured_photo_path == '') {
        // Update w/o featured photo
        $statement = $pdo->prepare("UPDATE tbl_product SET p_name=?, p_old_price=?, p_current_price=?, p_qty=?, p_description=?, p_short_description=?, p_feature=?, p_condition=?, p_return_policy=?, p_is_featured=?, p_is_active=?, ecat_id=? WHERE p_id=?");
        $statement->execute(array($_POST['p_name'], $_POST['p_old_price'], $_POST['p_current_price'], $_POST['p_qty'], $_POST['p_description'], $_POST['p_short_description'], $_POST['p_feature'], $_POST['p_condition'], $_POST['p_return_policy'], $_POST['p_is_featured'], $_POST['p_is_active'], $_POST['ecat_id'], $_REQUEST['id']));
      } else {
        // Update w/ featured photo
        unlink('../assets/uploads/' . $_POST['current_photo']);

        $final_product_featured_photo = 'product-featured-' . $_REQUEST['id'] . '.' . $p_featured_photo_ext;
        move_uploaded_file($p_featured_photo_path_tmp, '../assets/uploads/' . $final_product_featured_photo);

        $statement = $pdo->prepare("UPDATE tbl_product SET p_name=?, p_old_price=?, p_current_price=?, p_qty=?, p_featured_photo=?, p_description=?, p_short_description=?, p_feature=?, p_condition=?, p_return_policy=?, p_is_featured=?, p_is_active=?, ecat_id=? WHERE p_id=?");
        $statement->execute(array($_POST['p_name'], $_POST['p_old_price'], $_POST['p_current_price'], $_POST['p_qty'], $final_product_featured_photo, $_POST['p_description'], $_POST['p_short_description'], $_POST['p_feature'], $_POST['p_condition'], $_POST['p_return_policy'], $_POST['p_is_featured'], $_POST['p_is_active'], $_POST['ecat_id'], $_REQUEST['id']));
      }

      // Update product photos
    	if (isset($_FILES['photo']['name']) && isset($_FILES['photo']['tmp_name']) ) {
      	$photos = array();
        $photos = $_FILES['photo']['name'];
        $photos = array_values(array_filter($photos));

      	$photos_temp = array();
        $photos_temp = $_FILES['photo']['tmp_name'];
        $photos_temp = array_values(array_filter($photos_temp));

      	$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
  			$statement->execute();
  			$result = $statement->fetchAll();
  			foreach ($result as $row) {
  				$auto_increment_id_tbl_product_photo = $row[10];
  			}

  			$aiitpp = $auto_increment_id_tbl_product_photo;
        $counter = 0;
        for ($i = 0; $i < count($photos); $i++) {
          $photo_ext = pathinfo($photos[$i], PATHINFO_EXTENSION);
	        if ($photo_ext == 'jpg' || $photo_ext == 'png' || $photo_ext == 'jpeg' || $photo_ext == 'gif') {
            $final_product_photos[$counter] = $aiitpp . '.' . $photo_ext;
            move_uploaded_file($photos_temp[$i], "../assets/uploads/product_photos/" . $final_product_photos[$counter]);
            $counter++;
            $aiitpp++;
	        }
        }

        if (isset($final_product_photos)) {
        	for ($i = 0; $i < count($final_product_photos); $i++) {
	        	$statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo, p_id) VALUES (?, ?)");
	        	$statement->execute(array($final_product_photos[$i], $_REQUEST['id']));
          }
        }            
      }

      if (isset($_POST['size'])) {
      	$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
      	$statement->execute(array($_REQUEST['id']));

  			foreach($_POST['size'] as $size) {
  				$statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id, p_id) VALUES (?, ?)");
  				$statement->execute(array($size, $_REQUEST['id']));
  			}
  		} else {
  			$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
      	$statement->execute(array($_REQUEST['id']));
  		}

  		if (isset($_POST['color'])) {
  			$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
      	$statement->execute(array($_REQUEST['id']));

  			foreach($_POST['color'] as $color) {
  				$statement = $pdo->prepare("INSERT INTO tbl_product_color (color_id, p_id) VALUES (?, ?)");
  				$statement->execute(array($color, $_REQUEST['id']));
  			}
  		} else {
  			$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
      	$statement->execute(array($_REQUEST['id']));
  		}
  	
    	$success_message = 'Product is updated successfully.';
    }
  }
?>

<?php
  $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
  $statement->execute(array($_REQUEST['id']));
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
  	$p_name = $row['p_name'];
  	$p_old_price = $row['p_old_price'];
  	$p_current_price = $row['p_current_price'];
  	$p_qty = $row['p_qty'];
  	$p_featured_photo = $row['p_featured_photo'];
  	$p_description = $row['p_description'];
  	$p_short_description = $row['p_short_description'];
  	$p_feature = $row['p_feature'];
  	$p_condition = $row['p_condition'];
  	$p_return_policy = $row['p_return_policy'];
  	$p_is_featured = $row['p_is_featured'];
  	$p_is_active = $row['p_is_active'];
  	$ecat_id = $row['ecat_id'];
  }

  $statement = $pdo->prepare("SELECT * FROM tbl_end_category t1 JOIN tbl_mid_category t2 ON t1.mcat_id = t2.mcat_id JOIN tbl_top_category t3 ON t2.tcat_id = t3.tcat_id WHERE t1.ecat_id=?");
  $statement->execute(array($ecat_id));
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
  	$ecat_name = $row['ecat_name'];
    $mcat_id = $row['mcat_id'];
    $tcat_id = $row['tcat_id'];
  }

  $statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id=?");
  $statement->execute(array($_REQUEST['id']));
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
  foreach ($result as $row) {
  	$size_id[] = $row['size_id'];
  }

  $statement = $pdo->prepare("SELECT * FROM tbl_product_color WHERE p_id=?");
  $statement->execute(array($_REQUEST['id']));
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
  foreach ($result as $row) {
  	$color_id[] = $row['color_id'];
  }
?>

<div class="container">
  <h3>Edit Product</h3>
  <a href="product.php" class="btn btn-primary btn-sm">View All</a>
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
	<form class="" action="" method="post" enctype="multipart/form-data" style="margin-top: 36px;">
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
      	<label for="ecat_id">End Level Category Name *</label>
      </div>
      <div class="col-md-6">   		
				<select name="ecat_id" class="form-control select2 end-cat">
					<option value="">Select End Level Category</option>
					<?php
            $statement = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=? ORDER BY ecat_name ASC");
            $statement->execute(array($mcat_id));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
            foreach ($result as $row) {
                ?>
              <option value="<?php echo $row['ecat_id']; ?>" <?php if ($row['ecat_id'] == $ecat_id) {echo 'selected';} ?>><?php echo $row['ecat_name']; ?></option>
                <?php
            }
            ?>					
				</select>
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_name">Product Name *</label>
      </div>
      <div class="col-md-6">   		
				<input type="text" name="p_name" class="form-control" value="<?php echo $p_name; ?>">
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_old_price">Old Price (In USD)</label>
      </div>
      <div class="col-md-6">   		
				<input type="text" name="p_old_price" class="form-control" value="<?php echo $p_old_price; ?>">
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_current_price">Current Price * (In USD)</label>
      </div>
      <div class="col-md-6">   		
				<input type="text" name="p_current_price" class="form-control" value="<?php echo $p_current_price; ?>">
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_qty">Quantity *</label>
      </div>
      <div class="col-md-6">   		
				<input type="text" name="p_qty" class="form-control" value="<?php echo $p_qty; ?>">
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="size[]">Select Size</label>
      </div>
      <div class="col-md-6">   		
				<select name="size[]" class="form-control select2" multiple="multiple">
					<?php
						$is_selected = '';
						$statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size_id ASC");
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);			
						foreach ($result as $row) {
							if (isset($size_id)) {
								if (in_array($row['size_id'], $size_id)) {
									$is_selected = 'selected';
								} else {
									$is_selected = '';
								}
							}
							?>
								<option value="<?php echo $row['size_id']; ?>" <?php echo $is_selected; ?>><?php echo $row['size_name']; ?></option>
							<?php
						}
					?>
				</select>
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="color[]">Select Color</label>
      </div>
      <div class="col-md-6">   		
				<select name="color[]" class="form-control select2" multiple="multiple">
					<?php
						$is_selected = '';
						$statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);			
						foreach ($result as $row) {
							if (isset($color_id)) {
								if (in_array($row['color_id'], $color_id)) {
									$is_selected = 'selected';
								} else {
									$is_selected = '';
								}
							}
							?>
								<option value="<?php echo $row['color_id']; ?>" <?php echo $is_selected; ?>><?php echo $row['color_name']; ?></option>
							<?php
						}
					?>					
				</select>
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="">Existing Featured Photo</label>
      </div>
      <div class="col-md-6">   		
				<img src="../assets/uploads/<?php echo $p_featured_photo; ?>" alt="" style="width:150px;">
			</div>
		</div>
		<input type="hidden" name="current_photo" value="<?php echo $p_featured_photo; ?>">
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_featured_photo">Change Featured Photo</label>
      </div>
      <div class="col-md-6">   		
				<input type="file" name="p_featured_photo">
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="">Other Photos</label>
      </div>
      <div class="col-md-6">   		
				<input type="button" id="btnAddNew" value="Add Item" style="margin-bottom: 15px;" class="btn btn-warning btn-xs">
				<table id="ProductTable" style="width:100%;">
					<tbody>
						<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
							$statement->execute(array($_REQUEST['id']));
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
							?>
								<tr>
									<td>
										<img src="../assets/uploads/product_photos/<?php echo $row['photo']; ?>" alt="" style="width: 150px; margin-bottom: 5px;">
									</td>
									<td style="width: 28px;">
										<a onclick="return confirmDelete();" href="product-other-photo-delete.php?id=<?php echo $row['pp_id']; ?>&id1=<?php echo $_REQUEST['id']; ?>" class="btn btn-danger btn-xs">Delete Image</a>
									</td>
								</tr>
							<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_description">Description</label>
      </div>
      <div class="col-md-6">   		
				<textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"><?php echo $p_description; ?></textarea>
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_short_description">Short Description</label>
      </div>
      <div class="col-md-6">   		
				<textarea name="p_short_description" class="form-control" cols="30" rows="10" id="editor2"><?php echo $p_short_description; ?></textarea>
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_feature">Features</label>
      </div>
      <div class="col-md-6">   		
				<textarea name="p_feature" class="form-control" cols="30" rows="10" id="editor3"><?php echo $p_feature; ?></textarea>
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_condition">Conditions</label>
      </div>
      <div class="col-md-6">   		
				<textarea name="p_condition" class="form-control" cols="30" rows="10" id="editor4"><?php echo $p_condition; ?></textarea>
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_return_policy">Return Policy</label>
      </div>
      <div class="col-md-6">   		
				<textarea name="p_return_policy" class="form-control" cols="30" rows="10" id="editor5"><?php echo $p_return_policy; ?></textarea>
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_is_featured">Is Featured?</label>
      </div>
      <div class="col-md-6">   		
				<select name="p_is_featured" class="form-control" style="width:auto;">
					<option value="0" <?php if ($p_is_featured == '0') {echo 'selected';} ?>>No</option>
					<option value="1" <?php if ($p_is_featured == '1') {echo 'selected';} ?>>Yes</option>
				</select> 
			</div>
		</div>
    <div class="form-group row">
      <div class="col-md-3">
      	<label for="p_is_active">Is Active?</label>
      </div>
      <div class="col-md-6">   		
				<select name="p_is_active" class="form-control" style="width:auto;">
					<option value="0" <?php if ($p_is_active == '0') {echo 'selected';} ?>>No</option>
					<option value="1" <?php if ($p_is_active == '1') {echo 'selected';} ?>>Yes</option>
				</select> 
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
			success: function(html)	{
				$(".mid-cat").html(html);
			}
		});			
	});

	$(".mid-cat").on('change', function(){
		var id = $(this).val();
		var dataString = 'id='+ id;
		$.ajax({
			type: "POST",
			url: "get-end-category.php",
			data: dataString,
			cache: false,
			success: function(html) {
				$(".end-cat").html(html);
			}
		});			
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		// Initialize Select2 Elements
		$(".select2").select2();
	});		
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#btnAddNew").click(function() {
			var trNew = "";              
			var rowNumber = $("#ProductTable tbody tr").length;
			var addLink = "<div class=\"upload-btn" + rowNumber + "\"><input type=\"file\" name=\"photo[]\" style=\"margin-bottom: 5px;\"></div>";
			var deleteRow = "<a href=\"javascript:void()\" class=\"Delete btn btn-danger btn-xs\">X</a>";

			trNew += "<tr>";
				trNew += "<td>" + addLink + "</td>";
				trNew += "<td style=\"width: 28px;\">" + deleteRow + "</td>";
			trNew += " </tr>";

			/* 
			<tr>
				<td>
					<div class="upload-btn1">
						<input type="file" name="photo[]" style="margin-bottom:5px;">
					</div>
				</td>
				<td style="width:28px;">
					<a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a>
				</td>
			</tr> 
			*/			

			$("#ProductTable tbody").append(trNew);
		});		

		$('#ProductTable').delegate('a.Delete', 'click', function() {
			$(this).parent().parent().fadeOut('slow').remove();
			return false;
    });

    function confirmDelete() {
      return confirm("Are you sure want to delete this item?");
    }
	});
</script>

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
    CKEDITOR.replace('editor3');
    CKEDITOR.replace('editor4');
    CKEDITOR.replace('editor5');
  })
</script>
