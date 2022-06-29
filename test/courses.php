<?php 

require_once("./database/dbconn.php");

$page = "Company";
$db = new Database();

$db->select('company','Company_Name,Description,Contact_Number,Email_address,Company_price,Company_Logo,Token',null);
  


$em=$db->getResult();
$crs_cnt = count($em);
if($crs_cnt == 0){
    $no_data = "No Data";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="./css/instructorPanel.css">
</head>
<body>
    <?php include_once('./inc/instHeader.php') ?>

    <div class="inst_ss">  
        <?php include_once('sidebar.php') ?>

        <div class="dash">
    <div class="crs_h"> Filter  <div >
    <form>
    <label for="dog-names">Choose order:</label>
<select name="sort" id="sort">
    <option value="Low to High">Low to High</option>
  <option value="High to Low">High to Low</option>
</select>
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <?php
  
  ?>
</div>
                <?php  $i=0; while($i< $crs_cnt){ ?>
                <div class="course_sec">
                    <img src="./images/courses/<?php if(isset($em[$i]['Company_Logo'])){echo $em[$i]['Company_Logo'];}?>" class="crs_img">
                    <div class="crs_name"><?php if(isset($em[$i]['Company_Name'])){echo $em[$i]['Company_Name'];}?></div>
                    <div class="crs_name"><?php if(isset($em[$i]['Description'])){echo $em[$i]['Description'];}?></div>
                    <div class="crs_name"><?php if(isset($em[$i]['Contact_Number'])){echo $em[$i]['Contact_Number'];}?></div>
                    <div class="crs_name"><?php if(isset($em[$i]['Email_address'])){echo $em[$i]['Email_address'];}?></div>
                    <div class="crs_name"><?php if(isset($em[$i]['Company_Price'])){echo $em[$i]['Company_Price'];}?></div>
                    <a href="create_courses.php?Company_Name=<?php if(isset($em[$i]['Company_Name'])){echo $em[$i]['Company_Name'];}?>" class="crs_edit">Edit Company</a>
                    <a href="delete_courses.php?Company_Name=<?php if(isset($em[$i]['Company_Name'])){echo $em[$i]['Company_Name'];}?>" class="crs_delete">Delete Company</a>
                </div>
                <?php $i++; }  if(isset($no_data)){echo "<span class='nodata'>$no_data</span>";}?>
            </div>

        </div>

    </div>

    <script src="./javascript/jquery.js"></script>
    <script src="./javascript/all.js"></script>
    <script src="./javascript/instructorPanel.js"></script>
</body>
</html>
