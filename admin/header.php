<?php
  ob_start();
  session_start();
  include("inc/config.php");
  include("inc/functions.php");
  include("inc/CSRF_Protect.php");
  
  $csrf = new CSRF_Protect();
  $error_message = '';
  $success_message = '';
  $error_message1 = '';
  $success_message1 = '';

  if (!isset($_SESSION['user'])) {
  	header('location: login.php');
  	exit;
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- select2 - improved select box -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/select2/dist/css/select2.min.css">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">  
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
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>Ecom</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Ecommerce</b></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="../assets/uploads/<?php echo $_SESSION['user']['photo']; ?>" class="user-image" alt="User Image" width="20px;">
                <span class="hidden-xs"><?php echo $_SESSION['user']['full_name']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="profile-edit.php">Edit Profile <span class="glyphicon glyphicon-cog pull-right"></span></a></li>
                <li><a href="logout.php">Sign Out <span class="glyphicon glyphicon-log-out pull-right"></span></a></li>
              </ul>
            </li>
          </ul>
        </div>

      </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">      
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li>
            <a href="index.php">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>          
          </li>
          <li>
            <a href="settings.php">
              <i class="fa fa-gear"></i> <span>Settings</span>
            </a>          
          </li>
          <li>
            <a href="slider.php">
              <i class="fa fa-clone"></i> <span>Slider</span>
            </a>          
          </li>
          <li>
            <a href="service.php">
              <i class="fa fa-check-square-o"></i> <span>Service</span>
            </a>          
          </li>
          <li>
            <a href="testimonial.php">
              <i class="fa fa-users"></i> <span>Testimonial</span>
            </a>          
          </li>
          <li>
            <a href="faq.php">
              <i class="fa fa-question"></i> <span>FAQ</span>
            </a>          
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-camera"></i> <span>Gallery</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="photo.php"><i class="fa fa-photo"></i> Photo Gallery</a></li>
              <li><a href="video.php"><i class="fa fa-video-camera"></i> Video Gallery</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-newspaper-o"></i> <span>Blog Posts</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="category.php"><i class="fa fa-folder"></i> Category</a></li>
              <li><a href="post.php"><i class="fa fa-file"></i> Posts</a></li>
            </ul>
          </li> 
          <li class="treeview">
            <a href="#">
              <i class="fa fa-shopping-cart"></i> <span>Shop Section</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="size.php"><i class="fa fa-arrows"></i> Size</a></li>
              <li><a href="color.php"><i class="fa fa-pencil"></i> Color</a></li>
              <li><a href="country.php"><i class="fa fa-plane"></i> Country</a></li>
              <li><a href="shipping-cost.php"><i class="fa fa-money"></i> Shipping Cost</a></li>
              <li><a href="top-category.php"><i class="fa fa-tag"></i> Top Level Category</a></li>
              <li><a href="mid-category.php"><i class="fa fa-tag"></i> Mid Level Category</a></li>
              <li><a href="end-category.php"><i class="fa fa-tag"></i> End Level Category</a></li>
            </ul>
          </li>        
          <li>
            <a href="product.php">
              <i class="fa fa-dropbox"></i> <span>Products</span>
            </a>          
          </li>
          <li>
            <a href="order.php">
              <i class="fa fa-industry"></i> <span>Orders</span>
            </a>          
          </li>
          <li>
            <a href="rating.php">
              <i class="fa fa-star"></i> <span>Ratings</span>
            </a>          
          </li>         
          <li>
            <a href="language.php">
              <i class="fa fa-language"></i> <span>Language Settings</span>
            </a>          
          </li>             
          <li class="treeview">
            <a href="#">
              <i class="fa fa-inbox"></i> <span>Message</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="customer-message.php"><i class="fa fa-users"></i> Customer Message</a></li>
            </ul>
          </li>            
          <li>
            <a href="customer.php">
              <i class="fa fa-users"></i> <span>Customer</span>
            </a>          
          </li>
          <li>
            <a href="page.php">
              <i class="fa fa-sticky-note"></i> <span>Page Settings</span>
            </a>          
          </li>
          <li>
            <a href="social-media.php">
              <i class="fa fa-facebook"></i> <span>Social Media</span>
            </a>          
          </li>
          <li>
            <a href="advertisement.php">
              <i class="fa fa-newspaper-o"></i> <span>Advertisement</span>
            </a>          
          </li>
          <li>
            <a href="subscriber.php">
              <i class="fa fa-plus"></i> <span>Subscriber</span>
            </a>          
          </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">