<?php
  ob_start();
  session_start();
  include("inc/config.php");
  include("inc/functions.php");
  include("inc/CSRF_Protect.php");

  $csrf = new CSRF_Protect();
  $error_message = '';

  if (isset($_POST['form1'])) {
  	if (empty($_POST['email']) || empty($_POST['password'])) {
  		$error_message = 'Email and/or Password can not be empty<br>';
  	} else {
  		$email = strip_tags($_POST['email']);
  		$password = strip_tags($_POST['password']);

  		$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE email=? AND status=?");
  		$statement->execute(array($email, 'Active'));
  		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
  		$total = $statement->rowCount();    

  		if ($total == 0) {
  			$error_message .= 'Email Address does not match<br>';
  		} else {       
  			foreach ($result as $row) { 
  				$row_password = $row['password'];
  			}

  			if ($row_password != md5($password)) {
  				$error_message .= 'Password does not match<br>';
  			} else {       
  				$_SESSION['user'] = $row;
  				header("location: index.php");
  			}
  		}
  	}    
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/plugins/iCheck/square/blue.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/admin/assets/style.css">
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <b>Admin Panel</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
		<?php if((isset($error_message)) && ($error_message != '')) : ?>
			<div class="error"><?= $error_message ?></div>
		<?php endif; ?>
    <form action="" method="post">
    	<?php $csrf->echoInputField(); ?>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" autocomplete="off" autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" value="">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
					<input type="submit" class="btn btn-primary btn-block btn-flat login-button" name="form1" value="Sign In">
        </div>
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
