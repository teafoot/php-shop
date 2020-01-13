<?php
ob_start();
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("admin/inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();

require 'assets/vendor/PHPMailer-6.0.2/PHPMailer.php';
require 'assets/vendor/PHPMailer-6.0.2/Exception.php';
$mail = new PHPMailer\PHPMailer\PHPMailer();

$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Getting all language variables into array as global variable
$i=1;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    define('LANG_VALUE_'.$i,$row['lang_value']);
    $i++;
}

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
    $logo = $row['logo'];
    $favicon = $row['favicon'];
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $meta_title_home = $row['meta_title_home'];
    $meta_keyword_home = $row['meta_keyword_home'];
    $meta_description_home = $row['meta_description_home'];
    $before_head = $row['before_head'];
    $after_body = $row['after_body'];
}

// Checking the order table and removing the pending transaction that are 24 hours+ old
$current_date_time = date('Y-m-d H:i:s');
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $ts1 = strtotime($row['payment_date']);
    $ts2 = strtotime($current_date_time);     
    $diff = $ts2 - $ts1;
    $time = $diff/(3600);
    if($time>24) {

        // Return back the stock amount
        $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement1->execute(array($row['payment_id']));
        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result1 as $row1) {
            $statement2 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
            $statement2->execute(array($row1['product_id']));
            $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);                         
            foreach ($result2 as $row2) {
                $p_qty = $row2['p_qty'];
            }
            $final = $p_qty+$row1['quantity'];

            $statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
            $statement->execute(array($final,$row1['product_id']));
        }
        
        // Deleting data from table
        $statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE payment_id=?");
        $statement1->execute(array($row['payment_id']));

        $statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE id=?");
        $statement1->execute(array($row['id']));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link href="<?= BASE_URL ?>/assets/vendor/eshopper/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/eshopper/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/eshopper/css/prettyPhoto.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/eshopper/css/price-range.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/eshopper/css/animate.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/eshopper/css/main.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/eshopper/css/responsive.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/owlcarousel/assets/owl.theme.default.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/bxslider/jquery.bxslider.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?= BASE_URL ?>/assets/vendor/eshopper/js/html5shiv.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/eshopper/js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="<?= BASE_URL ?>/assets/vendor/eshopper/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= BASE_URL ?>/assets/vendor/eshopper/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= BASE_URL ?>/assets/vendor/eshopper/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= BASE_URL ?>/assets/vendor/eshopper/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?= BASE_URL ?>/assets/vendor/eshopper/images/ico/apple-touch-icon-57-precomposed.png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">

    <?php

    $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) {
        $about_meta_title = $row['about_meta_title'];
        $about_meta_keyword = $row['about_meta_keyword'];
        $about_meta_description = $row['about_meta_description'];
        $faq_meta_title = $row['faq_meta_title'];
        $faq_meta_keyword = $row['faq_meta_keyword'];
        $faq_meta_description = $row['faq_meta_description'];
        $blog_meta_title = $row['blog_meta_title'];
        $blog_meta_keyword = $row['blog_meta_keyword'];
        $blog_meta_description = $row['blog_meta_description'];
        $contact_meta_title = $row['contact_meta_title'];
        $contact_meta_keyword = $row['contact_meta_keyword'];
        $contact_meta_description = $row['contact_meta_description'];
        $pgallery_meta_title = $row['pgallery_meta_title'];
        $pgallery_meta_keyword = $row['pgallery_meta_keyword'];
        $pgallery_meta_description = $row['pgallery_meta_description'];
        $vgallery_meta_title = $row['vgallery_meta_title'];
        $vgallery_meta_keyword = $row['vgallery_meta_keyword'];
        $vgallery_meta_description = $row['vgallery_meta_description'];
    }

    $cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    
    if($cur_page == 'index.php' || $cur_page == 'login.php' || $cur_page == 'registration.php' || $cur_page == 'cart.php' || $cur_page == 'checkout.php' || $cur_page == 'forget-password.php' || $cur_page == 'reset-password.php' || $cur_page == 'product-category.php' || $cur_page == 'product.php') {
        ?>
        <title><?php echo $meta_title_home; ?></title>
        <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
        <meta name="description" content="<?php echo $meta_description_home; ?>">
        <?php
    }

    if($cur_page == 'about.php') {
        ?>
        <title><?php echo $about_meta_title; ?></title>
        <meta name="keywords" content="<?php echo $about_meta_keyword; ?>">
        <meta name="description" content="<?php echo $about_meta_description; ?>">
        <?php
    }
    if($cur_page == 'faq.php') {
        ?>
        <title><?php echo $faq_meta_title; ?></title>
        <meta name="keywords" content="<?php echo $faq_meta_keyword; ?>">
        <meta name="description" content="<?php echo $faq_meta_description; ?>">
        <?php
    }
    if($cur_page == 'blog.php') {
        ?>
        <title><?php echo $blog_meta_title; ?></title>
        <meta name="keywords" content="<?php echo $blog_meta_keyword; ?>">
        <meta name="description" content="<?php echo $blog_meta_description; ?>">
        <?php
    }
    if($cur_page == 'contact.php') {
        ?>
        <title><?php echo $contact_meta_title; ?></title>
        <meta name="keywords" content="<?php echo $contact_meta_keyword; ?>">
        <meta name="description" content="<?php echo $contact_meta_description; ?>">
        <?php
    }
    if($cur_page == 'photo-gallery.php') {
        ?>
        <title><?php echo $pgallery_meta_title; ?></title>
        <meta name="keywords" content="<?php echo $pgallery_meta_keyword; ?>">
        <meta name="description" content="<?php echo $pgallery_meta_description; ?>">
        <?php
    }
    if($cur_page == 'video-gallery.php') {
        ?>
        <title><?php echo $vgallery_meta_title; ?></title>
        <meta name="keywords" content="<?php echo $vgallery_meta_keyword; ?>">
        <meta name="description" content="<?php echo $vgallery_meta_description; ?>">
        <?php
    }

    if($cur_page == 'blog-single.php')
    {
        $statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_slug=?");
        $statement->execute(array($_REQUEST['slug']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) 
        {
            $og_photo = $row['photo'];
            $og_title = $row['post_title'];
            $og_slug = $row['post_slug'];
            $og_description = substr(strip_tags($row['post_content']),0,200).'...';
            echo '<meta name="description" content="'.$row['meta_description'].'">';
            echo '<meta name="keywords" content="'.$row['meta_keyword'].'">';
            echo '<title>'.$row['meta_title'].'</title>';
        }
    }

    if($cur_page == 'product.php')
    {
        $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
        $statement->execute(array($_REQUEST['id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) 
        {
            $og_photo = $row['p_featured_photo'];
            $og_title = $row['p_name'];
            $og_slug = 'product.php?id='.$_REQUEST['id'];
            $og_description = substr(strip_tags($row['p_description']),0,200).'...';
        }
    }

    if($cur_page == 'dashboard.php') {
        ?>
        <title>Dashboard - <?php echo $meta_title_home; ?></title>
        <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
        <meta name="description" content="<?php echo $meta_description_home; ?>">
        <?php
    }
    if($cur_page == 'customer-profile-update.php') {
        ?>
        <title>Update Profile - <?php echo $meta_title_home; ?></title>
        <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
        <meta name="description" content="<?php echo $meta_description_home; ?>">
        <?php
    }
    if($cur_page == 'customer-billing-shipping-update.php') {
        ?>
        <title>Update Billing and Shipping Info - <?php echo $meta_title_home; ?></title>
        <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
        <meta name="description" content="<?php echo $meta_description_home; ?>">
        <?php
    }
    if($cur_page == 'customer-password-update.php') {
        ?>
        <title>Update Password - <?php echo $meta_title_home; ?></title>
        <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
        <meta name="description" content="<?php echo $meta_description_home; ?>">
        <?php
    }
    if($cur_page == 'customer-order.php') {
        ?>
        <title>Orders - <?php echo $meta_title_home; ?></title>
        <meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
        <meta name="description" content="<?php echo $meta_description_home; ?>">
        <?php
    }
    ?>
    
    <?php if($cur_page == 'blog-single.php'): ?>
        <meta property="og:title" content="<?php echo $og_title; ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo BASE_URL.$og_slug; ?>">
        <meta property="og:description" content="<?php echo $og_description; ?>">
        <meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
    <?php endif; ?>

    <?php if($cur_page == 'product.php'): ?>
        <meta property="og:title" content="<?php echo $og_title; ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo BASE_URL.$og_slug; ?>">
        <meta property="og:description" content="<?php echo $og_description; ?>">
        <meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
    <?php endif; ?>   

<?php echo $before_head; ?>    
</head>

<body>

<?php echo $after_body; ?>

    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><i class="fa fa-phone"></i><?php echo $contact_phone; ?></li>
                                <li><i class="fa fa-envelope"></i><?php echo $contact_email; ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <?php
                                    $statement = $pdo->prepare("SELECT * FROM tbl_social");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        ?>
                                        <?php if($row['social_url'] != ''): ?>
                                            <li><a href="<?php echo $row['social_url']; ?>"><i class="<?php echo $row['social_icon']; ?>"></i></a></li>
                                        <?php endif; ?>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->
        
        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-md-4 clearfix">
                        <div class="logo pull-left">
                            <a href="index.html"><img src="assets/uploads/<?php echo $logo; ?>" alt="" /></a>
                        </div>
                    </div>
                    <div class="col-md-8 clearfix">
                        <div class="shop-menu clearfix pull-right">
                            <ul class="nav navbar-nav">
                                <?php
                                    if(isset($_SESSION['customer'])) {
                                        ?>
                                        <li><i class="fa fa-user"></i> <?php echo LANG_VALUE_13; ?> <?php echo $_SESSION['customer']['cust_name']; ?></li>
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> <?php echo LANG_VALUE_89; ?></a></li>
                                        <?php
                                    } else {
                                        ?>
                                        <li><a href="login.php"><i class="fa fa-sign-in"></i> <?php echo LANG_VALUE_9; ?></a></li>
                                        <li><a href="registration.php"><i class="fa fa-user-plus"></i> <?php echo LANG_VALUE_15; ?></a></li>
                                        <?php   
                                    }
                                ?>
                                <li>
                                    <a href="cart.php">
                                        <i class="fa fa-shopping-cart"></i> <?php echo LANG_VALUE_19; ?> (<?php echo LANG_VALUE_1; ?><?php
                                                if(isset($_SESSION['cart_p_id'])) {
                                                    $table_total_price = 0;
                                                    $i = 0;
                                                    foreach($_SESSION['cart_p_qty'] as $key => $value) 
                                                    {
                                                        $i++;
                                                        $arr_cart_p_qty[$i] = $value;
                                                    }                    
                                                    $i = 0;
                                                    foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                                                    {
                                                        $i++;
                                                        $arr_cart_p_current_price[$i] = $value;
                                                    }
                                                    for($i = 1; $i <= count($arr_cart_p_qty); $i++) {
                                                        $row_total_price = $arr_cart_p_current_price[$i]*$arr_cart_p_qty[$i];
                                                        $table_total_price = $table_total_price + $row_total_price;
                                                    }
                                                    echo $table_total_price;
                                                } else {
                                                    echo '0.00';
                                                }
                                            ?>)
                                    </a>
                                </li>
                            </ul>
                            <div class="search_box">
                                <form class="navbar-form navbar-left" role="search" action="search-result.php" method="get">
                                    <?php $csrf->echoInputField(); ?>
                                    <input type="text" class="form-control search-top" placeholder="<?php echo LANG_VALUE_2; ?>" name="search_text">
                                    <button type="submit" class="btn btn-default"><?php echo LANG_VALUE_3; ?></button>
                                </form>
                            </div>
                        </div>
                        <!-- <div class="col-sm-3"> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->
    
        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="index.php">Home</a></li>
                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    ?>
                                    <li class="dropdown">
                                        <a href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category"><?php echo $row['tcat_name']; ?><i class="fa fa-angle-down"></i></a>
                                        <ul role="menu" class="sub-menu">
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
                                            $statement1->execute(array($row['tcat_id']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                ?>
                                                <li>
                                                    <a href="product-category.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category"><?php echo $row1['mcat_name']; ?><i class="fa fa-angle-down"></i></a>
                                                    <ul>
                                                        <?php
                                                        $statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
                                                        $statement2->execute(array($row1['mcat_id']));
                                                        $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                                        foreach ($result2 as $row2) {
                                                            ?>
                                                            <li><a href="product-category.php?id=<?php echo $row2['ecat_id']; ?>&type=end-category"><?php echo $row2['ecat_name']; ?></a></li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <?php
                                }
                                ?>

                                <?php
                                $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);       
                                foreach ($result as $row) {
                                    $about_title = $row['about_title'];
                                    $faq_title = $row['faq_title'];
                                    $blog_title = $row['blog_title'];
                                    $contact_title = $row['contact_title'];
                                    $pgallery_title = $row['pgallery_title'];
                                    $vgallery_title = $row['vgallery_title'];
                                }
                                ?>
                                <li class="dropdown">
                                    <a href="#">Gallery<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu"l>
                                        <li><a href="photo-gallery.php"><?php echo $pgallery_title; ?></a></li>
                                        <li><a href="video-gallery.php"><?php echo $vgallery_title; ?></a></li>
                                    </ul>
                                </li>
                                <li><a href="about.php"><?php echo $about_title; ?></a></li>
                                <li><a href="faq.php"><?php echo $faq_title; ?></a></li>
                                <li><a href="blog.php"><?php echo $blog_title; ?></a></li>
                                <li><a href="contact.php"><?php echo $contact_title; ?></a></li>
                            </ul>
                        </div>
                    </div>                    
                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->