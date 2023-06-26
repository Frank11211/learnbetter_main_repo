<?php 
    // include databse 
    include "../3_database/db_connection.php";

    // First initialize variable , Error handling
    $upt_train_code         = null;
    $upt_train_name         = null;
    $upt_train_trainee_asig = null;
    $upt_train_pin          = null;

    // Time variable
    $upt_train_hours        = null;
    $upt_train_minute       = null;
    $upt_train_total_minutes= null;


    // Check if the post is submit as post 
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Get user input 
        $upt_train_code         = $_POST['training_code_A1'];
        $upt_train_name         = $_POST['training_name_A1'];
        $upt_train_trainee_asig = $_POST['training_trainee_assign_A1'];  
        $upt_train_pin          = $_POST['training_pin_A1'];
    
        // Retrieve the duration values from the form  
        $upt_train_hours        = $_POST['training_hours'];
        $upt_train_minute       = $_POST['training_minute'];
        $upt_train_date         = $_POST['training_date_time'];

        // First Initial variable for store SQL with string concatinate  
        $sql_query = null;
        $sql_final_query = null ;

        // training Information 
        if($upt_train_code  != $_SESSION["edit_train_code"]){
            $sql_query .= "course_code = '".$upt_train_code ."', ";
            $_SESSION['edit_train_code'] = $upt_train_code ; 
        }

        if($upt_train_name  != $_SESSION["edit_train_name"]){
            $sql_query .= "course_name = '".$upt_train_name ."', ";
            $_SESSION['edit_train_name'] = $upt_train_name ; 
        }

        if($upt_train_pin  != $_SESSION["edit_train_course_pin"]){
            $sql_query .= "course_pin = '".$upt_train_pin ."', ";
            $_SESSION['edit_train_course_pin'] = $upt_train_pin ; 
        }

        if($upt_train_trainee_asig  != $_SESSION["edit_train_trainee_asig"]){
            $sql_query .= "course_assign = '".$upt_train_trainee_asig ."', ";
            $_SESSION['edit_train_trainee_asig'] = $upt_train_trainee_asig ; 
        }
        
        if($upt_train_date  != $_SESSION["edit_train_date_time"]){
            $sql_query .= "course_date_begin = '".$upt_train_date ."', ";
            $_SESSION['edit_train_date_time'] = $upt_train_date ; 
        }

        // Time management and convert into minutes

        if(($upt_train_hours  != $_SESSION["edit_train_hour"]) || ($upt_train_minute  != $_SESSION["edit_train_min"])){
            
            $upt_train_total_minutes = ($upt_train_hours * 60) + $upt_train_minute;

            $sql_query .= "course_time_duration = '".$upt_train_total_minutes ."', ";
        
            $_SESSION['edit_train_hour'] = $upt_train_hours ; 
            $_SESSION['edit_train_min'] = $upt_train_minute ; 
        }
        

        // Check if there are any changes to update
        if (!empty($sql_query)) {

            // Check if it is admin level 
            if(isset($_SESSION["admin_level"])){
                // Remove the trailing comma
                $sql_query = rtrim($sql_query, ", ");

                $query_build = "UPDATE learnbetter_courses SET ".$sql_query." WHERE id = '".$_SESSION['edit_train_course_id']."'";

                $sql_query_result = $conn->query($query_build);
                
                echo '<script>
                    alert("Training information have update");
                    window.location.href = "../1_front_end/learnbetter_A1_training_mng_page.php"; 
                    </script>'; 
            }

        }
    }
?>
