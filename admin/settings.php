<?php require_once('header.php'); ?>

<?php
    // UPDATE LOGO
    if (isset($_POST['form1'])) {
        $valid = 1;

        $path = $_FILES['photo_logo']['name'];
        $path_tmp = $_FILES['photo_logo']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $logo = $row['logo'];
                unlink('../assets/uploads/' . $logo);
            }

            // updating the data
            $final_file_name = 'logo' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET logo=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Logo is updated successfully.';
        }
    }

    // UPDATE FAVICON
    if(isset($_POST['form2'])) {
        $valid = 1;

        $path = $_FILES['photo_favicon']['name'];
        $path_tmp = $_FILES['photo_favicon']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $favicon = $row['favicon'];
                unlink('../assets/uploads/' . $favicon);
            }

            // updating the data
            $final_file_name = 'favicon' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET favicon=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Favicon is updated successfully.';
        }
    }

    // UPDATE FOOTER AND CONTACT
    if (isset($_POST['form3'])) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET newsletter_on_off=?, footer_about=?, footer_copyright=?, contact_address=?, contact_email=?, contact_phone=?, contact_fax=?, contact_map_iframe=? WHERE id=1");
        $statement->execute(array($_POST['newsletter_on_off'], $_POST['footer_about'], $_POST['footer_copyright'], $_POST['contact_address'], $_POST['contact_email'], $_POST['contact_phone'], $_POST['contact_fax'], $_POST['contact_map_iframe']));

        $success_message = 'General content settings is updated successfully.';
    }

    // UPDATE CONTACT EMAIL ADDRESS FORM
    if(isset($_POST['form4'])) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET receive_email=?, receive_email_subject=?,receive_email_thank_you_message=?, forget_password_message=? WHERE id=1");
        $statement->execute(array($_POST['receive_email'], $_POST['receive_email_subject'], $_POST['receive_email_thank_you_message'], $_POST['forget_password_message']));

        $success_message = 'Contact form settings information is updated successfully.';
    }

    // UPDATE POSTS FOR SIDEBAR
    if(isset($_POST['form5'])) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET total_recent_post_footer=?, total_popular_post_footer=?, total_recent_post_sidebar=?, total_popular_post_sidebar=?, total_featured_product_home=?, total_latest_product_home=?, total_popular_product_home=? WHERE id=1");
        $statement->execute(array($_POST['total_recent_post_footer'], $_POST['total_popular_post_footer'], $_POST['total_recent_post_sidebar'], $_POST['total_popular_post_sidebar'], $_POST['total_featured_product_home'], $_POST['total_latest_product_home'], $_POST['total_popular_product_home']));

        $success_message = 'Sidebar settings is updated successfully.';
    }

    // UPDATE ON/OFF SECTIONS
    if(isset($_POST['form6_0'])) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET home_service_on_off=?, home_welcome_on_off=?, home_featured_product_on_off=?, home_latest_product_on_off=?, home_popular_product_on_off=?, home_testimonial_on_off=?, home_blog_on_off=? WHERE id=1");
        $statement->execute(array($_POST['home_service_on_off'], $_POST['home_welcome_on_off'], $_POST['home_featured_product_on_off'], $_POST['home_latest_product_on_off'], $_POST['home_popular_product_on_off'], $_POST['home_testimonial_on_off'], $_POST['home_blog_on_off']));

        $success_message = 'Section On-Off Settings is updated successfully.';
    }

    // UPDATE META SECTION
    if(isset($_POST['form6'])) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET meta_title_home=?, meta_keyword_home=?, meta_description_home=? WHERE id=1");
        $statement->execute(array($_POST['meta_title_home'], $_POST['meta_keyword_home'], $_POST['meta_description_home']));

        $success_message = 'Home Meta settings is updated successfully.';
    }

    // UPDATE CALL TO ACTION SECTION
    if(isset($_POST['form6_7'])) {
        $valid = 1;

        if (empty($_POST['cta_title'])) {
            $valid = 0;
            $error_message .= 'Call to Action Title can not be empty<br>';
        }

        if (empty($_POST['cta_content'])) {
            $valid = 0;
            $error_message .= 'Call to Action Content can not be empty<br>';
        }

        if (empty($_POST['cta_read_more_text'])) {
            $valid = 0;
            $error_message .= 'Call to Action Read More Text can not be empty<br>';
        }

        if (empty($_POST['cta_read_more_url'])) {
            $valid = 0;
            $error_message .= 'Call to Action Read More URL can not be empty<br>';
        }

        $path = $_FILES['cta_photo']['name'];
        $path_tmp = $_FILES['cta_photo']['tmp_name'];

        if ($path != '') {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif' ) {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            if ($path != '') {
                // removing the existing photo
                $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
                foreach ($result as $row) {
                    $cta_photo = $row['cta_photo'];
                    unlink('../assets/uploads/' . $cta_photo);
                }

                // updating the data
                $final_file_name = 'cta' . '.' . $ext;
                move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name );

                // updating the database w/ photo
                $statement = $pdo->prepare("UPDATE tbl_settings SET cta_title=?, cta_content=?, cta_read_more_text=?, cta_read_more_url=?, cta_photo=? WHERE id=1");
                $statement->execute(array($_POST['cta_title'], $_POST['cta_content'], $_POST['cta_read_more_text'], $_POST['cta_read_more_url'], $final_file_name));
            } else {
                // updating the database w/o photo
                $statement = $pdo->prepare("UPDATE tbl_settings SET cta_title=?, cta_content=?, cta_read_more_text=?, cta_read_more_url=? WHERE id=1");
                $statement->execute(array($_POST['cta_title'], $_POST['cta_content'], $_POST['cta_read_more_text'], $_POST['cta_read_more_url']));
            }

            $success_message = 'Call to Action Data is updated successfully.';
        }
    }

    // FEATURED PRODUCT SECTION 
    if (isset($_POST['form6_4'])) {
        $valid = 1;

        if (empty($_POST['featured_product_title'])) {
            $valid = 0;
            $error_message .= 'Featured Product Title can not be empty<br>';
        }

        if (empty($_POST['featured_product_subtitle'])) {
            $valid = 0;
            $error_message .= 'Featured Product SubTitle can not be empty<br>';
        }

        if ($valid == 1) {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET featured_product_title=?, featured_product_subtitle=? WHERE id=1");
            $statement->execute(array($_POST['featured_product_title'], $_POST['featured_product_subtitle']));

            $success_message = 'Featured Product Data is updated successfully.';
        }
    }

    // LATEST PRODUCT SECTION
    if (isset($_POST['form6_5'])) {
        $valid = 1;

        if (empty($_POST['latest_product_title'])) {
            $valid = 0;
            $error_message .= 'Latest Product Title can not be empty<br>';
        }

        if (empty($_POST['latest_product_subtitle'])) {
            $valid = 0;
            $error_message .= 'Latest Product SubTitle can not be empty<br>';
        }

        if ($valid == 1) {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET latest_product_title=?, latest_product_subtitle=? WHERE id=1");
            $statement->execute(array($_POST['latest_product_title'], $_POST['latest_product_subtitle']));

            $success_message = 'Latest Product Data is updated successfully.';
        }
    }

    // POPULAR PRODUCT SECTION
    if (isset($_POST['form6_6'])) {
        $valid = 1;

        if (empty($_POST['popular_product_title'])) {
            $valid = 0;
            $error_message .= 'Popular Product Title can not be empty<br>';
        }

        if (empty($_POST['popular_product_subtitle'])) {
            $valid = 0;
            $error_message .= 'Popular Product SubTitle can not be empty<br>';
        }

        if ($valid == 1) {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET popular_product_title=?, popular_product_subtitle=? WHERE id=1");
            $statement->execute(array($_POST['popular_product_title'], $_POST['popular_product_subtitle']));

            $success_message = 'Popular Product Data is updated successfully.';
        }
    }

    // TESTIMONIAL SECTION
    if (isset($_POST['form6_1'])) {
        $valid = 1;

        if (empty($_POST['testimonial_title'])) {
            $valid = 0;
            $error_message .= 'Testimonial Title can not be empty<br>';
        }

        if (empty($_POST['testimonial_subtitle'])) {
            $valid = 0;
            $error_message .= 'Testimonial SubTitle can not be empty<br>';
        }

        $path = $_FILES['testimonial_photo']['name'];
        $path_tmp = $_FILES['testimonial_photo']['tmp_name'];

        if ($path != '') {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            if ($path != '') {
                // removing the existing photo
                $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
                foreach ($result as $row) {
                    $testimonial_photo = $row['testimonial_photo'];
                    unlink('../assets/uploads/' . $testimonial_photo);
                }

                // updating the data
                $final_file_name = 'testimonial' . '.' . $ext;
                move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

                // updating the database w/ photo
                $statement = $pdo->prepare("UPDATE tbl_settings SET testimonial_title=?, testimonial_subtitle=?, testimonial_photo=? WHERE id=1");
                $statement->execute(array($_POST['testimonial_title'], $_POST['testimonial_subtitle'], $final_file_name));
            } else {
                // updating the database w/o photo
                $statement = $pdo->prepare("UPDATE tbl_settings SET testimonial_title=?, testimonial_subtitle=? WHERE id=1");
                $statement->execute(array($_POST['testimonial_title'], $_POST['testimonial_subtitle']));
            }

            $success_message = 'Testimonial Data is updated successfully.';
        }
    }

    // BLOG SECTION
    if (isset($_POST['form6_2'])) {
        $valid = 1;

        if (empty($_POST['blog_title'])) {
            $valid = 0;
            $error_message .= 'Blog Title can not be empty<br>';
        }

        if (empty($_POST['blog_subtitle'])) {
            $valid = 0;
            $error_message .= 'Blog SubTitle can not be empty<br>';
        }

        if ($valid == 1) {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET blog_title=?, blog_subtitle=? WHERE id=1");
            $statement->execute(array($_POST['blog_title'], $_POST['blog_subtitle']));

            $success_message = 'Blog Data is updated successfully.';
        }
    }

    // NEWSLETTER SECTION
    if (isset($_POST['form6_3'])) {
        $valid = 1;

        if (empty($_POST['newsletter_text'])) {
            $valid = 0;
            $error_message .= 'Newsletter Text can not be empty<br>';
        }

        if ($valid == 1) {
            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET newsletter_text=? WHERE id=1");
            $statement->execute(array($_POST['newsletter_text']));
            
            $success_message = 'Newsletter Text is updated successfully.';
        }
    }

    // CHANGE LOGIN PAGE BANNER
    if (isset($_POST['form7_1'])) {
        $valid = 1;

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $banner_login = $row['banner_login'];
                unlink('../assets/uploads/' . $banner_login);
            }

            // updating the data
            $final_file_name = 'banner_login' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET banner_login=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Login Page Banner is updated successfully.';
        }
    }

    // CHANGE REGISTRATION PAGE BANNER
    if (isset($_POST['form7_2'])) {
        $valid = 1;

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $banner_registration = $row['banner_registration'];
                unlink('../assets/uploads/' . $banner_registration);
            }

            // updating the data
            $final_file_name = 'banner_registration' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name );

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET banner_registration=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Registration Page Banner is updated successfully.';
        }
    }

    // CHANGE FORGOT PASSWORD PAGE BANNER
    if (isset($_POST['form7_3'])) {
        $valid = 1;

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif' ) {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $banner_forget_password = $row['banner_forget_password'];
                unlink('../assets/uploads/' . $banner_forget_password);
            }

            // updating the data
            $final_file_name = 'banner_forget_password' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET banner_forget_password=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Forget Password Page Banner is updated successfully.';
        }
    }

    // CHANGE RESET PASSWORD PAGE BANNER
    if(isset($_POST['form7_4'])) {
        $valid = 1;

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $banner_reset_password = $row['banner_reset_password'];
                unlink('../assets/uploads/' . $banner_reset_password);
            }

            // updating the data
            $final_file_name = 'banner_reset_password' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET banner_reset_password=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Reset Password Page Banner is updated successfully.';
        }
    }

    // Change Search Page Banner
    if (isset($_POST['form7_6'])) {
        $valid = 1;

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $banner_search = $row['banner_search'];
                unlink('../assets/uploads/' . $banner_search);
            }

            // updating the data
            $final_file_name = 'banner_search' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET banner_search=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Search Page Banner is updated successfully.';
        }
    }

    // Change Cart Page Banner
    if (isset($_POST['form7_7'])) {
        $valid = 1;

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $banner_cart = $row['banner_cart'];
                unlink('../assets/uploads/' . $banner_cart);
            }

            // updating the data
            $final_file_name = 'banner_cart' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET banner_cart=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Cart Page Banner is updated successfully.';
        }
    }

    // Change Checkout Page Banner
    if (isset($_POST['form7_8'])) {
        $valid = 1;

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $banner_checkout = $row['banner_checkout'];
                unlink('../assets/uploads/' . $banner_checkout);
            }

            // updating the data
            $final_file_name = 'banner_checkout' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET banner_checkout=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Checkout Page Banner is updated successfully.';
        }
    }

    // Change Product Category Page Banner
    if(isset($_POST['form7_9'])) {
        $valid = 1;

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $banner_product_category = $row['banner_product_category'];
                unlink('../assets/uploads/' . $banner_product_category);
            }

            // updating the data
            $final_file_name = 'banner_product_category' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name );

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET banner_product_category=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Product Category Page Banner is updated successfully.';
        }
    }

    // Change Blog Page Banner
    if (isset($_POST['form7_10'])) {
        $valid = 1;

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path == '') {
            $valid = 0;
            $error_message .= 'You must have to select a photo<br>';
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            // $file_name = basename( $path, '.' . $ext );
            if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if ($valid == 1) {
            // removing the existing photo
            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
            foreach ($result as $row) {
                $banner_blog = $row['banner_blog'];
                unlink('../assets/uploads/' . $banner_blog);
            }

            // updating the data
            $final_file_name = 'banner_blog' . '.' . $ext;
            move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

            // updating the database
            $statement = $pdo->prepare("UPDATE tbl_settings SET banner_blog=? WHERE id=1");
            $statement->execute(array($final_file_name));

            $success_message = 'Blog Page Banner is updated successfully.';
        }
    }

    // UPDATE PAYMENT SETTINGS
    if(isset($_POST['form9'])) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET paypal_email=?, stripe_public_key=?, stripe_secret_key=?, bank_detail=? WHERE id=1");
        $statement->execute(array($_POST['paypal_email'], $_POST['stripe_public_key'], $_POST['stripe_secret_key'], $_POST['bank_detail']));

        $success_message = 'Payment Settings is updated successfully.';
    }

    // HEAD & BODY SCRIPTS SETTINGS
    if(isset($_POST['form10'])) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET before_head=?, after_body=?, before_body=? WHERE id=1");
        $statement->execute(array($_POST['before_head'], $_POST['after_body'], $_POST['before_body']));

        $success_message = 'Head and Body Script is updated successfully.';
    }

    // ADVERTISEMENTS ON/OFF
    if (isset($_POST['form11'])) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_settings SET ads_above_welcome_on_off=?, ads_above_featured_product_on_off=?, ads_above_latest_product_on_off=?, ads_above_popular_product_on_off=?, ads_above_testimonial_on_off=?, ads_category_sidebar_on_off=? WHERE id=1");
        $statement->execute(array($_POST['ads_above_welcome_on_off'], $_POST['ads_above_featured_product_on_off'], $_POST['ads_above_latest_product_on_off'], $_POST['ads_above_popular_product_on_off'], $_POST['ads_above_testimonial_on_off'], $_POST['ads_category_sidebar_on_off']));

        $success_message = 'Advertisement On-Off Section is updated successfully.';
    }
?>

<?php
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) {
        $logo                            = $row['logo'];
        $favicon                         = $row['favicon'];
        $footer_about                    = $row['footer_about'];
        $footer_copyright                = $row['footer_copyright'];
        $contact_address                 = $row['contact_address'];
        $contact_email                   = $row['contact_email'];
        $contact_phone                   = $row['contact_phone'];
        $contact_fax                     = $row['contact_fax'];
        $contact_map_iframe              = $row['contact_map_iframe'];
        $receive_email                   = $row['receive_email'];
        $receive_email_subject           = $row['receive_email_subject'];
        $receive_email_thank_you_message = $row['receive_email_thank_you_message'];
        $forget_password_message         = $row['forget_password_message'];
        $total_recent_post_footer        = $row['total_recent_post_footer'];
        $total_popular_post_footer       = $row['total_popular_post_footer'];
        $total_recent_post_sidebar       = $row['total_recent_post_sidebar'];
        $total_popular_post_sidebar      = $row['total_popular_post_sidebar'];
        $total_featured_product_home     = $row['total_featured_product_home'];
        $total_latest_product_home       = $row['total_latest_product_home'];
        $total_popular_product_home      = $row['total_popular_product_home'];
        $meta_title_home                 = $row['meta_title_home'];
        $meta_keyword_home               = $row['meta_keyword_home'];
        $meta_description_home           = $row['meta_description_home'];
        $banner_login                    = $row['banner_login'];
        $banner_registration             = $row['banner_registration'];
        $banner_forget_password          = $row['banner_forget_password'];
        $banner_reset_password           = $row['banner_reset_password'];
        $banner_search                   = $row['banner_search'];
        $banner_cart                     = $row['banner_cart'];
        $banner_checkout                 = $row['banner_checkout'];
        $banner_product_category         = $row['banner_product_category'];
        $banner_blog                     = $row['banner_blog'];
        $cta_title                       = $row['cta_title'];
        $cta_content                     = $row['cta_content'];
        $cta_read_more_text              = $row['cta_read_more_text'];
        $cta_read_more_url               = $row['cta_read_more_url'];
        $cta_photo                       = $row['cta_photo'];
        $featured_product_title          = $row['featured_product_title'];
        $featured_product_subtitle       = $row['featured_product_subtitle'];
        $latest_product_title            = $row['latest_product_title'];
        $latest_product_subtitle         = $row['latest_product_subtitle'];
        $popular_product_title           = $row['popular_product_title'];
        $popular_product_subtitle        = $row['popular_product_subtitle'];
        $testimonial_title               = $row['testimonial_title'];
        $testimonial_subtitle            = $row['testimonial_subtitle'];
        $testimonial_photo               = $row['testimonial_photo'];
        $blog_title                      = $row['blog_title'];
        $blog_subtitle                   = $row['blog_subtitle'];
        $newsletter_text                 = $row['newsletter_text'];
        $paypal_email                    = $row['paypal_email'];
        $stripe_public_key               = $row['stripe_public_key'];
        $stripe_secret_key               = $row['stripe_secret_key'];
        $bank_detail                     = $row['bank_detail'];
        $before_head                     = $row['before_head'];
        $after_body                      = $row['after_body'];
        $before_body                     = $row['before_body'];
        $home_service_on_off             = $row['home_service_on_off'];
        $home_welcome_on_off             = $row['home_welcome_on_off'];
        $home_featured_product_on_off    = $row['home_featured_product_on_off'];
        $home_latest_product_on_off      = $row['home_latest_product_on_off'];
        $home_popular_product_on_off     = $row['home_popular_product_on_off'];
        $home_testimonial_on_off         = $row['home_testimonial_on_off'];
        $home_blog_on_off                = $row['home_blog_on_off'];
        $newsletter_on_off               = $row['newsletter_on_off'];
        $ads_above_welcome_on_off           = $row['ads_above_welcome_on_off'];
        $ads_above_featured_product_on_off  = $row['ads_above_featured_product_on_off'];
        $ads_above_latest_product_on_off    = $row['ads_above_latest_product_on_off'];
        $ads_above_popular_product_on_off   = $row['ads_above_popular_product_on_off'];
        $ads_above_testimonial_on_off       = $row['ads_above_testimonial_on_off'];
        $ads_category_sidebar_on_off        = $row['ads_category_sidebar_on_off'];
    }
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Settings</h1>
    </div>
</section>

<section class="content" style="min-height:auto;margin-bottom: -30px;">
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
</section>

<div class="row">
    <div class="col-md-12">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1primary" data-toggle="tab">Logo</a></li>
                    <li><a href="#tab2primary" data-toggle="tab">Favicon</a></li>
                    <li><a href="#tab3primary" data-toggle="tab">Footer & Contact</a></li>
                    <li><a href="#tab4primary" data-toggle="tab">Email</a></li>
                    <li><a href="#tab5primary" data-toggle="tab">Post</a></li>
                    <li><a href="#tab6primary" data-toggle="tab">Homepage</a></li>
                    <li><a href="#tab7primary" data-toggle="tab">Banner</a></li>
                    <li><a href="#tab8primary" data-toggle="tab">Payment Settings</a></li>
                    <li><a href="#tab9primary" data-toggle="tab">Head & Body Scripts</a></li>
                    <li><a href="#tab10primary" data-toggle="tab">Ads</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab1primary">
                        <form action="" method="post" enctype="multipart/form-data">       
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="">Existing Photo</label>
                                </div>
                                <div class="col-md-6">
                                    <img src="../assets/uploads/<?= $logo ?>" class="existing-photo" style="height:80px;">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="photo_logo">New Photo</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="photo_logo">
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form1">Update Logo</button>                       
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab2primary">
                       <form class="" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="">Existing Photo</label>
                                </div>
                                <div class="col-md-6">
                                    <img src="../assets/uploads/<?= $favicon ?>" class="existing-photo" style="height:40px;">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="">New Photo</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="photo_favicon">
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form2">Update Favicon</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab3primary">
                        <form class="" action="" method="post">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="newsletter_on_off">Newsletter Section</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="newsletter_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($newsletter_on_off == 1 ) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($newsletter_on_off == 0 ) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="footer_about">Footer - About Us</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="footer_about" id="editor1">
                                        <?php echo $footer_about; ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="footer_copyright">Footer - Copyright</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" name="footer_copyright" value="<?php echo $footer_copyright; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="contact_address">Contact Address</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="contact_address" style="height:140px;"><?php echo $contact_address; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="contact_email">Contact Email</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="contact_email" value="<?php echo $contact_email; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="contact_phone">Contact Phone Number</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="contact_phone" value="<?php echo $contact_phone; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="contact_fax">Contact Fax Number</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="contact_fax" value="<?php echo $contact_fax; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="contact_fax">Contact Map iFrame</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="contact_map_iframe" style="height:200px;"><?php echo $contact_map_iframe; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">                                
                                    <button type="submit" class="btn btn-success" name="form3">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab4primary">
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="receive_email">Contact Email Address</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="receive_email" value="<?php echo $receive_email; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="receive_email_subject">Contact Email Subject</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="receive_email_subject" value="<?php echo $receive_email_subject; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="receive_email_thank_you_message">Contact Email Thank you message</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="receive_email_thank_you_message">Thank you for sending email. We will contact you shortly.</textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="forget_password_message">Forget password Message</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="forget_password_message"><?php echo $forget_password_message; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form4">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab5primary">
                        <form class="form-horizontal" action="" method="post">                            
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="total_recent_post_footer">Footer (How many recent posts?)*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="total_recent_post_footer" value="<?php echo $total_recent_post_footer; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="total_popular_post_footer">Footer (How many popular posts?)*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="total_popular_post_footer" value="<?php echo $total_popular_post_footer; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="total_recent_post_sidebar">Sidebar (How many recent posts?)*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="total_recent_post_sidebar" value="<?php echo $total_recent_post_sidebar; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="total_popular_post_sidebar">Sidebar (How many popular posts?)*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="total_popular_post_sidebar" value="<?php echo $total_popular_post_sidebar; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="total_featured_product_home">Home Page (How many featured product?)*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="total_featured_product_home" value="<?php echo $total_featured_product_home; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="total_latest_product_home">Home Page (How many latest product?)*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="total_latest_product_home" value="<?php echo $total_latest_product_home; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="total_popular_product_home">Home Page (How many popular product?)*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="total_popular_product_home" value="<?php echo $total_popular_product_home; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form5">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab6primary">
                        <h3>Sections On and Off</h3><hr>
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="home_service_on_off">Service Section</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="home_service_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($home_service_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($home_service_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="home_welcome_on_off">Welcome Section</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="home_welcome_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($home_welcome_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($home_welcome_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="home_featured_product_on_off">Featured Product Section</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="home_featured_product_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($home_featured_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($home_featured_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="home_latest_product_on_off">Latest Product Section</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="home_latest_product_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($home_latest_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($home_latest_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="home_popular_product_on_off">Popular Product Section</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="home_popular_product_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($home_popular_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($home_popular_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="home_testimonial_on_off">Testimonial Section</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="home_testimonial_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($home_testimonial_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($home_testimonial_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="home_blog_on_off">Blog Section</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="home_blog_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($home_blog_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($home_blog_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form6_0">Update</button>
                                </div>
                            </div>
                        </form>
                        <h3>Meta Section</h3><hr>
                        <form class="form-horizontal" action="" method="post">    
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="meta_title_home">Meta Title</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="meta_title_home" class="form-control" value="<?php echo $meta_title_home ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="meta_keyword_home">Meta Keyword</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="meta_keyword_home" style="height:100px;"><?php echo $meta_keyword_home ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="meta_description_home">Meta Description</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="meta_description_home" style="height:200px;"><?php echo $meta_description_home ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form6">Update</button>
                                </div>
                            </div>
                        </form>
                        <h3>Call to Action Section</h3><hr>
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="cta_title">Title*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cta_title" value="<?php echo $cta_title; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="cta_content">Content*</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="cta_content" class="form-control" cols="30" rows="10" style="height:120px;"><?php echo $cta_content; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="cta_read_more_text">Read More Text*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cta_read_more_text" value="<?php echo $cta_read_more_text; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="cta_read_more_url">Read More URL*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cta_read_more_url" value="<?php echo $cta_read_more_url; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="">Existing Call to Action Background</label>
                                </div>
                                <div class="col-md-6">
                                    <img src="../assets/uploads/<?php echo $cta_photo; ?>" class="existing-photo" style="height:80px;">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="cta_photo">New Background</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="cta_photo">
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form6_7">Update</button>
                                </div>
                            </div>
                        </form>
                        <h3>Featured Product Section</h3><hr>
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="featured_product_title">Featured Product Title*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="featured_product_title" value="<?php echo $featured_product_title; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="featured_product_subtitle">Featured Product SubTitle*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="featured_product_subtitle" value="<?php echo $featured_product_subtitle; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form6_4">Update</button>
                                </div>
                            </div>
                        </form>
                        <h3>Latest Product Section</h3><hr>
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="latest_product_title">Latest Product Title*</label>
                                </div>
                                <div class="col-md-6">    
                                    <input type="text" class="form-control" name="latest_product_title" value="<?php echo $latest_product_title; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="latest_product_subtitle">Latest Product SubTitle*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="latest_product_subtitle" value="<?php echo $latest_product_subtitle; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form6_5">Update</button>
                                </div>
                            </div>
                        </form>
                        <h3>Popular Product Section</h3><hr>
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="popular_product_title">Popular Product Title*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="popular_product_title" value="<?php echo $popular_product_title; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="popular_product_subtitle">Popular Product SubTitle*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="popular_product_subtitle" value="<?php echo $popular_product_subtitle; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form6_6">Update</button>
                                </div>
                            </div>
                        </form>
                        <h3>Testimonial Section</h3><hr>
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="testimonial_title">Testimonial Section Title*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="testimonial_title" value="<?php echo $testimonial_title; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="testimonial_subtitle">Testimonial Section SubTitle*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="testimonial_subtitle" value="<?php echo $testimonial_subtitle; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="">Existing Testimonial Background</label>
                                </div>
                                <div class="col-md-6">
                                    <img src="../assets/uploads/<?php echo $testimonial_photo; ?>" class="existing-photo" style="height:80px;">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="testimonial_photo">New Background</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="testimonial_photo">
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form6_1">Update</button>
                                </div>
                            </div>
                        </form>
                        <h3>Blog Section</h3><hr>
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="blog_title">Blog Section Title*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="blog_title" value="<?php echo $blog_title; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="blog_subtitle">Blog Section SubTitle*</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="blog_subtitle" value="<?php echo $blog_subtitle; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form6_2">Update</button>
                                </div>
                            </div>
                        </form>
                        <h3>Newsletter Section</h3><hr>
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">    
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="newsletter_text">Newsletter Text</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="newsletter_text" class="form-control" cols="30" rows="10" style="height: 120px;"><?php echo $newsletter_text; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form6_3">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab7primary">
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 24px;">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <h4>Existing Login Page Banner</h4><hr>                                    
                                    <img src="<?php echo '../assets/uploads/' . $banner_login; ?>" alt="" style="width: 100%;height:auto;"> 
                                </div>
                                <div class="col-md-6">
                                    <h4>Change Login Page Banner</h4><hr>
                                    <label for="photo">Select Photo</label>
                                    <input type="file" name="photo">
                                    <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_1">
                                </div>      
                            </div>
                        </form>
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 24px;">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <h4>Existing Registration Page Banner</h4><hr>                                    
                                    <img src="<?php echo '../assets/uploads/' . $banner_registration; ?>" alt="" style="width: 100%;height:auto;">  
                                </div>
                                <div class="col-md-6">                                
                                    <h4>Change Registration Page Banner</h4><hr>  
                                    <label for="photo">Select Photo</label>
                                    <input type="file" name="photo">
                                    <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_2">
                                </div>
                            </div>
                        </form>
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 24px;">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <h4>Existing Forget Password Page Banner</h4><hr>                                    
                                    <img src="<?php echo '../assets/uploads/'.$banner_forget_password; ?>" alt="" style="width: 100%;height:auto;">   
                                </div>
                                <div class="col-md-6">                                
                                    <h4>Change Forget Password Page Banner</h4><hr>  
                                    <label for="photo">Select Photo</label>
                                    <input type="file" name="photo">
                                    <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_3">
                                </div>
                            </div>
                        </form>
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 24px;">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <h4>Existing Reset Password Page Banner</h4><hr>                                    
                                    <img src="<?php echo '../assets/uploads/'.$banner_reset_password; ?>" alt="" style="width: 100%;height:auto;">
                                </div>
                                <div class="col-md-6">                                
                                    <h4>Change Reset Password Page Banner</h4><hr>  
                                    <label for="photo">Select Photo</label>
                                    <input type="file" name="photo">
                                    <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_4">
                                </div>
                            </div>
                        </form>
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 24px;">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <h4>Existing Search Page Banner</h4><hr>                                    
                                    <img src="<?php echo '../assets/uploads/'.$banner_search; ?>" alt="" style="width: 100%;height:auto;">
                                </div>
                                <div class="col-md-6">                                
                                    <h4>Change Search Page Banner</h4><hr>  
                                    <label for="photo">Select Photo</label>
                                    <input type="file" name="photo">
                                    <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_6">
                                </div>
                            </div>
                        </form>
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 24px;">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <h4>Existing Cart Page Banner</h4><hr>                                    
                                    <img src="<?php echo '../assets/uploads/'.$banner_cart; ?>" alt="" style="width: 100%;height:auto;">
                                </div>
                                <div class="col-md-6">                                
                                    <h4>Change Cart Page Banner</h4><hr>  
                                    <label for="photo">Select Photo</label>
                                    <input type="file" name="photo">
                                    <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_7">
                                </div>
                            </div>
                        </form>
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 24px;">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <h4>Existing Checkout Page Banner</h4><hr>                                    
                                    <img src="<?php echo '../assets/uploads/'.$banner_checkout; ?>" alt="" style="width: 100%;height:auto;">
                                </div>
                                <div class="col-md-6">                                
                                    <h4>Change Checkout Page Banner</h4><hr>  
                                    <label for="photo">Select Photo</label>
                                    <input type="file" name="photo">
                                    <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_8">
                                </div>
                            </div>
                        </form>
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 24px;">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <h4>Existing Product Category Page Banner</h4><hr>                                    
                                    <img src="<?php echo '../assets/uploads/'.$banner_product_category; ?>" alt="" style="width: 100%;height:auto;">
                                </div>
                                <div class="col-md-6">                                
                                    <h4>Change Product Category Page Banner</h4><hr>  
                                    <label for="photo">Select Photo</label>
                                    <input type="file" name="photo">
                                    <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_9">
                                </div>
                            </div>
                        </form>
                        <form action="" method="post" enctype="multipart/form-data" style="margin-bottom: 24px;">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <h4>Existing Blog Page Banner</h4><hr>                                    
                                    <img src="<?php echo '../assets/uploads/'.$banner_blog; ?>" alt="" style="width: 100%;height:auto;">
                                </div>
                                <div class="col-md-6">                                
                                    <h4>Change Blog Page Banner</h4><hr>  
                                    <label for="photo">Select Photo</label>
                                    <input type="file" name="photo">
                                    <input type="submit" class="btn btn-primary btn-xs" value="Change" style="margin-top:10px;" name="form7_10">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab8primary">
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="paypal_email">PayPal - Business Email</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="paypal_email" class="form-control" value="<?php echo $paypal_email; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="stripe_public_key">Stripe - Public Key</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="stripe_public_key" class="form-control" value="<?php echo $stripe_public_key; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="stripe_secret_key">Stripe - Secret Key</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="stripe_secret_key" class="form-control" value="<?php echo $stripe_secret_key; ?>">
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="bank_detail">Bank Information</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="bank_detail" class="form-control" cols="30" rows="10"><?php echo $bank_detail; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form9">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab9primary">
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="before_head">Code before &lt;/head&gt; tag</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="before_head" class="form-control" cols="30" rows="10"><?php echo $before_head; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="after_body">Code after &lt;body&gt; tag</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="after_body" class="form-control" cols="30" rows="10"><?php echo $after_body; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="before_body">Code before &lt;/body&gt; tag</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="before_body" class="form-control" cols="30" rows="10"><?php echo $before_body; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form10">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab10primary">
                        <h3>Advertisements On and Off</h3><hr>
                        <form class="form-horizontal" action="" method="post">
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="ads_above_welcome_on_off">Above Welcome</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="ads_above_welcome_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($ads_above_welcome_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($ads_above_welcome_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="ads_above_featured_product_on_off">Above Featured Product</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="ads_above_featured_product_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($ads_above_featured_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($ads_above_featured_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="ads_above_latest_product_on_off">Above Latest Product</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="ads_above_latest_product_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($ads_above_latest_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($ads_above_latest_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="ads_above_popular_product_on_off">Above Popular Product</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="ads_above_popular_product_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($ads_above_popular_product_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($ads_above_popular_product_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="ads_above_testimonial_on_off">Above Testimonial</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="ads_above_testimonial_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($ads_above_testimonial_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($ads_above_testimonial_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                         
                                <div class="col-md-2">  
                                    <label for="ads_category_sidebar_on_off">Category Page Sidebar</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="ads_category_sidebar_on_off" class="form-control" style="width:auto;">
                                        <option value="1" <?php if ($ads_category_sidebar_on_off == 1) {echo 'selected';} ?>>On</option>
                                        <option value="0" <?php if ($ads_category_sidebar_on_off == 0) {echo 'selected';} ?>>Off</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success" name="form11">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>