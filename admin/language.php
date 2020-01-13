<?php require_once('header.php'); ?>

<?php
    if (isset($_POST['form1'])) {
        // updating into the database
    	foreach ($_POST['lang_value'] as $key => $value) {
    		$lang_values[$key] = $value;
    	}

    	for ($i = 1; $i <= count($lang_values); $i++) {
    		$statement = $pdo->prepare("UPDATE tbl_language SET lang_value=? WHERE lang_id=?");
    		$statement->execute(array($lang_values[$i], $i));
    	}

    	$success_message = 'Language Settings is updated successfully.';
    }

    $i = 0;
    $statement = $pdo->prepare("SELECT * FROM tbl_language");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    foreach ($result as $row) {
    	$i++;
    	$lang_values[$i] = $row['lang_value'];
    }
?>

<div class="container">
  <h3>Setup Language</h3>
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
    <form class="form-horizontal" action="" method="post">
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Basic</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Currency *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[1]" value="<?php echo $lang_values[1]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Search Product *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[2]" value="<?php echo $lang_values[2]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Search *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[3]" value="<?php echo $lang_values[3]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Submit *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[4]" value="<?php echo $lang_values[4]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Update *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[5]" value="<?php echo $lang_values[5]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Read More *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[6]" value="<?php echo $lang_values[6]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Serial *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[7]" value="<?php echo $lang_values[7]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Photo *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[8]" value="<?php echo $lang_values[8]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Login</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Login *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[9]" value="<?php echo $lang_values[9]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Customer Login *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[10]" value="<?php echo $lang_values[10]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Click here to login *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[11]" value="<?php echo $lang_values[11]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Back to Login Page *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[12]" value="<?php echo $lang_values[12]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Logged in as *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[13]" value="<?php echo $lang_values[13]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Logout *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[14]" value="<?php echo $lang_values[14]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Registration</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Register *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[15]" value="<?php echo $lang_values[15]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Customer Registration *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[16]" value="<?php echo $lang_values[16]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Registration Successful *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[17]" value="<?php echo $lang_values[17]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Cart and Checkout</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Cart *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[18]" value="<?php echo $lang_values[18]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">View Cart *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[19]" value="<?php echo $lang_values[19]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Update Cart *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[20]" value="<?php echo $lang_values[20]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Add to Cart *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[154]" value="<?php echo $lang_values[154]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Back to Cart *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[21]" value="<?php echo $lang_values[21]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Checkout *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[22]" value="<?php echo $lang_values[22]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Proceed to Checkout *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[23]" value="<?php echo $lang_values[23]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Please login as customer to checkout *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[160]" value="<?php echo $lang_values[160]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Payment</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Orders *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[24]" value="<?php echo $lang_values[24]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Order History *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[25]" value="<?php echo $lang_values[25]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Order Details *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[26]" value="<?php echo $lang_values[26]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Payment Date and Time *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[27]" value="<?php echo $lang_values[27]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Transaction ID *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[28]" value="<?php echo $lang_values[28]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Paid Amount *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[29]" value="<?php echo $lang_values[29]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Payment Status *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[30]" value="<?php echo $lang_values[30]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Payment Method *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[31]" value="<?php echo $lang_values[31]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Payment ID *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[32]" value="<?php echo $lang_values[32]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Payment Section *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[33]" value="<?php echo $lang_values[33]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Select Payment Method *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[34]" value="<?php echo $lang_values[34]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Select a Method *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[35]" value="<?php echo $lang_values[35]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">PayPal *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[36]" value="<?php echo $lang_values[36]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Stripe *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[37]" value="<?php echo $lang_values[37]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Bank Deposit *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[38]" value="<?php echo $lang_values[38]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Card Number *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[39]" value="<?php echo $lang_values[39]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">CVV *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[40]" value="<?php echo $lang_values[40]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Month *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[41]" value="<?php echo $lang_values[41]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Year *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[42]" value="<?php echo $lang_values[42]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Send to this Details *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[43]" value="<?php echo $lang_values[43]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Transaction Information *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[44]" value="<?php echo $lang_values[44]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Include transaction id and other information correctly *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[45]" value="<?php echo $lang_values[45]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Pay Now *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[46]" value="<?php echo $lang_values[46]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Product</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Product Name *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[47]" value="<?php echo $lang_values[47]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Product Details *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[48]" value="<?php echo $lang_values[48]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Related Products *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[155]" value="<?php echo $lang_values[155]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">See all the related products from below *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[156]" value="<?php echo $lang_values[156]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Categories *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[49]" value="<?php echo $lang_values[49]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Category: *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[50]" value="<?php echo $lang_values[50]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">All Products Under *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[51]" value="<?php echo $lang_values[51]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Select Size *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[52]" value="<?php echo $lang_values[52]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Size *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[157]" value="<?php echo $lang_values[157]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Select Color *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[53]" value="<?php echo $lang_values[53]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Color *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[158]" value="<?php echo $lang_values[158]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Price *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[159]" value="<?php echo $lang_values[159]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Product Price *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[54]" value="<?php echo $lang_values[54]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Quantity *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[55]" value="<?php echo $lang_values[55]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Out of Stock *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[56]" value="<?php echo $lang_values[56]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Share This *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[57]" value="<?php echo $lang_values[57]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Share This Product *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[58]" value="<?php echo $lang_values[58]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Product Description *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[59]" value="<?php echo $lang_values[59]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">No Product Found *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[153]" value="<?php echo $lang_values[153]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Features *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[60]" value="<?php echo $lang_values[60]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Conditions *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[61]" value="<?php echo $lang_values[61]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Return Policy *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[62]" value="<?php echo $lang_values[62]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Reviews *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[63]" value="<?php echo $lang_values[63]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Review *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[64]" value="<?php echo $lang_values[64]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Give a Review *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[65]" value="<?php echo $lang_values[65]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Write your comment (Optional) *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[66]" value="<?php echo $lang_values[66]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Submit Review *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[67]" value="<?php echo $lang_values[67]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">You already have given a rating! *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[68]" value="<?php echo $lang_values[68]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Rating is submitted successfully! *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[163]" value="<?php echo $lang_values[163]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">You must have to login to give a review *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[69]" value="<?php echo $lang_values[69]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">No description found *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[70]" value="<?php echo $lang_values[70]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">No feature found *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[71]" value="<?php echo $lang_values[71]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">No condition found *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[72]" value="<?php echo $lang_values[72]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">No return policy found *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[73]" value="<?php echo $lang_values[73]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">No Review is Found *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[74]" value="<?php echo $lang_values[74]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Customer Name *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[75]" value="<?php echo $lang_values[75]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Comment *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[76]" value="<?php echo $lang_values[76]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Comments *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[77]" value="<?php echo $lang_values[77]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Rating *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[78]" value="<?php echo $lang_values[78]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Previous *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[79]" value="<?php echo $lang_values[79]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Next *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[80]" value="<?php echo $lang_values[80]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Sub Total *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[81]" value="<?php echo $lang_values[81]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Total *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[82]" value="<?php echo $lang_values[82]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Action *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[83]" value="<?php echo $lang_values[83]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Billing and Shipping</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Shipping Cost *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[84]" value="<?php echo $lang_values[84]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Continue Shipping *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[85]" value="<?php echo $lang_values[85]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Billing Address *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[161]" value="<?php echo $lang_values[161]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Update Billing Address *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[86]" value="<?php echo $lang_values[86]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Shipping Address *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[162]" value="<?php echo $lang_values[162]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Update Shipping Address *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[87]" value="<?php echo $lang_values[87]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Update Billing and Shipping Info *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[88]" value="<?php echo $lang_values[88]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Dashboard</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Dashboard *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[89]" value="<?php echo $lang_values[89]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Welcome to the Dashboard *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[90]" value="<?php echo $lang_values[90]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Back to Dashboard *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[91]" value="<?php echo $lang_values[91]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Subscribe</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Subscribe *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[92]" value="<?php echo $lang_values[92]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Subscribe To Our Newsletter *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[93]" value="<?php echo $lang_values[93]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Email Address</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Email Address *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[94]" value="<?php echo $lang_values[94]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Enter Your Email Address *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[95]" value="<?php echo $lang_values[95]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Password</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Password *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[96]" value="<?php echo $lang_values[96]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Forget Password *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[97]" value="<?php echo $lang_values[97]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Retype Password *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[98]" value="<?php echo $lang_values[98]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Update Password *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[99]" value="<?php echo $lang_values[99]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">New Password *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[100]" value="<?php echo $lang_values[100]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Retype New Password *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[101]" value="<?php echo $lang_values[101]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Change Password *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[149]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[149]; ?></textarea>
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Customer</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Full Name *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[102]" value="<?php echo $lang_values[102]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Company Name *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[103]" value="<?php echo $lang_values[103]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Phone Number *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[104]" value="<?php echo $lang_values[104]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Address *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[105]" value="<?php echo $lang_values[105]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Country *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[106]" value="<?php echo $lang_values[106]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">City *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[107]" value="<?php echo $lang_values[107]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">State *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[108]" value="<?php echo $lang_values[108]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Zip Code *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[109]" value="<?php echo $lang_values[109]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Other Information</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">About Us *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[110]" value="<?php echo $lang_values[110]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Featured Posts *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[111]" value="<?php echo $lang_values[111]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Popular Posts *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[112]" value="<?php echo $lang_values[112]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Recent Posts *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[113]" value="<?php echo $lang_values[113]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Contact Information *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[114]" value="<?php echo $lang_values[114]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Contact Form *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[115]" value="<?php echo $lang_values[115]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Our Office *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[116]" value="<?php echo $lang_values[116]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Update Profile *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[117]" value="<?php echo $lang_values[117]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Send Message *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[118]" value="<?php echo $lang_values[118]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Message *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[119]" value="<?php echo $lang_values[119]; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Find Us On Map *</label>
            </div>
            <div class="col-md-6">        
                <input type="text" class="form-control" name="lang_value[120]" value="<?php echo $lang_values[120]; ?>">
            </div>
        </div>
        <h3 class="my-underline" style="font-size:20px; font-weight:500;">Error Messages</h3><hr>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Congratulation! Payment is successful. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[121]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[121]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Billing and Shipping Information is updated successfully. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[122]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[122]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Customer Name can not be empty. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[123]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[123]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Phone Number can not be empty. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[124]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[124]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Address can not be empty. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[125]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[125]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">You must have to select a country. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[126]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[126]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">City can not be empty. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[127]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[127]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">State can not be empty. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[128]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[128]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Zip Code can not be empty. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[129]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[129]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Profile Information is updated successfully. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[130]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[130]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Email Address can not be empty *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[131]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[131]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Email and/or Password can not be empty. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[132]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[132]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Email Address does not match. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[133]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[133]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Email address must be valid. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[134]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[134]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Email Address Already Exists. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[147]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[147]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">You email address is not found in our system. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[135]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[135]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Please check your email and confirm your subscription. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[136]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[136]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Your email is verified successfully. You can now login to our website. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[137]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[137]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Password can not be empty. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[138]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[138]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Passwords do not match. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[139]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[139]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Please enter new and retype passwords. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[140]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[140]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Password is updated successfully. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[141]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[141]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">To reset your password, please click on the link below. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[142]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[142]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">PASSWORD RESET REQUEST - YOUR WEBSITE.COM *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[143]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[143]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">The password reset email time (24 hours) has expired. Please again try to reset your password. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[144]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[144]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">A confirmation link is sent to your email address. You will get the password reset information in there. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[145]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[145]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Password is reset successfully. You can now login. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[146]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[146]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Sorry! Your account is inactive. Please contact to the administrator. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[148]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[148]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Registration Email Confirmation for YOUR WEBSITE. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[150]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[150]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Thank you for your registration! Your account has been created. To active your account click on the link below: *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[151]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[151]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3">
                <label for="">Your registration is completed. Please check your email address to follow the process to confirm your registration. *</label>
            </div>
            <div class="col-md-6">        
                <textarea name="lang_value[152]" class="form-control" cols="30" rows="10" style="height:70px;"><?php echo $lang_values[152]; ?></textarea>
            </div>
        </div>
        <div class="form-group row">                                            
            <div class="col-md-offset-3 col-md-6">                        
                <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
            </div>
        </div>
    </form>
</div>

<?php require_once('footer.php'); ?>