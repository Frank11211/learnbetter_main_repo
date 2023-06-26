<?php 
  // connection databse 
  include "../3_database/db_connection.php";

  date_default_timezone_set("Asia/Kuala_Lumpur");

  // First iitialize variable, scope problem
  $error_train_code         = null;
  $error_train_name         = null;
  $error_train_trainee_asig = null;
  $error_train_vacant       = null;
  $error_train_pin          = null;


  // store user previous value 
  $train_code         = null;
  $train_name         = null;
  $train_trainee_asig = null;
  $train_vacant       = null;
  $train_pin          = null;

  // Time management 
  $train_hours        = null;
  $train_minute       = null;
  $train_total_minutes= null;

  
  // check if the request is POST
  if($_SERVER["REQUEST_METHOD"] == "POST"){

    // gather user input from file "learnbetter_users.php"
    $train_code         = $_POST['training_code_A1'];
    $train_name         = $_POST['training_name_A1'];
    $train_trainee_asig = $_POST['training_trainee_assign_A1'];  
    $train_pin          = $_POST['training_pin_A1'];

    // Retrieve the duration values from the form  
    $train_hours        = $_POST['training_hours'];
    $train_minute       = $_POST['training_minute'];
    $train_date         = $_POST['training_date_time'];


    // Course Begin Date, Calculate the total duration in minutes
    $train_total_minutes = ($train_hours* 60) + $train_minute;
    
    // Admin Register Date
    $train_reg_date     = date("Y-m-d H:i:s");

    if(!empty($train_code) && !empty($train_name) && !empty($train_trainee_asig) && !empty($train_total_minutes) && !empty($train_pin) && !empty($train_date) && !empty($train_reg_date)){  
      // Set up database query and exeucte  

      $sql_query =  "INSERT INTO learnbetter_courses (course_code, course_name, course_assign, course_time_duration, course_pin, course_date_begin, reg_date_time) 
                      VALUES ('$train_code', '$train_name', '$train_trainee_asig', '$train_total_minutes', '$train_pin', '$train_date', '$train_reg_date ')";

      $sql_result = $conn->query($sql_query);    

      // Check if the first query was successful
      if ($sql_result) {
          
        // if first query executed successfully , update trainee_course value by 1 base admin select
        $second_sql_query = "UPDATE `learnbetter_users`
                            SET `learnbetter_users`.`trainee_course` = `learnbetter_users`.`trainee_course` + 1
                            WHERE `learnbetter_users`.`id` = $train_trainee_asig";

        $second_sql_result = $conn->query($second_sql_query);

        // Check if the second query was successful
        if ($second_sql_result) {
              echo '<script>
                    alert("Course have created ,Email successfully send to Trainee");
                    window.location.href = "../1_front_end/learnbetter_A1_training_mng_page.php"; 
                    </script>';
      
      // Output databsae error 
        } else {
            // Second query execution failed
            echo "Second query execution failed: " . $conn->error;
        }
      } else {
        // First query execution failed
        echo "First query execution failed: " . $conn->error;
      }


    }else{
      // Register Error Handling 

      if(empty(trim($reg_firstname))){
        $error_msg_firstname  = "Firstname is missing";
      }else{
        $error_msg_firstname  = null;
      };
        
      if(empty(trim($reg_lastname))){
        $error_msg_lastname  = "Lastname is missing";
      }else{
        $error_msg_lastname  = null;
      };

      if($reg_gender === "Unknown"){
        $error_msg_gender = "Gender is missing";
      }

      if(empty(trim($reg_email))){
        $error_msg_email = "Email is missing";
      }else{
        $error_msg_email = null;
      };

      if(empty(trim($reg_username))){
        $error_msg_username = "Username is missing";
      }else{
        $error_msg_username = null;
      };

      if(empty(trim($reg_password))){
        $error_msg_password  = "Password is missing";
      }else{
        $error_msg_password = null;
      };
    }
  }
?>  



