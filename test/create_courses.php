<?php 
require_once("./database/dbconn.php");
$page = "create_courses";
$db = new Database();

if(isset($_POST['submit'])){
    if(($_POST['inst_crs_name'] == "") ||  ($_POST['inst_crs_desc'] == "")  || ($_POST['inst_crs_art'] == "") || ($_POST['inst_crs_dnr'] == "")|| ($_POST['inst_crs_prc'] == "") || ($_FILES['crs_img']['name'] == "")){
        $err = "Please Fill All The Fields!";
    }else{
        $crs_name = htmlentities($_POST['inst_crs_name']);
        // $crs_cc = htmlentities($_FILES['inst_crs_cc']['name']);
        $crs_desc = htmlentities($_POST['inst_crs_desc']);
        $crs_art = htmlentities($_POST['inst_crs_art']);
        $crs_dnr = htmlentities($_POST['inst_crs_dnr']);
        $crs_prc = htmlentities($_POST['inst_crs_prc']);
        $crs_token = bin2hex(random_bytes(5));

        $tmp_nm = $_FILES["crs_img"]["tmp_name"];
        $dest_nm = "./images/courses/";
        $file_nm = $_FILES['crs_img']['name'];
        $file_type=$_FILES['crs_img']['type'];
        $file_sz=$_FILES['crs_img']['size'];
        $file_exp = explode('.',$file_nm);
        $file_ext=strtolower(end($file_exp));
        
        $extensions= array("jpeg","jpg","png","gif");
        
        if(in_array($file_ext,$extensions)=== false){
            $err="extension not allowed, please choose a JPEG or PNG file.";
        }
        if($file_sz > 2097152){
            $err='File size must be excately 2 MB';
        }

        $img_nm = uniqid().$file_nm;
        $img_dest=$dest_nm.$img_nm;



        if(!empty($_FILES["tmp_name"])){
            $tmpcc_nm = $_FILES["tmp_name"];
            $destcc_nm = "./subtitles/";
            $filecc_nm = $_FILES['name'];
            $filecc_sz=$_FILES['size'];
            

            if($file_sz > 2097152){
                $err='File size must be excately 2 MB';
            }

            $cc_nm = uniqid().$filecc_nm;
            $cc_dest=$destcc_nm.$cc_nm;

            if(empty($err)==true){
                if(move_uploaded_file($tmp_nm,$img_dest) && move_uploaded_file($tmpcc_nm,$cc_dest)){
                    if($db->insert('company',['Company_Name'=>$crs_name,'Description'=>$crs_desc,'Contact_Number'=>$crs_art,'Email_address'=>$crs_dnr,'Company_price'=>$crs_prc,'Company_Logo'=>$img_nm,'Token'=>$crs_token])){
                        $msg="Company Created";
                    }else{
                        $err = "Unable to Create Course!";
                    }
                }else{
                    $err = "Unable to Create Course!";
                }
            }else{
                $err = $err;
             }
        }else{
            if(empty($err)==true){
                if(move_uploaded_file($tmp_nm,$img_dest)){
                    if($db->insert('company',['Company_Name'=>$crs_name,'Description'=>$crs_desc,'Contact_Number'=>$crs_art,'Email_address'=>$crs_dnr,'Company_price'=>$crs_prc,'Company_Logo'=>$img_nm,'Token'=>$crs_token])){
                        $msg="Course Created";
                    }else{
                        $err = "Unable to Create Course!";
                    }
                }else{
                    $err = "Unable to Create Course!";
                }
            }else{
                $err = $err;
             }
        }      
    }
}

if(isset($_GET['Company_name'])){

    $crs_token = htmlentities($_GET['Company_name']);

    $db->select('company','Company_Name,Description,Contact_Number,Email_address,Company_price,Company_Logo',null,"crs_token='$crs_token'");

    $res = $db->getResult();
    $cnt_res = count($res);

    if($cnt_res > 0){
        $crs_nme = $res[0]['Company_Name'];
        $crs_descl = $res[0]['Description'];
        $crs_artl = $res[0]['Contact_Number'];
        $crs_dnrl = $res[0]['Email_address'];
        $crs_prcl = $res[0]['Companny_price'];
        $crs_img = $res[0]['Company_Logo'];
    } 

    if(isset($_POST['update'])){
        if(($_POST['inst_crs_name'] == "") || ($_POST['inst_crs_desc'] == "")|| ($_POST['inst_crs_art'] == "") || ($_POST['inst_crs_dnr'] == "")|| ($_POST['inst_crs_prc'] == "")){
            $err = "Please Fill All The Fields!";
        }else{
            $crs_name = htmlentities($_POST['inst_crs_name']);
            $crs_desc = htmlentities($_POST['inst_crs_desc']);
            $crs_art = htmlentities($_POST['inst_crs_art']);
            $crs_dnr = htmlentities($_POST['inst_crs_dnr']);
            $crs_prc = htmlentities($_POST['inst_crs_prc']);
            if(($_FILES['crs_img']['name'] == "")){
                if($db->update('company',['Company_Name'=>$crs_name,'Description'=>$crs_desc,'Contact_Number'=>$crs_art,'Email_address'=>$crs_dnr,'Company_price'=>$crs_prc,'Company_Logo'=>$img_nm,'crs_token'=>$crs_token])){
                    $msg = "Succesfully Updated Data";
                }else{
                    $err = "Error Updating Data";
                }
            }elseif(($_FILES['crs_img']['name'] == "")){
                $tmpcc_nm = $_FILES["inst_crs_cc"]["tmp_name"];
                $destcc_nm = "./subtitles/";
                $filecc_nm = $_FILES['inst_crs_cc']['name'];
                $filecc_sz=$_FILES['inst_crs_cc']['size'];

                if($file_sz > 2097152){
                    $err='File size must be excately 2 MB';
                }

                $cc_nm = uniqid().$filecc_nm;
                $cc_dest=$destcc_nm.$cc_nm;

                if(move_uploaded_file($tmpcc_nm,$cc_dest)){
                    $unlink = $destcc_nm.$crs_ccl;
                    try{
                        unlink($unlink);
                    }catch(Exception $e){
                        $err = "Unable to process action!";
                    }
                    if($db->update('company',['Company_Name'=>$crs_name,'Description'=>$crs_desc,'Contact_Number'=>$crs_art,'Email_address'=>$crs_dnr,'Company_price'=>$crs_prc,'Company_Logo'=>$img_nm,'Token'=>$crs_token])){
                    $msg = "Succesfully Updated Data";
                    }
                    else{
                        $err = "Error Updating Data";
                    }
                }
                else{
                    $err = "Error Uploading Image!";
                }

            }elseif(($_FILES['inst_crs_cc']['name'] == "")){
                
                $tmp_nm = $_FILES["crs_img"]["tmp_name"];
                $dest_nm = "./images/courses/";
                $file_nm = $_FILES['crs_img']['name'];
                $file_type=$_FILES['crs_img']['type'];
                $file_sz=$_FILES['crs_img']['size'];
                $file_exp = explode('.',$file_nm);
                $file_ext=strtolower(end($file_exp));
                
                $extensions= array("jpeg","jpg","png","gif");
                
                if(in_array($file_ext,$extensions)=== false){
                    $err="extension not allowed, please choose a JPEG or PNG file.";
                }
                if($file_sz > 2097152){
                    $err='File size must be excately 2 MB';
                }

                $img_nm = uniqid().$file_nm;
                $img_dest=$dest_nm.$img_nm;

                if(move_uploaded_file($tmp_nm,$img_dest)){
                    $unlink = $dest_nm.$crs_img;
                    try{
                        unlink($unlink);
                    }catch(Exception $e){
                        $err = "Unable to process action!";
                    }
                    if($db->update('company',['Company_Name'=>$crs_name,'Description'=>$crs_desc,'Contact_Number'=>$crs_art,'Email_address'=>$crs_dnr,'Company_price'=>$crs_prc,'Company_Logo'=>$img_nm,'Token'=>$crs_token])){
                        $msg = "Succesfully Updated Data";
                    }else{
                        $err = "Error Updating Data";
                    }
                }else{
                    $err = "Error Updating Image";
                }
            }else{
                $err = "Error Updating Data!";
            }
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="./css/instructorPanel.css">
</head>
<body>
    <?php include_once('./inc/instHeader.php') ?>

    <div class="inst_ss">  
        <?php include_once('sidebar.php') ?>

        <div class="dash">

            <!-- Section 1 Start  -->

            <div class="inst_crs_sec1">
                <div class="inst_crs_sec1_ttl">Company Details</div>
                <div class="inst_crs_sec1_bdy">
                    <form action="" method="POST" enctype="multipart/form-data">

                        <!-- Course Banner Section Start  -->

                        <div class="inst_crs">
                            <label for="inst_crs_name" class="inst_crs_det_lbl">Company_Name</label>
                            <input class="inst_crs_inpt" type="text" name="inst_crs_name" id="inst_crs_name" value="<?php if(isset($crs_nme)){ echo $crs_nme; } ?>">
                        </div>
                        
                        <br>
                        <div class="inst_crs">
                            <label for="inst_crs_desc" class="inst_crs_det_lbl">Description</label>
                            <textarea class="inst_crs_inpt" name="inst_crs_desc" id="inst_crs_desc"><?php if(isset($crs_descl)){ echo $crs_descl;} ?></textarea>
                        </div>

                        <!-- Course Desc Section End  -->

                        <!-- Course Details Section Start  -->

                            <div class="inst_details_Sec">
                                <label for="inst_crs_art" class="inst_crs_det_lbl">Email Address</label>
                                <input type="text" class="inst_crs_inpt_det" name="inst_crs_art" id="inst_crs_art" value="<?php if(isset($crs_artl)){ echo $crs_artl;} ?>">
                            </div>
                            <br>
                            <div class="inst_details_Sec">
                                <label for="inst_crs_dnr" class="inst_crs_det_lbl">Contact Number</label>
                                <input type="text" class="inst_crs_inpt_det" name="inst_crs_dnr" id="inst_crs_dnr0" value="<?php if(isset($crs_dnrl)){ echo $crs_dnrl;} ?>">
                            </div>
                        </div>
                        <div class="inst_crs_det">
                            <div class="inst_details_Sec">
                                <label for="inst_crs_prc" class="inst_crs_det_lbl">Company Price</label>
                                <input type="text" class="inst_crs_inpt" name="inst_crs_prc" id="inst_crs_prc" value="<?php if(isset($crs_prcl)){ echo $crs_prcl;} ?>">
                            </div>

                        <!-- Course Details Section End  -->

                        <!-- Course Image Section End  -->
                        <div class="inst_crs_det">
                            <div class="inst_details_Sec">
                                <label for="inst_crs_art" class="inst_crs_det_lbl">Course Image</label>
                                <input type="file" name="crs_img" id="crs_img">
                            </div>
                        </div>
                        <!-- Course Image Section End  -->
                        <?php if(isset($msg)){ ?>
                        <div class="msg">
                            <span><?php echo $msg; ?></span>
                        </div>
                        <?php } ?>
                        <?php if(isset($err)){ ?>
                        <div class="err">
                            <span><?php echo $err; ?></span>
                        </div>
                        <?php } ?>
                        <!-- Course Buttons Section Start  -->

                        <div class="inst_crs_btn">
                            <button type="rest" class="inst_crs_rst_btn inst_crs_btns" id="inst_crs_rst_btn">Reset</button>
                            <?php if(isset($_GET['crs_id'])){ ?>
                                <input type="submit" value="Update" name="update" class="inst_crs_crt_btn inst_crs_btns" id="inst_crs_crt_btn">
                            <?php }else{ ?>
                            <input type="submit" value="Create" name="submit" class="inst_crs_crt_btn inst_crs_btns" id="inst_crs_crt_btn">
                            <?php } ?>
                        </div>
                        <!-- Course Buttons Section End  -->
                    </form>
                </div>
            </div>

            <!-- Section 1 End  -->

        </div>

    </div>


<script src="./javascript/jquery.js"></script>
<script src="./javascript/all.js"></script>
<script src="./javascript/instructorPanel.js"></script>
</body>
</html>