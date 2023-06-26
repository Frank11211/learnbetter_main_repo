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
                    
             
                    if($row['user_prio'] == 1){
                        // identifier 
                        $_SESSION["trainee_id"]     = $row['id']; 
                        
                        // start session 
                        $_SESSION["trainee_name"]   = $row['user_username'];
                        $_SESSION["trainee_pass"]   = $row['user_password'];
                        
                        $_SESSION["trainee_firstN"] = $row['user_firstname'];
                        $_SESSION["trainee_lastN"]  = $row['user_lastname'];
                        $_SESSION["trainee_gen"]    = $row['user_gender'];
                        $_SESSION["trainee_mail"]   = $row['user_email'];
                        $_SESSION["trainee_level"]  = $row['user_prio'];
                        $_SESSION["trainee_img"]    = $row['user_upload_img'];
                     
                        
                        // Direct to trainee homepage 
                        header("Location: ../1_front_end/learnbetter_B2_home_page.php");                      

                    }elseif($row['user_prio'] == 2){
                        // identifier 
                        $_SESSION["user_id"]     = $row['id']; 
                        
                        // start session 
                        $_SESSION["user_name"]   = $row['user_username'];
                        $_SESSION["user_pass"]   = $row['user_password'];
                        
                        $_SESSION["user_firstN"] = $row['user_firstname'];
                        $_SESSION["user_lastN"]  = $row['user_lastname'];
                        $_SESSION["user_gen"]    = $row['user_gender'];
                        $_SESSION["user_mail"]   = $row['user_email'];
                        $_SESSION["user_level"]  = $row['user_prio'];
                        $_SESSION["user_img"]    = $row['user_upload_img'];
                     
                        // Direct to candidate homepage 
                        header("Location: ../1_front_end/learnbetter_C3_home_page.php");
                        
                    }elseif($row['user_prio'] != 1 || $row['user_prio'] != 2){
                        // Direct admin to log in page.
                        echo '<script>
                                alert("Please log in admin account in admin panel");
                            </script>';
                        return ;
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



