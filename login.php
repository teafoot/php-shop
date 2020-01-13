<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_login = $row['banner_login'];
}
?>

<?php
if(isset($_POST['form1'])) {
        
    if(empty($_POST['cust_email']) || empty($_POST['cust_password'])) {
        $error_message = LANG_VALUE_132.'<br>';
    } else {
        
        $cust_email = strip_tags($_POST['cust_email']);
        $cust_password = strip_tags($_POST['cust_password']);

        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
        $statement->execute(array($cust_email));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $cust_status = $row['cust_status'];
            $row_password = $row['cust_password'];
        }

        if($total==0) {
            $error_message .= LANG_VALUE_133.'<br>';
        } else {

            if( $row_password != md5($cust_password) ) {
                $error_message .= LANG_VALUE_139.'<br>';
            } else {
                if($cust_status == 0) {
                    $error_message .= LANG_VALUE_148.'<br>';
                } else {
                    $_SESSION['customer'] = $row;
                    header("location: ".BASE_URL."dashboard.php");
                }
            }
            
        }
    }
}
?>

<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/banner_login.jpg);">
    <h1><?php echo LANG_VALUE_10; ?></h1>
</div>

<div class="container">
    <div class="row">
		<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-body">
			  		<?php 
							if ((isset($error_message)) && ($error_message != '')) {
								echo '<div class="error">' . $error_message . '</div>';
							}
						?>
						<?php 
							if($success_message != '') {
				        echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
				      }
				    ?>
				  	<form action="" method="post">
				    	<?php $csrf->echoInputField(); ?>
				      <div class="input-group has-feedback">
					      <div class="input-group-addon"><i class="glyphicon glyphicon-envelope form-control-feedback"></i></div>
					      <input type="email" class="form-control" name="cust_email" placeholder="<?php echo LANG_VALUE_94; ?> *">
					    </div>
				      <div class="input-group has-feedback">
				      	<div class="input-group-addon"><i class="glyphicon glyphicon-lock form-control-feedback"></i></div>
				        <input type="password" class="form-control" name="cust_password" placeholder="<?php echo LANG_VALUE_96; ?> *">				        
				      </div>
				      <div class="row">
				        <div class="col-xs-12">
									<input type="submit" class="btn btn-primary btn-block btn-flat login-button" name="form1" value="<?php echo LANG_VALUE_4; ?>">
				        </div>
				      </div>
				    </form>
				    <a href="forget-password.php" style="color:#e4144d;"><?php echo LANG_VALUE_97; ?></a>
			    </div>
			</div>
		</div>
	</div>
</div>

<?php require_once('footer.php'); ?>