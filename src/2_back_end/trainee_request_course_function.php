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
  $train_pin          = null;

  // Time management 
  $train_hours        = null;
  $train_minute       = null;
  $train_total_minutes= null;

  
  // check if the request is POST
  if($_SERVER["REQUEST_METHOD"] == "POST"){

    // gather user input from file "learnbetter_users.php"
    $train_code         = $_POST['request_code'];
    $train_name         = $_POST['request_name'];
    $train_trainee_asig = $_POST['request_trainee_id'];  
    $train_pin          = $_POST['request_pin'];

    // Retrieve the duration values from the form  
    $train_hours        = $_POST['request_hours'];
    $train_minute       = $_POST['request_minute'];
    $train_date         = $_POST['request_date_time'];


    // Course Begin Date, Calculate the total duration in minutes
    $train_total_minutes = ($train_hours* 60) + $train_minute;
    
    // Admin Register Date
    $train_reg_date     = date("Y-m-d H:i:s");

    if(!empty($train_code) && !empty($train_name) && !empty($train_trainee_asig) && !empty($train_total_minutes) && !empty($train_pin) && !empty($train_date) && !empty($train_reg_date)){  
      // Set up database query and exeucte  

      $sql_query =  "INSERT INTO learnbetter_request (req_course_code, req_course_name, req_course_trainee, req_course_time, req_course_pin, req_course_begin_date_time ,req_course_date) 
                      VALUES ('$train_code', '$train_name', '$train_trainee_asig', '$train_total_minutes', '$train_pin', '$train_date', '$train_reg_date ')";

      $sql_result = $conn->query($sql_query);    

      // Check if the first query was successful
      if ($sql_result) {

        echo '<script>
            alert("Request have been submited to Admin ");
            window.location.href = "../1_front_end/learnbetter_B2_request_course_page.php"; 
            </script>';

      } else {
        // First query execution failed
        echo "No reeust submittions";

        // If database wrongly exeute, displag error ,else it ignore 
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



