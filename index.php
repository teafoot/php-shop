<?php require_once('header.php'); ?>

<?php
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row)
    {
        $cta_title = $row['cta_title'];
        $cta_content = $row['cta_content'];
        $cta_read_more_text = $row['cta_read_more_text'];
        $cta_read_more_url = $row['cta_read_more_url'];
        $cta_photo = $row['cta_photo'];
        $featured_product_title = $row['featured_product_title'];
        $featured_product_subtitle = $row['featured_product_subtitle'];
        $latest_product_title = $row['latest_product_title'];
        $latest_product_subtitle = $row['latest_product_subtitle'];
        $popular_product_title = $row['popular_product_title'];
        $popular_product_subtitle = $row['popular_product_subtitle'];
        $testimonial_title = $row['testimonial_title'];
        $testimonial_subtitle = $row['testimonial_subtitle'];
        $testimonial_photo = $row['testimonial_photo'];
        $blog_title = $row['blog_title'];
        $blog_subtitle = $row['blog_subtitle'];
        $total_featured_product_home = $row['total_featured_product_home'];
        $total_latest_product_home = $row['total_latest_product_home'];
        $total_popular_product_home = $row['total_popular_product_home'];
        $home_service_on_off = $row['home_service_on_off'];
        $home_welcome_on_off = $row['home_welcome_on_off'];
        $home_featured_product_on_off = $row['home_featured_product_on_off'];
        $home_latest_product_on_off = $row['home_latest_product_on_off'];
        $home_popular_product_on_off = $row['home_popular_product_on_off'];
        $home_testimonial_on_off = $row['home_testimonial_on_off'];
        $home_blog_on_off = $row['home_blog_on_off'];

        $ads_above_welcome_on_off           = $row['ads_above_welcome_on_off'];
        $ads_above_featured_product_on_off  = $row['ads_above_featured_product_on_off'];
        $ads_above_latest_product_on_off    = $row['ads_above_latest_product_on_off'];
        $ads_above_popular_product_on_off   = $row['ads_above_popular_product_on_off'];
        $ads_above_testimonial_on_off       = $row['ads_above_testimonial_on_off'];
        $ads_category_sidebar_on_off        = $row['ads_category_sidebar_on_off'];
    }

    $statement = $pdo->prepare("SELECT * FROM tbl_advertisement");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
    foreach ($result as $row) {
        $adv_type[] = $row['adv_type'];
        $adv_photo[] = $row['adv_photo'];
        $adv_url[] = $row['adv_url'];
        $adv_adsense_code[] = $row['adv_adsense_code'];
    }
?>

<!-- THE SLIDER (DONE) -->
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php
                            $i=0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_slider");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                            foreach ($result as $row) {            
                                ?>
                                <li data-target="#slider-carousel" data-slide-to="<?php echo $i; ?>" <?php if ($i == 0) {echo 'class="active"';} ?>></li>
                                <?php
                                $i++;
                            }
                        ?>
                    </ol>
                    
                    <div class="carousel-inner">
                        <?php
                            $i=0;
                            $statement = $pdo->prepare("SELECT * FROM tbl_slider");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                            foreach ($result as $row) {            
                                ?>
                                <div class="item <?php if ($i == 0) {echo 'active';} ?>" style="min-height: 450px; background-image:url(assets/uploads/<?php echo $row['photo']; ?>);">
                                    <div class="col-sm-12" style="color: #fff !important;">
                                        <h1><?php echo $row['heading']; ?></h1>
                                        <p><?php echo nl2br($row['content']); ?></p>
                                        <button type="button" class="btn btn-default get"><?php echo $row['button_text']; ?></button>
                                    </div>
                                </div>
                                <?php
                                $i++;
                            }
                        ?>
                    </div>
                    
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</section><!--/slider-->

<!-- SERVICES (DONE) -->
<?php if ($home_service_on_off == 1): ?>
<section class="services-area pt-100 pb-70" id="services">
    <div class="container">
        <div class="row">
            <?php
                $statement = $pdo->prepare("SELECT * FROM tbl_service");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                foreach ($result as $row) {
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-service">
                            <img src="assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['title']; ?>">
                            <h4><?php echo $row['title']; ?></h4>
                            <p><?php echo nl2br($row['content']); ?></p>
                        </div>
                    </div>
                    <?php
                }
            ?>         
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ADS PHOTO (DONE) -->
<?php if ($ads_above_welcome_on_off == 1): ?>
<div class="ad-section pt_20 pb_20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if ($adv_type[0] == 'Adsense Code') {
                        echo $adv_adsense_code[0];
                    } else {
                        if($adv_url[0]=='') {
                            echo '<img src="assets/uploads/'.$adv_photo[0].'" alt="Advertisement">';
                        } else {
                            echo '<a href="'.$adv_url[0].'"><img src="assets/uploads/'.$adv_photo[0].'" alt="Advertisement"></a>';
                        }                               
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- WELCOME (DONE) -->
<?php if ($home_welcome_on_off == 1): ?>
<div class="welcome" style="background-image: url('assets/uploads/<?php echo $cta_photo; ?>');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo $cta_title; ?></h2>
                <p>
                    <?php echo nl2br($cta_content); ?>
                </p>
                <p class="button"><a href="<?php echo $cta_read_more_url; ?>"><?php echo $cta_read_more_text; ?></a></p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ADS PHOTO (DONE) -->
<?php if($ads_above_featured_product_on_off == 1): ?>
<div class="ad-section pt_20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if($adv_type[1] == 'Adsense Code') {
                        echo $adv_adsense_code[1];
                    } else {
                        if($adv_url[1]=='') {
                            echo '<img src="assets/uploads/'.$adv_photo[1].'" alt="Advertisement">';
                        } else {
                            echo '<a href="'.$adv_url[1].'"><img src="assets/uploads/'.$adv_photo[1].'" alt="Advertisement"></a>';
                        }                               
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- FEATURED PRODUCTS CAROUSEL (DONE) -->
<?php if($home_featured_product_on_off == 1): ?>
<div class="recommended_items">
    <h2 class="title text-center"><?php echo $featured_product_title; ?></h2>
    <h3 class="title text-center"><?php echo $featured_product_subtitle; ?></h3>
    
    <div id="recommended-item-carousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
                $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_featured=? AND p_is_active=? LIMIT ".$total_featured_product_home);
                $statement->execute(array(1,1));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);     

                // 1 Slider has 3 slides
                $count = count($result);
                $sliders = $count / 3;
                if ($count % 3 != 0) {
                    $sliders++;
                }
                $sliders = floor($sliders);
                $slide = 1;

                for ($slider = 1; $slider <= $sliders; $slider++) {
            ?>
                    <div class="item <?php if ($slider == 1) {echo 'active';} ?>">
            <?php
                    while ($slide <= 3 * $slider) {
                        if (!isset($result[$slide - 1])) {
                            break;
                        } else {
                            $row = $result[$slide - 1];
                        }
            ?>
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="<?= BASE_URL ?>/assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="" />
                                        <h2>
                                            $<?php echo $row['p_current_price']; ?> 
                                            <?php if ($row['p_old_price'] != ''): ?>
                                                <del>$<?php echo $row['p_old_price']; ?></del>
                                            <?php endif; ?>
                                        </h2>
                                        <p><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></p>
                                        <div class="rating">
                                            <?php
                                                $t_rating = 0;
                                                $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                                $statement1->execute(array($row['p_id']));
                                                $tot_rating = $statement1->rowCount();

                                                if ($tot_rating == 0) {
                                                    $avg_rating = 0;
                                                } else {
                                                    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result1 as $row1) {
                                                        $t_rating = $t_rating + $row1['rating'];
                                                    }
                                                    $avg_rating = $t_rating / $tot_rating;
                                                }
                                            ?>
                                            <?php
                                                if ($avg_rating == 0) {
                                                    echo '';
                                                } else if ($avg_rating == 1.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                } else if ($avg_rating == 2.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                } else if ($avg_rating == 3.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                } else if ($avg_rating == 4.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                    ';
                                                } else {
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        if ($i > $avg_rating) {
                                                            echo '<i class="fa fa-star-o"></i>';
                                                        } else {
                                                            echo '<i class="fa fa-star"></i>';
                                                        }
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <?php if ($row['p_qty'] == 0): ?>
                                            <div class="out-of-stock">
                                                <div class="inner">Out Of Stock</div>
                                            </div>
                                        <?php else: ?>
                                            <p><a href="product.php?id=<?php echo $row['p_id']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to Cart</a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>            
            <?php
                        $slide++;
                    }
            ?>
                    </div>
            <?php
                }
            ?>
        </div>
        <a class="left recommended-item-control" href="#recommended-item-carousel1" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel1" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>          
    </div>
</div>
<?php endif; ?>

<!-- ADS PHOTO (DONE) -->
<?php if($ads_above_latest_product_on_off == 1): ?>
<div class="ad-section pb_20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if($adv_type[2] == 'Adsense Code') {
                        echo $adv_adsense_code[2];
                    } else {
                        if($adv_url[2]=='') {
                            echo '<img src="assets/uploads/'.$adv_photo[2].'" alt="Advertisement">';
                        } else {
                            echo '<a href="'.$adv_url[2].'"><img src="assets/uploads/'.$adv_photo[2].'" alt="Advertisement"></a>';
                        }                               
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- LATEST PRODUCTS CAROUSEL (DONE) -->
<?php if($home_latest_product_on_off == 1): ?>
<div class="recommended_items">
    <h2 class="title text-center"><?php echo $latest_product_title; ?></h2>
    <h3 class="title text-center"><?php echo $latest_product_subtitle; ?></h3>
    
    <div id="recommended-item-carousel2" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
                $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? ORDER BY p_id DESC LIMIT ".$total_latest_product_home);
                $statement->execute(array(1));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                // 1 Slider has 3 slides
                $count = count($result);
                $sliders = $count / 3;
                if ($count % 3 != 0) {
                    $sliders++;
                }
                $sliders = floor($sliders);
                $slide = 1;

                for ($slider = 1; $slider <= $sliders; $slider++) {
            ?>
                    <div class="item <?php if ($slider == 1) {echo 'active';} ?>">
            <?php
                    while ($slide <= 3 * $slider) { 
                        if (!isset($result[$slide - 1])) {
                            break;
                        } else {
                            $row = $result[$slide - 1];
                        }
            ?>
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="<?= BASE_URL ?>/assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="" />
                                        <h2>
                                            $<?php echo $row['p_current_price']; ?> 
                                            <?php if ($row['p_old_price'] != ''): ?>
                                                <del>$<?php echo $row['p_old_price']; ?></del>
                                            <?php endif; ?>
                                        </h2>
                                        <p><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></p>
                                        <div class="rating">
                                            <?php
                                                $t_rating = 0;
                                                $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                                $statement1->execute(array($row['p_id']));
                                                $tot_rating = $statement1->rowCount();

                                                if ($tot_rating == 0) {
                                                    $avg_rating = 0;
                                                } else {
                                                    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result1 as $row1) {
                                                        $t_rating = $t_rating + $row1['rating'];
                                                    }
                                                    $avg_rating = $t_rating / $tot_rating;
                                                }
                                            ?>
                                            <?php
                                                if ($avg_rating == 0) {
                                                    echo '';
                                                } else if ($avg_rating == 1.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                } else if ($avg_rating == 2.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                } else if ($avg_rating == 3.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                } else if ($avg_rating == 4.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                    ';
                                                } else {
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        if ($i > $avg_rating) {
                                                            echo '<i class="fa fa-star-o"></i>';
                                                        } else {
                                                            echo '<i class="fa fa-star"></i>';
                                                        }
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <?php if ($row['p_qty'] == 0): ?>
                                            <div class="out-of-stock">
                                                <div class="inner">Out Of Stock</div>
                                            </div>
                                        <?php else: ?>
                                            <p><a href="product.php?id=<?php echo $row['p_id']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to Cart</a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>            
            <?php
                        $slide++;
                    }
            ?>
                    </div>
            <?php
                }
            ?>            
        </div>
         <a class="left recommended-item-control" href="#recommended-item-carousel2" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="right recommended-item-control" href="#recommended-item-carousel2" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>          
    </div>
</div>
<?php endif; ?>

<!-- ADS PHOTO (DONE) -->
<?php if($ads_above_popular_product_on_off == 1): ?>
<div class="ad-section pt_20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if($adv_type[3] == 'Adsense Code') {
                        echo $adv_adsense_code[3];
                    } else {
                        if($adv_url[3]=='') {
                            echo '<img src="assets/uploads/'.$adv_photo[3].'" alt="Advertisement">';
                        } else {
                            echo '<a href="'.$adv_url[3].'"><img src="assets/uploads/'.$adv_photo[3].'" alt="Advertisement"></a>';
                        }                               
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- POPULAR PRODUCTS CAROUSEL (DONE) -->
<?php if($home_popular_product_on_off == 1): ?>
<div class="recommended_items">
    <h2 class="title text-center"><?php echo $popular_product_title; ?></h2>
    <h3 class="title text-center"><?php echo $popular_product_subtitle; ?></h3>
    
    <div id="recommended-item-carousel3" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
                $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=? ORDER BY p_total_view DESC LIMIT ".$total_popular_product_home);
                $statement->execute(array(1));
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                // 1 Slider has 3 slides
                $count = count($result);
                $sliders = $count / 3;
                if ($count % 3 != 0) {
                    $sliders++;
                }
                $sliders = floor($sliders);
                $slide = 1;

                for ($slider = 1; $slider <= $sliders; $slider++) {
            ?>
                    <div class="item <?php if ($slider == 1) {echo 'active';} ?>">
            <?php
                    while ($slide <= 3 * $slider) { 
                        if (!isset($result[$slide - 1])) {
                            break;
                        } else {
                            $row = $result[$slide - 1];
                        }
            ?>
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="<?= BASE_URL ?>/assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="" />
                                        <h2>
                                            $<?php echo $row['p_current_price']; ?> 
                                            <?php if ($row['p_old_price'] != ''): ?>
                                                <del>$<?php echo $row['p_old_price']; ?></del>
                                            <?php endif; ?>
                                        </h2>
                                        <p><a href="product.php?id=<?php echo $row['p_id']; ?>"><?php echo $row['p_name']; ?></a></p>
                                        <div class="rating">
                                            <?php
                                                $t_rating = 0;
                                                $statement1 = $pdo->prepare("SELECT * FROM tbl_rating WHERE p_id=?");
                                                $statement1->execute(array($row['p_id']));
                                                $tot_rating = $statement1->rowCount();

                                                if ($tot_rating == 0) {
                                                    $avg_rating = 0;
                                                } else {
                                                    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($result1 as $row1) {
                                                        $t_rating = $t_rating + $row1['rating'];
                                                    }
                                                    $avg_rating = $t_rating / $tot_rating;
                                                }
                                            ?>
                                            <?php
                                                if ($avg_rating == 0) {
                                                    echo '';
                                                } else if ($avg_rating == 1.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                } else if ($avg_rating == 2.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                } else if ($avg_rating == 3.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    ';
                                                } else if ($avg_rating == 4.5) {
                                                    echo '
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                    ';
                                                } else {
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        if ($i > $avg_rating) {
                                                            echo '<i class="fa fa-star-o"></i>';
                                                        } else {
                                                            echo '<i class="fa fa-star"></i>';
                                                        }
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <?php if ($row['p_qty'] == 0): ?>
                                            <div class="out-of-stock">
                                                <div class="inner">Out Of Stock</div>
                                            </div>
                                        <?php else: ?>
                                            <p><a href="product.php?id=<?php echo $row['p_id']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to Cart</a></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>            
            <?php
                        $slide++;
                    }
            ?>
                    </div>
            <?php
                }
            ?>                        
        </div>
         <a class="left recommended-item-control" href="#recommended-item-carousel3" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="right recommended-item-control" href="#recommended-item-carousel3" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>          
    </div>
</div>
<?php endif; ?>

<!-- ADS PHOTO (DONE) -->
<?php if($ads_above_testimonial_on_off == 1): ?>
<div class="ad-section pb_20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if($adv_type[4] == 'Adsense Code') {
                        echo $adv_adsense_code[4];
                    } else {
                        if($adv_url[4]=='') {
                            echo '<img src="assets/uploads/'.$adv_photo[4].'" alt="Advertisement">';
                        } else {
                            echo '<a href="'.$adv_url[4].'"><img src="assets/uploads/'.$adv_photo[4].'" alt="Advertisement"></a>';
                        }                               
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- TESTIMONIAL SECTION (DONE) -->
<?php if($home_testimonial_on_off == 1): ?>
<div id="testimonial" class="row" style="background-image: url(assets/uploads/<?php echo $testimonial_photo; ?>); background-repeat: no-repeat; background-size: cover;">
    <div class="col-md-12">
        <div id="carousel4" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_testimonial");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC); 

                    $slider = 1;
                    foreach ($result as $row) {
                ?>
                        <div class="item <?php if ($slider == 1) {echo 'active';} ?> col-md-6 col-md-offset-3">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3 text-center">  
                                        <h2 class="box-title"><?php echo $testimonial_title; ?></h2>
                                        <h3 class="box-title"><?php echo $testimonial_subtitle; ?></h3>
                                    </div> 
                                </div>  
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-4">
                                        <div class="text-center">
                                            <p><?php echo $row['comment']; ?></p>
                                            <img src="assets/uploads/<?php echo $row['photo']; ?>" alt="" width="80px">
                                            <h3><?php echo $row['name']; ?> </h3>
                                            <h4><?php echo $row['designation']; ?> <span>(<?php echo $row['company']; ?>)</span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php
                            $slider++;
                ?>
                        </div>
                <?php
                    }
                ?>
            </div>
            <a class="left carousel-control" href="#carousel4" data-slide="prev">
              <span class="fa fa-angle-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel4" data-slide="next">
              <span class="fa fa-angle-right"></span>
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- BLOG SECTION (DONE) -->
<?php if($home_blog_on_off == 1): ?>
<section id="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center"> 
                <h2><?php echo $blog_title; ?></h2>
                <h3><?php echo $blog_subtitle; ?></h3> 
            </div> 
        </div>  
        <div class="row">
            <?php
                $i = 0;

                $statement = $pdo->prepare("SELECT * FROM tbl_post ORDER BY post_id DESC");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $row) {
                    $i++;
                    if ($i > 3) {
                        break;
                    }
                    ?>
                    <div class="col-md-4">
                        <div class="text-center">
                            <img src="<?= BASE_URL ?>/assets/uploads/<?php echo $row['photo']; ?>" alt="" style="width: 100%; min-height: 300px;">
                            <h3><?php echo $row['post_title']; ?></h3>
                            <p><?php echo substr($row['post_content'],0,200).' ...'; ?></p>
                            <a href="blog-single.php?slug=<?php echo $row['post_slug']; ?>">Read More</a>
                        </div>
                    </div>
                    <?php
                }
            ?>            
        </div>
    </div>
</section>
<?php endif; ?>


<?php require_once('footer.php'); ?>