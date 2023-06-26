<?php 
session_start();
    // connection databse 
    include "../3_database/db_connection.php";

     // Initialize  and hold the variable value. 
     $check_username = null;
     $check_password = null;
     $username_error = null;
     $password_error = null;

    // check if the request is POST
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        // Get data input from front-end page 
        $check_username = $_POST['user_login_username'];
        $check_password = $_POST['user_login_password'];  

        if(!empty($check_username) && !empty($check_password)){  
            // set up database query and exeucte  
            $sql_query = "SELECT * FROM learnbetter_users WHERE user_username = '$check_username' 
                          AND user_password = '$check_password' LIMIT 1";

            // store all result in variable 
            $query_result = $conn->query($sql_query);

            // if result query have value , proceed fetch data
            if ($query_result->num_rows > 0) {
                
                $row = $query_result->fetch_assoc();
                
                if($check_password === $row['user_password'] && $check_username === $row['user_username'] ){
                    
                    // identifier 
                    $_SESSION["admin_id"]     = $row['id']; 
                    
                    // start session 
                    $_SESSION["admin_name"]   = $row['user_username'];
                    $_SESSION["admin_pass"]   = $row['user_password'];
                    
                    $_SESSION["admin_firstN"] = $row['user_firstname'];
                    $_SESSION["admin_lastN"]  = $row['user_lastname'];
                    $_SESSION["admin_gen"]    = $row['user_gender'];
                    $_SESSION["admin_mail"]   = $row['user_email'];
                    $_SESSION["admin_level"]  = $row['user_prio'];
                    $_SESSION["admin_img"]    = $row['user_upload_img'];
                    /* 
                    Direct user to it's specific page base database "user priority" number
                    ( Admin -> 0 )
                    */

                    if ($row['user_prio'] != 0 ){
                        echo'<script> alert("Only Admin able to log in"); </script>';
                        return;

                    }elseif($row['user_prio'] == 0){  
                        header("Location: ../1_front_end/learnbetter_A1_home_page.php");
                    }
                }      
            } else {
                // return   
                echo '<script> alert("No Username is found , echo from login_validation.php"); </script>';
            }
        }else{
            // Show validation going here
            if(empty(trim($check_username))){
                $username_error = "Username Field is empty";
            }else{
                if(empty(trim($check_password))){
                     $password_error = "Password Field is empty";
                }
            }
        }
    }
?>  



