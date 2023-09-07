<?php 
  // connection databse 

  use PHPMailer\PHPMailer\PHPMailer;

  require '../../vendor/autoload.php';

  include "../3_database/db_connection.php";

  date_default_timezone_set("Asia/Kuala_Lumpur");
  
  // First iitialize variable, scope problem
  $error_train_code         = null;
  $error_train_name         = null;
  $error_train_trainee_asig = null;
  $error_train_vacant       = null;
  $error_train_pin          = null;

  // store user previous value 
  $req_course_approve_id               = null;
  $req_course_approve_code             = null;
  $req_course_approve_name             = null;
  $req_course_approve_trainee_id       = null;
  $req_course_approve_time_duration    = null;
  $req_course_approve_pin              = null;
  $req_course_approve_begin_date_time  = null;
  $req_course_approve_curr_date        = null;

  // Time management    
  $req_course_approve_hours        = null;
  $req_course_approve_minute       = null;


  // check if the request is POST
  if(isset($_GET['approve_courseId']) && isset($_GET['tmp_trainee_email'])){

    $req_course_approve_id = $_GET['approve_courseId'];
    $req_course_trainee_id = $_GET['tmp_trainee_email'];

    $sql_query = "SELECT * FROM learnbetter_request 
                WHERE id = " . $req_course_approve_id;

    $sql_result = $conn->query($sql_query);

    if($sql_result){

        $row = $sql_result->fetch_assoc();

        $req_course_approve_code             = $row['req_course_code'];
        $req_course_approve_name             = $row['req_course_name'];
        $req_course_approve_trainee_id       = $row['req_course_trainee'];  
        $req_course_approve_time_duration    = $row['req_course_time'];
        $req_course_approve_pin              = $row['req_course_pin'];
        $req_course_approve_begin_date_time  = $row['req_course_begin_date_time'];
        $req_course_approve_curr_date        = date("Y-m-d H:i:s");

        $req_course_approve_hours            = floor($req_course_approve_time_duration  / 60);
        $req_course_approve_minute           = $req_course_approve_time_duration % 60 ;
    }

     // gather user input from file "learnbetter_users.php"
      $second_sql_query =  "INSERT INTO learnbetter_courses (course_code, course_name, course_assign, course_time_duration, course_pin, course_date_begin, reg_date_time) 
                           VALUES ('$req_course_approve_code', '$req_course_approve_name', '$req_course_approve_trainee_id', '$req_course_approve_time_duration', '$req_course_approve_pin', 
                           '$req_course_approve_begin_date_time', '$req_course_approve_curr_date')";

      $second_sql_result = $conn->query($second_sql_query);    

      // Check if the first query was successful
      if ($second_sql_result) {
          
        // if first query executed successfully , update trainee_course value by 1 base admin select
        $third_sql_query = "UPDATE `learnbetter_users`
                            SET `learnbetter_users`.`trainee_course` = `learnbetter_users`.`trainee_course` + 1
                            WHERE `learnbetter_users`.`id` = $req_course_approve_trainee_id";

        $third_sql_result = $conn->query($third_sql_query);

        // Check if the second query was successful
        if ($third_sql_result){

          $third_sql_query = "DELETE FROM `learnbetter_request` 
                              WHERE `id` = $req_course_approve_id";

          $third_sql_result = $conn->query($third_sql_query);
          
          if ($third_sql_result) {
            
            $forth_sql_query = "SELECT user_email 
                                FROM learnbetter_users 
                                WHERE id = $req_course_trainee_id";

            $forth_sql_result = $conn->query($forth_sql_query);

            if($forth_sql_result){

              $row = $forth_sql_result->fetch_assoc();

              $send_trainee_email = $row['user_email'];

               // Send email using PHPMailer
              $mail = new PHPMailer(true);

              $mail->SMTPDebug = 0;	// change 2 to display debuggin 								
              $mail->isSMTP();										
              $mail->Host	 = 'smtp.gmail.com;';				
              $mail->SMTPAuth = true;							
              $mail->Username = 'wenfung11211@gmail.com';				
              $mail->Password = 'rrafevszupshnazn';					
              $mail->SMTPSecure = 'tls';							
              $mail->Port	 = 587;

              $mail->setFrom('wenfung11211@gmail.com', 'LearnBetter Team');	

              // Specific 
              $mail->addAddress($send_trainee_email, 'Name');
              $mail->isHTML(true);		
              
              // Imagine like writing an email
              $mail->Subject = 'Course Requested :'.$req_course_approve_name ;
              $mail->Body = '
                              <b>Training course had been approved </b><br><br>

                              <p> Please review the training credential shown below :</p><br>
                              
                              <a href="http://localhost/learnbetter_main/src/1_front_end/learnbetter_login_page.php"> Click here to login </a>
                              <br><br>

                              <table style="width: 100%; border-collapse: collapse; padding: 5px; text-align: center;">
                                  <tr>
                                      <th style="border: 1px solid;"> Course Code           </th>
                                      <th style="border: 1px solid;"> Course Name           </th>
                                      <th style="border: 1px solid;"> Course Pin Code       </th>                     
                                      <th style="border: 1px solid;"> Course Duration       </th>
                                      <th style="border: 1px solid;"> Course Pin Number     </th>
                                      <th style="border: 1px solid;"> Beginning Date & Time </th>
                                      <th style="border: 1px solid;"> Approval Date         </th>
                                  </tr>

                                  <tr>
                                      <td style="border: 1px solid;">'.$req_course_approve_code .'</td>
                                      <td style="border: 1px solid;">'.$req_course_approve_name .'</td>
                                      <td style="border: 1px solid;">'.$req_course_approve_pin  .'</td>                     
                                      <td style="border: 1px solid;">'.$req_course_approve_hours.' hours '.$req_course_approve_minute.' minutes</td>
                                      <td style="border: 1px solid;">'.$req_course_approve_pin.'</td>
                                      <td style="border: 1px solid;">'.$req_course_approve_begin_date_time.'</td>
                                      <td style="border: 1px solid;">'.$req_course_approve_curr_date.'</td>
                                      
                                  </tr>
                              </table>                            
                          ';
    
              if ($mail->send()) {
                echo '<script>
                  alert("Course have been approve and anoucese to trainee");
                  window.location.href = "../1_front_end/learnbetter_A1_course_approval_page.php"; 
                </script>';

              } else {
                // Emrail error
                echo "Email sending failed: " . $mail->ErrorInfo;
              }

            }else{
              // Forth query execution failed
             echo "Forth query execution failed: " . $conn->error;
            }
           
          } else {
            // Third query execution failed
            echo "Third query execution failed: " . $conn->error;
          }
  
        // Output databsae error 
        } else {
            // Second query execution failed
            echo "Second query execution failed: " . $conn->error;
        }
      } else {
        // First query execution failed
        echo "First query execution failed: " . $conn->error;
      }
    }
?>  
