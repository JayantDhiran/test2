<?php 
require_once("./database/dbconn.php");

$page = "delete_company";

$db = new Database();

if(isset($_GET['Company_Name'])){

    $crs_token = htmlentities($_GET['Company_Name']);

        if($db->select('company','Company_Logo',null,"Company_Name='$crs_token'")){
            $crs_img = $db->getResult();
            $img_nm = "./images/courses/".$crs_img['0']['Company_Logo'];   
            if(unlink($img_nm)){
                if($db->delete('company',"Company_Name='$crs_token'")){
                    $msg = "Company Deleted Successfully";
                }else{
                    $err = "Error Deleting Company";
                }
            }
        }else{
            $err = "Error in Deleting Company";
        }  
        echo "<script>location.href='courses.php'</script>";
    }else{
        $err = "Error in Deleting Data";
    }

?>