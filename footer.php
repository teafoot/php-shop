<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
    $footer_about = $row['footer_about'];
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $contact_address = $row['contact_address'];
    $footer_copyright = $row['footer_copyright'];
    $total_recent_post_footer = $row['total_recent_post_footer'];
    $total_popular_post_footer = $row['total_popular_post_footer'];
    $newsletter_on_off = $row['newsletter_on_off'];
    $before_body = $row['before_body'];
}
?>    
<?php if($newsletter_on_off == 1): ?>
    <div id="newsletter-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 clearfix">
                    <?php
                        if(isset($_POST['form_subscribe']))
                        {
                            if(empty($_POST['email_subscribe'])) 
                            {
                                $valid = 0;
                                $error_message1 .= LANG_VALUE_131;
                            }
                            else
                            {
                                if (filter_var($_POST['email_subscribe'], FILTER_VALIDATE_EMAIL) === false)
                                {
                                    $valid = 0;
                                    $error_message1 .= LANG_VALUE_134;
                                }
                                else
                                {
                                    $statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_email=?");
                                    $statement->execute(array($_POST['email_subscribe']));
                                    $total = $statement->rowCount();                            
                                    if($total)
                                    {
                                        $valid = 0;
                                        $error_message1 .= LANG_VALUE_147;
                                    }
                                    else
                                    {
                                        // Sending email to the requested subscriber for email confirmation
                                        // Getting activation key to send via email. also it will be saved to database until user click on the activation link.
                                        $key = md5(uniqid(rand(), true));

                                        // Getting current date
                                        $current_date = date('Y-m-d');

                                        // Getting current date and time
                                        $current_date_time = date('Y-m-d H:i:s');

                                        // Inserting data into the database
                                        $statement = $pdo->prepare("INSERT INTO tbl_subscriber (subs_email,subs_date,subs_date_time,subs_hash,subs_active) VALUES (?,?,?,?,?)");
                                        $statement->execute(array($_POST['email_subscribe'],$current_date,$current_date_time,$key,0));

                                        // Sending Confirmation Email
                                        $to = $_POST['email_subscribe'];
                                        $subject = 'Subscriber Email Confirmation';

                                        // Getting the url of the verification link
                                        $verification_url = BASE_URL.'verify-subscriber.php?email='.$to.'&key='.$key;

                                        $message = '
                                        Thanks for your interest to subscribe our newsletter!<br><br>
                                        Please click this link to confirm your subscription:
                                        '.$verification_url.'<br><br>
                                        This link will be active only for 24 hours.
                                        ';

                                        try {

                                            $mail->setFrom($contact_email, 'Admin');
                                            $mail->addAddress($to);
                                            $mail->addReplyTo($contact_email, 'Admin');

                                            $mail->isHTML(true);
                                            $mail->Subject = $subject;

                                            $mail->Body = $message;
                                            $mail->send();

                                            $success_message1 = LANG_VALUE_136;   
                                        } catch (Exception $e) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        }
                                    }
                                }
                            }
                        }
                        if($error_message1 != '') {
                            echo "<script>alert('".$error_message1."')</script>";
                        }
                        if($success_message1 != '') {
                            echo "<script>alert('".$success_message1."')</script>";
                        }
                    ?>
                    <h3><?php echo LANG_VALUE_93; ?></h3>
                    <form id="register-newsletter" action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <input type="email" class="form-control" placeholder="<?php echo LANG_VALUE_95; ?>" name="email_subscribe">
                        <button class="btn btn-custom-3" type="submit" name="form_subscribe"><?php echo LANG_VALUE_92; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>  
<?php endif; ?>

    <footer id="footer"><!--Footer-->
        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2><?php echo LANG_VALUE_110; ?></h2>
                            <p><?php echo nl2br($footer_about); ?></p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2><?php echo LANG_VALUE_113; ?></h2>
                            <ul class="nav nav-pills nav-stacked">
                                <?php
                                    $i = 0;
                                    $statement = $pdo->prepare("SELECT * FROM tbl_post ORDER BY post_id DESC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $i++;
                                        if($i > $total_recent_post_footer) {
                                            break;
                                        }
                                        ?>
                                        <li><a href="blog-single.php?slug=<?php echo $row['post_slug']; ?>"><?php echo $row['post_title']; ?></a></li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2><?php echo LANG_VALUE_112; ?></h2>
                            <ul class="nav nav-pills nav-stacked">
                                <?php
                                    $i = 0;
                                    $statement = $pdo->prepare("SELECT * FROM tbl_post ORDER BY total_view DESC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                                    foreach ($result as $row) {
                                        $i++;
                                        if($i > $total_popular_post_footer) {
                                            break;
                                        }
                                        ?>
                                        <li><a href="blog-single.php?slug=<?php echo $row['post_slug']; ?>"><?php echo $row['post_title']; ?></a></li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2><?php echo LANG_VALUE_114; ?></h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><?php echo nl2br($contact_address); ?></li>
                                <li><?php echo $contact_phone; ?></li>
                                <li><?php echo $contact_email; ?></li>
                            </ul>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="text-center"><?php echo $footer_copyright; ?></p>
                </div>
            </div>
        </div>
    </footer><!--/Footer-->
  
    <script src="<?= BASE_URL ?>/assets/vendor/eshopper/js/jquery.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/eshopper/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/eshopper/js/jquery.scrollUp.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/eshopper/js/price-range.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/eshopper/js/jquery.prettyPhoto.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/eshopper/js/main.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/owlcarousel/owl.carousel.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/bxslider/jquery.bxslider.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="<?= BASE_URL ?>/admin/assets/vendor/AdminLTE-2.4.10/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/custom.js"></script>

<?php echo $before_body; ?>
</body>
</html>