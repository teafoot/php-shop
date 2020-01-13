<?php require_once('header.php'); ?>

<?php
    // Above Welcome Section
    if (isset($_POST['form1'])) {
        $valid = 1;
        if ($_POST['adv_type'] == 'Image Advertisement') {
            $path = $_FILES['photo']['name'];
            $path_tmp = $_FILES['photo']['tmp_name'];

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                // $file_name = basename( $path, '.' . $ext );
                if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                    $valid = 0;
                    $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
                }
            }
        } else {
            if (empty($_POST['adv_adsense_code'])) {
                $valid = 0;
                $error_message .= 'You must have to give an adsense code<br>';
            }
        }

        if ($valid == 1) {
            if ($_POST['adv_type'] == 'Adsense Code') {
                if (isset($_POST['previous_photo'])) {
                    unlink('../assets/uploads/' . $_POST['previous_photo']);    
                }

                $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?,  adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                $statement->execute(array($_POST['adv_type'], '', '', $_POST['adv_adsense_code'], 1));
            } else {
                if ($path == '') {
                    // updating into the database w/o photo
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $_POST['adv_url'], '', 1));
                } else {
                    if (isset($_POST['previous_photo'])) {
                        unlink('../assets/uploads/' . $_POST['previous_photo']);    
                    }

                    $final_file_name = 'ad-1.' . $ext;
                    move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

                    // updating into the database
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $final_file_name, $_POST['adv_url'], '', 1));
                }
            }

            $success_message = 'Advertisement is updated successfully.';
        }
    }

    // Above Featured Product Section
    if (isset($_POST['form2'])) {
        $valid = 1;

        if ($_POST['adv_type'] == 'Image Advertisement') {
            $path = $_FILES['photo']['name'];
            $path_tmp = $_FILES['photo']['tmp_name'];

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                // $file_name = basename( $path, '.' . $ext );
                if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                    $valid = 0;
                    $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
                }
            }
        } else {
            if (empty($_POST['adv_adsense_code'])) {
                $valid = 0;
                $error_message .= 'You must have to give an adsense code<br>';
            }
        }

        if ($valid == 1) {
            if ($_POST['adv_type'] == 'Adsense Code') {
                if (isset($_POST['previous_photo'])) {
                    unlink('../assets/uploads/' . $_POST['previous_photo']);    
                }

                $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                $statement->execute(array($_POST['adv_type'], '', '', $_POST['adv_adsense_code'], 2));
            } else {
                if ($path == '') {
                    // updating into the database w/o photo
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $_POST['adv_url'], '' , 2));
                } else {
                    if (isset($_POST['previous_photo'])) {
                        unlink('../assets/uploads/' . $_POST['previous_photo']);    
                    }

                    $final_file_name = 'ad-2.' . $ext;
                    move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

                    // updating into the database
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $final_file_name, $_POST['adv_url'], '', 2));
                }
            }

            $success_message = 'Advertisement is updated successfully.';
        }
    }

    // Above Latest Product Section
    if (isset($_POST['form3'])) {
        $valid = 1;

        if ($_POST['adv_type'] == 'Image Advertisement') {
            $path = $_FILES['photo']['name'];
            $path_tmp = $_FILES['photo']['tmp_name'];

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                // $file_name = basename( $path, '.' . $ext );
                if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                    $valid = 0;
                    $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
                }
            }
        } else {
            if (empty($_POST['adv_adsense_code'])) {
                $valid = 0;
                $error_message .= 'You must have to give an adsense code<br>';
            }
        }

        if ($valid == 1) {
            if ($_POST['adv_type'] == 'Adsense Code') {
                if (isset($_POST['previous_photo'])) {
                    unlink('../assets/uploads/' . $_POST['previous_photo']);    
                }

                $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                $statement->execute(array($_POST['adv_type'], '', '', $_POST['adv_adsense_code'], 3));
            } else {
                if ($path == '') {
                    // updating into the database w/o photo
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $_POST['adv_url'], '', 3));
                } else {
                    if (isset($_POST['previous_photo'])) {
                        unlink('../assets/uploads/' . $_POST['previous_photo']);    
                    }

                    $final_file_name = 'ad-3.' . $ext;
                    move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

                    // updating into the database w/ photo
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $final_file_name, $_POST['adv_url'], '', 3));
                }
            }

            $success_message = 'Advertisement is updated successfully.';
        }
    }

    // Above Popular Product Section
    if (isset($_POST['form4'])) {
        $valid = 1;

        if ($_POST['adv_type'] == 'Image Advertisement') {
            $path = $_FILES['photo']['name'];
            $path_tmp = $_FILES['photo']['tmp_name'];

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                // $file_name = basename( $path, '.' . $ext );
                if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                    $valid = 0;
                    $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
                }
            }
        } else {
            if (empty($_POST['adv_adsense_code'])) {
                $valid = 0;
                $error_message .= 'You must have to give an adsense code<br>';
            }
        }

        if ($valid == 1) {
            if ($_POST['adv_type'] == 'Adsense Code') {
                if (isset($_POST['previous_photo'])) {
                    unlink('../assets/uploads/' . $_POST['previous_photo']);    
                }

                $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                $statement->execute(array($_POST['adv_type'], '', '', $_POST['adv_adsense_code'], 4));
            } else {
                if ($path == '') {
                    // updating into the database w/o photo
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $_POST['adv_url'], '', 4));
                } else {
                    if (isset($_POST['previous_photo'])) {
                        unlink('../assets/uploads/' . $_POST['previous_photo']);    
                    }

                    $final_file_name = 'ad-4.' . $ext;
                    move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

                    // updating into the database w/ photo
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $final_file_name, $_POST['adv_url'], '', 4));
                }
            }

            $success_message = 'Advertisement is updated successfully.';
        }
    }

    // Above Testimonial Section
    if (isset($_POST['form5'])) {
        $valid = 1;

        if ($_POST['adv_type'] == 'Image Advertisement') {
            $path = $_FILES['photo']['name'];
            $path_tmp = $_FILES['photo']['tmp_name'];

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                // $file_name = basename( $path, '.' . $ext );
                if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                    $valid = 0;
                    $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
                }
            }
        } else {
            if (empty($_POST['adv_adsense_code'])) {
                $valid = 0;
                $error_message .= 'You must have to give an adsense code<br>';
            }
        }

        if ($valid == 1) {
            if ($_POST['adv_type'] == 'Adsense Code') {
                if (isset($_POST['previous_photo'])) {
                    unlink('../assets/uploads/' . $_POST['previous_photo']);    
                }

                $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                $statement->execute(array($_POST['adv_type'], '', '', $_POST['adv_adsense_code'], 5));
            } else {
                if ($path == '') {
                    // updating into the database w/o photo
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $_POST['adv_url'], '', 5));
                } else {
                    if (isset($_POST['previous_photo'])) {
                        unlink('../assets/uploads/' . $_POST['previous_photo']);    
                    }

                    $final_file_name = 'ad-5.' . $ext;
                    move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

                    // updating into the database w/o photo
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $final_file_name, $_POST['adv_url'], '', 5));
                }
            }

            $success_message = 'Advertisement is updated successfully.';
        }
    }

    // Category Page Sidebar Section
    if (isset($_POST['form6'])) {
        $valid = 1;

        if ($_POST['adv_type'] == 'Image Advertisement') {
            $path = $_FILES['photo']['name'];
            $path_tmp = $_FILES['photo']['tmp_name'];

            if ($path != '') {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                // $file_name = basename( $path, '.' . $ext );
                if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
                    $valid = 0;
                    $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
                }
            }
        } else {
            if (empty($_POST['adv_adsense_code'])) {
                $valid = 0;
                $error_message .= 'You must have to give an adsense code<br>';
            }
        }

        if ($valid == 1) {
            if ($_POST['adv_type'] == 'Adsense Code') {
                if (isset($_POST['previous_photo'])) {
                    unlink('../assets/uploads/' . $_POST['previous_photo']);    
                }

                $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                $statement->execute(array($_POST['adv_type'], '', '', $_POST['adv_adsense_code'], 6));
            } else {
                if ($path == '') {
                    // updating into the database w/o photo
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $_POST['adv_url'], '', 6));
                } else {
                    if (isset($_POST['previous_photo'])) {
                        unlink('../assets/uploads/' . $_POST['previous_photo']);    
                    }

                    $final_file_name = 'ad-6.' . $ext;
                    move_uploaded_file($path_tmp, '../assets/uploads/' . $final_file_name);

                    // updating into the database w/ photo
                    $statement = $pdo->prepare("UPDATE tbl_advertisement SET adv_type=?, adv_photo=?, adv_url=?, adv_adsense_code=? WHERE adv_id=?");
                    $statement->execute(array($_POST['adv_type'], $final_file_name, $_POST['adv_url'], '', 6));
                }
            }

            $success_message = 'Advertisement is updated successfully.';
        }
    }
?>

<?php
    $statement = $pdo->prepare("SELECT * FROM tbl_advertisement");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) {
        $adv_type[] = $row['adv_type'];
        $adv_location[] = $row['adv_location'];
        $adv_photo[] = $row['adv_photo'];
        $adv_url[] = $row['adv_url'];
        $adv_adsense_code[] = $row['adv_adsense_code'];
    }
?>

<div class="row">
    <section class="content-header">
        <div class="content-header-left">
            <h1>Advertisement</h1>
        </div>
    </section>
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
    <div class="col-md-12">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1primary" data-toggle="tab">Above Welcome Section</a></li>
                    <li><a href="#tab2primary" data-toggle="tab">Above Featured Product Section</a></li>
                    <li><a href="#tab3primary" data-toggle="tab">Above Latest Product Section</a></li>
                    <li><a href="#tab4primary" data-toggle="tab">Above Popular Product Section</a></li>
                    <li><a href="#tab5primary" data-toggle="tab">Above Testimonial Section</a></li>
                    <li><a href="#tab6primary" data-toggle="tab">Category Page Sidebar Section</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="tab1primary">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Type</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="adv_type" class="form-control" onchange="funcTab1(this)">
                                        <?php
                                            if ($adv_type[0] == 'Image Advertisement') {
                                                ?>
                                                <option value="Image Advertisement" selected>Image Advertisement</option>
                                                <option value="Adsense Code">Adsense Code</option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="Image Advertisement">Image Advertisement</option>
                                                <option value="Adsense Code" selected>Adsense Code</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php if ($adv_type[0] == 'Image Advertisement'): ?>
                                <div id="field1" class="form-group row">
                                    <div class="col-md-2">  
                                        <label for="" class="control-label">Existing Photo</label>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="../assets/uploads/<?php echo $adv_photo[0]; ?>" style="width:400px;">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="previous_photo" value="<?php echo $adv_photo[0]; ?>">
                            <div id="field2" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">New Photo (Recommended Width: 1170 pixels and Height: any size)</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="photo">
                                </div>
                            </div>
                            <div id="field3" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">URL</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="adv_url" class="form-control" value="<?php echo $adv_url[0]; ?>">
                                </div>
                            </div>
                            <div id="field4" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Adsense Code</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="adv_adsense_code" class="form-control" cols="30" rows="10" style="height:280px;"><?php echo $adv_adsense_code[0]; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab2primary">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Type</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="adv_type" class="form-control" onchange="funcTab2(this)">
                                        <?php
                                            if ($adv_type[1] == 'Image Advertisement') {
                                                ?>
                                                <option value="Image Advertisement" selected>Image Advertisement</option>
                                                <option value="Adsense Code">Adsense Code</option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="Image Advertisement">Image Advertisement</option>
                                                <option value="Adsense Code" selected>Adsense Code</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php if ($adv_type[1] == 'Image Advertisement'): ?>
                                <div id="field5" class="form-group row">
                                    <div class="col-md-2">  
                                        <label for="" class="control-label">Existing Photo</label>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="../assets/uploads/<?php echo $adv_photo[1]; ?>" style="width:400px;">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="previous_photo" value="<?php echo $adv_photo[1]; ?>">
                            <div id="field6" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">New Photo (Recommended Width: 1170 pixels and Height: any size)</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="photo">
                                </div>
                            </div>
                            <div id="field7" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">URL</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="adv_url" class="form-control" value="<?php echo $adv_url[1]; ?>">
                                </div>
                            </div>
                            <div id="field8" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Adsense Code</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="adv_adsense_code" class="form-control" cols="30" rows="10" style="height:280px;"><?php echo $adv_adsense_code[1]; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success pull-left" name="form2">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab3primary">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Type</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="adv_type" class="form-control" onchange="funcTab3(this)">
                                        <?php
                                            if ($adv_type[2] == 'Image Advertisement') {
                                                ?>
                                                <option value="Image Advertisement" selected>Image Advertisement</option>
                                                <option value="Adsense Code">Adsense Code</option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="Image Advertisement">Image Advertisement</option>
                                                <option value="Adsense Code" selected>Adsense Code</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php if ($adv_type[2] == 'Image Advertisement'): ?>
                                <div id="field9" class="form-group row">
                                    <div class="col-md-2">  
                                        <label for="" class="control-label">Existing Photo</label>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="../assets/uploads/<?php echo $adv_photo[2]; ?>" style="width:400px;">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="previous_photo" value="<?php echo $adv_photo[2]; ?>">
                            <div id="field10" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">New Photo (Recommended Width: 1170 pixels and Height: any size)</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="photo">
                                </div>
                            </div>
                            <div id="field11" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">URL</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="adv_url" class="form-control" value="<?php echo $adv_url[2]; ?>">
                                </div>
                            </div>
                            <div id="field12" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Adsense Code</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="adv_adsense_code" class="form-control" cols="30" rows="10" style="height:280px;"><?php echo $adv_adsense_code[2]; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success pull-left" name="form3">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab4primary">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Type</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="adv_type" class="form-control" onchange="funcTab4(this)">
                                        <?php
                                            if ($adv_type[3] == 'Image Advertisement') {
                                                ?>
                                                <option value="Image Advertisement" selected>Image Advertisement</option>
                                                <option value="Adsense Code">Adsense Code</option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="Image Advertisement">Image Advertisement</option>
                                                <option value="Adsense Code" selected>Adsense Code</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php if ($adv_type[3] == 'Image Advertisement'): ?>
                                <div id="field13" class="form-group row">
                                    <div class="col-md-2">  
                                        <label for="" class="control-label">Existing Photo</label>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="../assets/uploads/<?php echo $adv_photo[3]; ?>" style="width:400px;">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="previous_photo" value="<?php echo $adv_photo[3]; ?>">
                            <div id="field14" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">New Photo (Recommended Width: 1170 pixels and Height: any size)</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="photo">
                                </div>
                            </div>
                            <div id="field15" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">URL</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="adv_url" class="form-control" value="<?php echo $adv_url[3]; ?>">
                                </div>
                            </div>
                            <div id="field16" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Adsense Code</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="adv_adsense_code" class="form-control" cols="30" rows="10" style="height:280px;"><?php echo $adv_adsense_code[3]; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success pull-left" name="form4">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab5primary">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Type</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="adv_type" class="form-control" onchange="funcTab5(this)">
                                        <?php
                                            if ($adv_type[4] == 'Image Advertisement') {
                                                ?>
                                                <option value="Image Advertisement" selected>Image Advertisement</option>
                                                <option value="Adsense Code">Adsense Code</option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="Image Advertisement">Image Advertisement</option>
                                                <option value="Adsense Code" selected>Adsense Code</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php if ($adv_type[4] == 'Image Advertisement'): ?>
                                <div id="field17" class="form-group row">
                                    <div class="col-md-2">  
                                        <label for="" class="control-label">Existing Photo</label>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="../assets/uploads/<?php echo $adv_photo[4]; ?>" style="width:400px;">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" name="previous_photo" value="<?php echo $adv_photo[4]; ?>">
                            <div id="field18" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">New Photo (Recommended Width: 1170 pixels and Height: any size)</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="photo">
                                </div>
                            </div>
                            <div id="field19" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">URL</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="adv_url" class="form-control" value="<?php echo $adv_url[4]; ?>">
                                </div>
                            </div>
                            <div id="field20" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Adsense Code</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="adv_adsense_code" class="form-control" cols="30" rows="10" style="height:280px;"><?php echo $adv_adsense_code[4]; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success pull-left" name="form5">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab6primary">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Type</label>
                                </div>
                                <div class="col-md-6">
                                    <select name="adv_type" class="form-control" onchange="funcTab6(this)">
                                        <?php
                                            if ($adv_type[5] == 'Image Advertisement') {
                                                ?>
                                                <option value="Image Advertisement" selected>Image Advertisement</option>
                                                <option value="Adsense Code">Adsense Code</option>
                                                <?php
                                            } else {
                                                ?>
                                                <option value="Image Advertisement">Image Advertisement</option>
                                                <option value="Adsense Code" selected>Adsense Code</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php if ($adv_type[5] == 'Image Advertisement'): ?>
                                <div id="field21" class="form-group row">
                                    <div class="col-md-2">  
                                        <label for="" class="control-label">Existing Photo</label>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="../assets/uploads/<?php echo $adv_photo[5]; ?>" style="width:200px;">
                                    </div>
                                </div>                            
                            <?php endif; ?>
                            <input type="hidden" name="previous_photo" value="<?php echo $adv_photo[5]; ?>">
                            <div id="field22" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">New Photo (Recommended Width: 260 pixels and Height: any size)</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="photo">
                                </div>
                            </div>
                            <div id="field23" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">URL</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="adv_url" class="form-control" value="<?php echo $adv_url[5]; ?>">
                                </div>
                            </div>
                            <div id="field24" class="form-group row">
                                <div class="col-md-2">  
                                    <label for="" class="control-label">Adsense Code</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="adv_adsense_code" class="form-control" cols="30" rows="10" style="height:280px;"><?php echo $adv_adsense_code[5]; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">                                            
                                <div class="col-md-offset-2 col-md-6">
                                    <button type="submit" class="btn btn-success pull-left" name="form6">Update</button>
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

<script type="text/javascript">
    var items = [];
    for (var i = 1; i <= 24; i++) {
        items[i] = document.getElementById("field" + i);
    }

    items[1].style.display = 'block';
    items[2].style.display = 'block';
    items[3].style.display = 'block';
    items[4].style.display = 'none';

    items[5].style.display = 'block';
    items[6].style.display = 'block';
    items[7].style.display = 'block';
    items[8].style.display = 'none';

    items[9].style.display = 'block';
    items[10].style.display = 'block';
    items[11].style.display = 'block';
    items[12].style.display = 'none';

    items[13].style.display = 'block';
    items[14].style.display = 'block';
    items[15].style.display = 'block';
    items[16].style.display = 'none';

    items[17].style.display = 'block';
    items[18].style.display = 'block';
    items[19].style.display = 'block';
    items[20].style.display = 'none';

    items[21].style.display = 'block';
    items[22].style.display = 'block';
    items[23].style.display = 'block';
    items[24].style.display = 'none';

    function funcTab1(element) {
        var text = element.value;

        if (text == 'Image Advertisement') {
            items[1].style.display = 'block';
            items[2].style.display = 'block';
            items[3].style.display = 'block';
            items[4].style.display = 'none';
        } else if (text == 'Adsense Code') {
            items[1].style.display = 'none';
            items[2].style.display = 'none';
            items[3].style.display = 'none';
            items[4].style.display = 'block';
        }
    };

    function funcTab2(element) {
        var text = element.value;

        if (text == 'Image Advertisement') {
            items[5].style.display = 'block';
            items[6].style.display = 'block';
            items[7].style.display = 'block';
            items[8].style.display = 'none';
        } else if (text == 'Adsense Code') {
            items[5].style.display = 'none';
            items[6].style.display = 'none';
            items[7].style.display = 'none';
            items[8].style.display = 'block';
        }
    };

    function funcTab3(element) {
        var text = element.value;

        if (text == 'Image Advertisement') {
            items[9].style.display = 'block';
            items[10].style.display = 'block';
            items[11].style.display = 'block';
            items[12].style.display = 'none';
        } else if (text == 'Adsense Code') {
            items[9].style.display = 'none';
            items[10].style.display = 'none';
            items[11].style.display = 'none';
            items[12].style.display = 'block';
        }
    };

    function funcTab4(element) {
        var text = element.value;

        if (text == 'Image Advertisement') {
            items[13].style.display = 'block';
            items[14].style.display = 'block';
            items[15].style.display = 'block';
            items[16].style.display = 'none';
        } else if (text == 'Adsense Code') {
            items[13].style.display = 'none';
            items[14].style.display = 'none';
            items[15].style.display = 'none';
            items[16].style.display = 'block';
        }
    };

    function funcTab5(element) {
        var text = element.value;

        if (text == 'Image Advertisement') {
            items[17].style.display = 'block';
            items[18].style.display = 'block';
            items[19].style.display = 'block';
            items[20].style.display = 'none';
        } else if (text == 'Adsense Code') {
            items[17].style.display = 'none';
            items[18].style.display = 'none';
            items[19].style.display = 'none';
            items[20].style.display = 'block';
        }
    };

    function funcTab6(element) {
        var text = element.value;

        if (text == 'Image Advertisement') {
            items[21].style.display = 'block';
            items[22].style.display = 'block';
            items[23].style.display = 'block';
            items[24].style.display = 'none';
        } else if (text == 'Adsense Code') {
            items[21].style.display = 'none';
            items[22].style.display = 'none';
            items[23].style.display = 'none';
            items[24].style.display = 'block';
        }
    };
</script>