<?php 
  // connection databse 
  include "../3_database/db_connection.php";

  // First iitialize variable, scope problem
  $error_msg_firstname  = null;
  $error_msg_lastname   = null;
  $error_msg_gender     = "Unknown";
  $error_msg_email      = null;
  $error_msg_username   = null;
  $error_msg_password   = null;

  // store user previous value 
  $reg_firstname  = null;
  $reg_lastname   = null;
  $reg_gender     = "Unknown"; 
  $reg_email      = null;
  $reg_username   = null;
  $reg_password   = null;
  $reg_priority   = 1;
  $imageData      = file_get_contents('../../img/blank_user.png');
  $trainee_cours    = 0;
  $candidate_course = null;
  $user_candit_total_credit_hour = null;

  global $sql_result;

  
  // check if the request is POST
  if($_SERVER["REQUEST_METHOD"] == "POST"){

    // gather user input from file "learnbetter_users.php"
    $reg_firstname  = $_POST['upd_acc_firstN_A1'];
    $reg_lastname   = $_POST['upd_acc_lastN_A1'];
    $reg_gender     = $_POST['upd_acc_gen_A1'] ?? "Unknown"; // set defult value if user did't not pick any option 
    $reg_email      = $_POST['upd_acc_mail_A1'];
    $reg_username   = $_POST['upd_acc_name_A1'];
    $reg_password   = $_POST['upd_acc_pass_A1'];  

    if(!empty($reg_firstname) && !empty($reg_lastname) && !empty($reg_gender) && !empty($reg_email) && !empty($reg_username) && !empty($reg_password)){  
      // Set up database query and exeucte  

      try {

        // Prepare the SQL statement with a parameter for the image data
        $sql_query = "INSERT INTO learnbetter_users (user_firstname, user_lastname, user_gender, user_email, user_username, user_password, user_prio, trainee_course, candidate_course, user_candit_total_credit_hour, user_upload_img)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql_query);

        // Bind the parameters and set the image data
        $stmt->bind_param("ssssssissss", $reg_firstname, $reg_lastname, $reg_gender, $reg_email, $reg_username, $reg_password, $reg_priority, $trainee_cours, $candidate_course, $user_candit_total_credit_hour, $imageData);

        // Execute the statement
        $stmt->execute();

        // Close the statement
        $stmt->close();

        echo '<script>
            alert("Trainee Account has been created");
            window.location.href = "../1_front_end/learnbetter_login_page.php"; 
          </script>';
          
      } catch (Exception $e) {
          // Handle exceptions
          echo "Error: " . $e->getMessage();
      } 

      echo '<script>
            alert("Trainee account has been created");
            window.location.href = "../1_front_end/learnbetter_A1_trainee_mng_page.php"; 
           </script>';

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



