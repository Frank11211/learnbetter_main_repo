<?php 
    // include databse 
    include "../3_database/db_connection.php";

    // First initialize variable , Error handling
    $acc_A1_firstN  = null;
    $acc_A1_lastN   = null;
    $acc_A1_username = null;
    $acc_A1_email   = null;
    $acc_A1_new_pass = null;
    $acc_A1_retype_pass = null;
    $check_user_access = null;

    // Img identifier
    $acc_A1_image_temp = null;
    $fileContent = null; 

    /*
    TODO 
    - Require to check access first 
        - Can resequence the code, start from the SQL , post only 1 time will do 
    */ 

    // Check if the post is submit as post 
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Get user input 
        $acc_A1_firstN  = $_POST['upd_acc_firstN_A1'];
        $acc_A1_lastN   = $_POST['upd_acc_lastN_A1'];
        $acc_A1_username= $_POST['upd_acc_username_A1'];
        $acc_A1_email   = $_POST['upd_acc_mail_A1'];

        // Password Section
        $acc_A1_new_pass    = $_POST['upd_acc_new_pass_A1'];
        $acc_A1_retype_pass = $_POST['upd_acc_retype_pass_A1'];
       
        // User priority (Admin / Trainee / Candidate)
        $check_user_access = $_POST['user_access_level'];

        // Get User Image
        $acc_A1_img_tmp  = $_FILES['upd_uploaded_image']['tmp_name'];

        if (!empty($acc_A1_img_tmp)) {
            // Read the file content
            $fileContent = file_get_contents($acc_A1_img_tmp);
        } else {
            switch ($check_user_access) {
                case "0":
                    // Set $fileContent to the existing image content for admin
                    $fileContent = $_SESSION['admin_img'];
                    break;
                case "1":
                    // Set $fileContent to the existing image content for trainee
                    $fileContent = $_SESSION['trainee_img'];
                    break;
                case "2":
                    // Set $fileContent to the existing image content for candidate
                    $fileContent = $_SESSION['user_img'];
                    break;
                default:
                    // Handle the case when $check_user_access does not match any user level
                    // Set $fileContent to a default image or appropriate error handling
                    break;
            }
        }

        // First Initial variable for store SQL with string concatinate  
        $sql_query = null;
        $sql_final_query = null ;

        // Check if there are any changes to update

        // check account is admin  
        if($check_user_access == "0"){
            

            // User Information 
            if($acc_A1_firstN != $_SESSION["admin_firstN"]){
                $sql_query .= "user_firstname = '".$acc_A1_firstN."', ";
                $_SESSION['admin_firstN'] = $acc_A1_firstN; 
            }

            if($acc_A1_lastN != $_SESSION["admin_lastN"]){
                $sql_query .= "user_lastname = '".$acc_A1_lastN."', ";
                $_SESSION['admin_lastN'] = $acc_A1_lastN;
            }
            
            if($acc_A1_username !=  $_SESSION["admin_name"]){
                $sql_query .= "user_username = '".$acc_A1_username."', ";
                $_SESSION['admin_name'] = $acc_A1_username; 
            }

            if($acc_A1_email != $_SESSION["admin_mail"]){
                $sql_query .= "user_email = '".$acc_A1_email."', ";
                $_SESSION['admin_mail'] = $acc_A1_email;
            }

            // TODO - Require to put inside Image
            if ($fileContent !== $_SESSION["admin_img"]) {
                $sql_query .= "user_upload_img = '" . addslashes($fileContent) . "', ";
                $_SESSION['admin_img'] = $fileContent;
            }

            // Check password
            if(!empty($acc_A1_new_pass) && !empty($acc_A1_retype_pass)){
                if($acc_A1_new_pass == $acc_A1_retype_pass){
                    $sql_query .= "user_password = '".$acc_A1_new_pass."', ";
                    $_SESSION['admin_pass'] = $acc_A1_new_pass;  
                }else{
                    //  Bad Error Handling 
                    echo '<script>
                    alert("Password is not sync, try again");
                    window.location.href = "../1_front_end/learnbetter_A1_account_page.php"; 
                    </script>'; 
                }
            }

            if (!empty($sql_query)) {

                if(isset($_SESSION["admin_level"])){
                    // Remove the trailing comma
                    $sql_query = rtrim($sql_query, ", ");

                    $query_build = "UPDATE learnbetter_users SET ".$sql_query." WHERE id = '".$_SESSION['admin_id']."'";

                    $sql_query_result = $conn->query($query_build);
                    
                    echo '<script>
                        alert("Admin account information have update");
                        window.location.href = "../1_front_end/learnbetter_A1_account_page.php"; 
                        </script>'; 
                }
            }

            // check account is trainee
        }elseif($check_user_access == "1"){

             // User Information 
             if($acc_A1_firstN != $_SESSION["trainee_firstN"]){
                $sql_query .= "user_firstname = '".$acc_A1_firstN."', ";
                $_SESSION['trainee_firstN'] = $acc_A1_firstN; 
            }

            if($acc_A1_lastN != $_SESSION["trainee_lastN"]){
                $sql_query .= "user_lastname = '".$acc_A1_lastN."', ";
                $_SESSION['trainee_lastN'] = $acc_A1_lastN;
            }
            
            if($acc_A1_username !=  $_SESSION["trainee_name"]){
                $sql_query .= "user_username = '".$acc_A1_username."', ";
                $_SESSION['trainee_name'] = $acc_A1_username; 
            }

            if($acc_A1_email != $_SESSION["trainee_mail"]){
                $sql_query .= "user_email = '".$acc_A1_email."', ";
                $_SESSION['trainee_mail'] = $acc_A1_email;
            }

            // TODO - Require to put inside Image
            if ($fileContent !== $_SESSION["trainee_img"]) {
                $sql_query .= "user_upload_img = '" . addslashes($fileContent) . "', ";
                $_SESSION['trainee_img'] = $fileContent;
            }

            // Check password
            if(!empty($acc_A1_new_pass) && !empty($acc_A1_retype_pass)){
                if($acc_A1_new_pass == $acc_A1_retype_pass){
                    $sql_query .= "user_password = '".$acc_A1_new_pass."', ";
                    $_SESSION['trainee_pass'] = $acc_A1_new_pass;  
                }else{
                    //  Bad Error Handling 
                    echo '<script>
                    alert("Password is not sync, try again");
                    window.location.href = "../1_front_end/learnbetter_B2_account_page.php"; 
                    </script>'; 
                }
            }

            if (!empty($sql_query)) {

                if(isset($_SESSION["trainee_level"])){
                    // Remove the trailing comma
                    $sql_query = rtrim($sql_query, ", ");

                    $query_build = "UPDATE learnbetter_users SET ".$sql_query." WHERE id = '".$_SESSION['trainee_id']."'";

                    $sql_query_result = $conn->query($query_build);
                    
                    echo '<script>
                        alert("Trainee account information have update");
                        window.location.href = "../1_front_end/learnbetter_B2_account_page.php"; 
                        </script>'; 
                }
            }
            
            // check account is candidate
        }elseif($check_user_access == "2"){

            // User Information 
            if($acc_A1_firstN != $_SESSION["user_firstN"]){
                $sql_query .= "user_firstname = '".$acc_A1_firstN."', ";
                $_SESSION['user_firstN'] = $acc_A1_firstN; 
            }

            if($acc_A1_lastN != $_SESSION["user_lastN"]){
                $sql_query .= "user_lastname = '".$acc_A1_lastN."', ";
                $_SESSION['user_lastN'] = $acc_A1_lastN;
            }
            
            if($acc_A1_username !=  $_SESSION["user_name"]){
                $sql_query .= "user_username = '".$acc_A1_username."', ";
                $_SESSION['user_name'] = $acc_A1_username; 
            }

            if($acc_A1_email != $_SESSION["user_mail"]){
                $sql_query .= "user_email = '".$acc_A1_email."', ";
                $_SESSION['user_mail'] = $acc_A1_email;
            }

            // TODO - Require to put inside Image
            if ($fileContent !== $_SESSION["user_img"]) {
                $sql_query .= "user_upload_img = '" . addslashes($fileContent) . "', ";
                $_SESSION['user_img'] = $fileContent;
            }

            // Check password
            if(!empty($acc_A1_new_pass) && !empty($acc_A1_retype_pass)){
                if($acc_A1_new_pass == $acc_A1_retype_pass){
                    $sql_query .= "user_password = '".$acc_A1_new_pass."', ";
                    $_SESSION['user_pass'] = $acc_A1_new_pass;  
                }else{
                    //  Bad Error Handling 
                    echo '<script>
                    alert("Password is not sync, try again");
                    window.location.href = "../1_front_end/learnbetter_C3_account_page.php"; 
                    </script>'; 
                }
            }

            if (!empty($sql_query)) {
                if(isset($_SESSION["user_level"])){
                    // Remove the trailing comma
                    $sql_query = rtrim($sql_query, ", ");

                    $query_build = "UPDATE learnbetter_users SET ".$sql_query." WHERE id = '".$_SESSION['user_id']."'";

                    $sql_query_result = $conn->query($query_build);
                    
                    echo '<script>
                        alert("Candidate account information have update");
                        window.location.href = "../1_front_end/learnbetter_C3_account_page.php"; 
                        </script>'; 
                }
            }
        }  
    }
?>