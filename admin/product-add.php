<?php require_once('header.php'); ?>

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
	  } else {
	  	$valid = 0;
      $error_message .= 'You must have to select a featured photo<br>';
	  }

	  if ($valid == 1) {
	  	$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach($result as $row) {
				$auto_increment_id_tbl_product = $row[10];
			}

			$final_product_featured_photo = 'product-featured-' . $auto_increment_id_tbl_product . '.' . $p_featured_photo_ext;
	    move_uploaded_file($p_featured_photo_path_tmp, '../assets/uploads/' . $final_product_featured_photo);

	    //Saving data into the main table tbl_product
			$statement = $pdo->prepare("INSERT INTO tbl_product(p_name, p_old_price, p_current_price, p_qty, p_featured_photo, p_description, p_short_description, p_feature, p_condition, p_return_policy, p_total_view, p_is_featured, p_is_active, ecat_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$statement->execute(array($_POST['p_name'], $_POST['p_old_price'], $_POST['p_current_price'], $_POST['p_qty'], $final_product_featured_photo, $_POST['p_description'], $_POST['p_short_description'], $_POST['p_feature'], $_POST['p_condition'], $_POST['p_return_policy'], 0, $_POST['p_is_featured'], $_POST['p_is_active'], $_POST['ecat_id']));

		  if (isset($_FILES['photo']['name']) && isset($_FILES['photo']['tmp_name'])) {
	    	$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
				$statement->execute();
				$result = $statement->fetchAll();
				foreach($result as $row) {
					$auto_increment_id_tbl_product_photo = $row[10];
				}

	    	$photos = array();
	      $photos = $_FILES['photo']['name'];
	      $photos = array_values(array_filter($photos));

	    	$photos_temp = array();
	      $photos_temp = $_FILES['photo']['tmp_name'];
	      $photos_temp = array_values(array_filter($photos_temp));

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
		      	$statement->execute(array($final_product_photos[$i], $auto_increment_id_tbl_product));
		      }
	      }            
		  }

	    if (isset($_POST['size'])) {
				foreach($_POST['size'] as $size) {
					$statement = $pdo->prepare("INSERT INTO tbl_product_size (size_id, p_id) VALUES (?, ?)");
					$statement->execute(array($size, $auto_increment_id_tbl_product));
				}
			}

			if (isset($_POST['color'])) {
				foreach ($_POST['color'] as $color) {
					$statement = $pdo->prepare("INSERT INTO tbl_product_color (color_id, p_id) VALUES (?, ?)");
					$statement->execute(array($color, $auto_increment_id_tbl_product));
				}
			}
			
	  	$success_message = 'Product is added successfully.';
	  }
	}
?>

<div class="container">
	<h3>Add Product</h3>
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
							<option value="<?php echo $row['tcat_id']; ?>"><?php echo $row['tcat_name']; ?></option>
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
				</select>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_name">Product Name *</label>
			</div>
			<div class="col-md-6">				
				<input type="text" name="p_name" class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_old_price">Old Price (In USD)</label>
			</div>
			<div class="col-md-6">				
				<input type="text" name="p_old_price" class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_current_price">Current Price * (In USD)</label>
			</div>
			<div class="col-md-6">				
				<input type="text" name="p_current_price" class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_qty">Quantity *</label>
			</div>
			<div class="col-md-6">				
				<input type="text" name="p_qty" class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="size[]">Select Size</label>
			</div>
			<div class="col-md-6">				
				<select name="size[]" class="form-control select2" multiple="multiple">
					<?php
						$statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size_id ASC");
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);			
						foreach ($result as $row) {
							?>
							<option value="<?php echo $row['size_id']; ?>"><?php echo $row['size_name']; ?></option>
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
						$statement = $pdo->prepare("SELECT * FROM tbl_color ORDER BY color_id ASC");
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);			
						foreach ($result as $row) {
							?>
							<option value="<?php echo $row['color_id']; ?>"><?php echo $row['color_name']; ?></option>
							<?php
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_featured_photo">Featured Photo *</label>
			</div>
			<div class="col-md-6">				
				<input type="file" name="p_featured_photo">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="photo[]">Other Photos</label>
			</div>
			<div class="col-md-6">				
				<input type="button" id="btnAddNew" value="Add Item" style="margin-bottom: 15px;" class="btn btn-warning btn-xs">
				<table id="ProductTable" style="width: 100%;">
					<tbody>
						<tr>
							<td>
								<div class="upload-btn">
									<input type="file" name="photo[]" style="margin-bottom:5px;">
								</div>
							</td>
							<td style="width: 28px;">
								<a href="javascript:void()" class="Delete btn btn-danger btn-xs">X</a>
							</td>							
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_description">Description</label>
			</div>
			<div class="col-md-6">				
				<textarea name="p_description" class="form-control" cols="30" rows="10" id="editor1"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_short_description">Short Description</label>
			</div>
			<div class="col-md-6">				
				<textarea name="p_short_description" class="form-control" cols="30" rows="10" id="editor2"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_feature">Features</label>
			</div>
			<div class="col-md-6">				
				<textarea name="p_feature" class="form-control" cols="30" rows="10" id="editor3"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_condition">Conditions</label>
			</div>
			<div class="col-md-6">				
				<textarea name="p_condition" class="form-control" cols="30" rows="10" id="editor4"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_return_policy">Return Policy</label>
			</div>
			<div class="col-md-6">				
				<textarea name="p_return_policy" class="form-control" cols="30" rows="10" id="editor5"></textarea>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_is_featured">Is Featured?</label>
			</div>
			<div class="col-md-6">				
				<select name="p_is_featured" class="form-control" style="width:auto;">
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select> 
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-3">
				<label for="p_is_active">Is Active?</label>
			</div>
			<div class="col-md-6">		
				<select name="p_is_active" class="form-control" style="width:auto;">
					<option value="0">No</option>
					<option value="1">Yes</option>
				</select> 
			</div>
		</div>
		<div class="form-group row">											
			<div class="col-md-offset-3 col-md-6">					
				<button type="submit" class="btn btn-success" name="form1">Submit</button>
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

	$(".mid-cat").on('change',function() {
		var id = $(this).val();
		var dataString = 'id='+ id;
		$.ajax({
			type: "POST",
			url: "get-end-category.php",
			data: dataString,
			cache: false,
			success: function(html)	{
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
			trNew += "</tr>";

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
