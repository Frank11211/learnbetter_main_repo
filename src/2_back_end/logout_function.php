<?php 
   
    session_start();
    
   if(isset($_GET["log_lv"])){
        $check_user_level = $_GET["log_lv"];

        if($check_user_level =="0"){
            if(isset($_SESSION["admin_level"])){
            
                unset($_SESSION["admin_firstN"]);
                unset($_SESSION["admin_lastN"]);
                unset($_SESSION["admin_email"]);
                unset($_SESSION["admin_gen"]);
                unset($_SESSION["admin_name"]);
                unset($_SESSION["admin_pass"]);
                unset($_SESSION["admin_level"]);
                unset($_SESSION["admin_id"]);

                echo '<script>
                    alert("Admin logout successfully ");
                    window.location.href = "../1_front_end/learnbetter_A1_login_page.php"; 
                </script>';

            }
        }

        if($check_user_level =="1"){
           
            if(isset($_SESSION["trainee_level"])){

                unset($_SESSION["trainee_firstN"]);
                unset($_SESSION["trainee_lastN"]);
                unset($_SESSION["trainee_email"]);
                unset($_SESSION["trainee_gen"]);
                unset($_SESSION["trainee_name"]);
                unset($_SESSION["trainee_pass"]);
                unset($_SESSION["trainee_level"]);
                unset($_SESSION["trainee_id"]);

                echo '<script>
                    alert("Trainer logout succesfully");
                    window.location.href = "../1_front_end/learnbetter_login_page.php"; 
                </script>';      

            }
        }

        if($check_user_level =="2"){
           
            if(isset($_SESSION["user_level"])){

                unset($_SESSION["user_firstN"]);
                unset($_SESSION["user_lastN"]);
                unset($_SESSION["user_email"]);
                unset($_SESSION["user_gen"]);
                unset($_SESSION["user_name"]);
                unset($_SESSION["user_pass"]);
                unset($_SESSION["user_level"]);
                unset($_SESSION["user_id"]);

                echo '<script>
                    alert("Candidate logout succesfully");
                    window.location.href = "../1_front_end/learnbetter_login_page.php"; 
                </script>';        

            }
        }
    }
 
?>
