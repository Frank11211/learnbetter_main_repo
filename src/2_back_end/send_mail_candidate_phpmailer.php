<?php 
    // Reference 
    // https://www.geeksforgeeks.org/how-to-send-an-email-using-phpmailer/
    // https://www.youtube.com/watch?v=9tD8lA9foxw&ab_channel=DavidGTech

    use PHPMailer\PHPMailer\PHPMailer;
    //use PHPMailer\PHPMailer\Exception;
    
    require '../../vendor/autoload.php';

    // Include other files or perform other actions  
    include "../3_database/db_connection.php";
    
    // Create PHPMailer Object 
    $mail = new PHPMailer(true);

    

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        try {
          
            date_default_timezone_set("Asia/Kuala_Lumpur");

            $email_train_course_id  = $_POST["send_email_course_id"];
            $email_train_candi_id   = $_POST["send_email_candi_id"]; // only the course_assign number
        

            $email_trainee_email    = null;
            $email_trainee_course   = null;
            $email_trainee_code     = null;
            $email_trainee_pin      = null;
            $email_trainee_fullname = null;
            $email_time_hour        = null;
            $email_time_min         = null;
            $email_curr_time        = date("Y-m-d H:i:s");

            //-----------------------------------------------------------------------------

            $sql_query = "SELECT  user_email , user_firstname, user_lastname  
                        FROM learnbetter_users   
                        WHERE  id = $email_train_candi_id ";

            $sql_result = $conn->query($sql_query);

            if($sql_result){
                $row = $sql_result->fetch_assoc();
                $email_trainee_email = $row['user_email'];

            }else{
                echo "There is no data , echo from send_mail.php". $conn->error;
            }

            // -----------------------------------------------------------------------------
            // Second Query , get course credential by course code
            $second_sql_query= "SELECT *
                                FROM learnbetter_courses
                                WHERE course_code =  $email_train_course_id";

            $second_sql_result = $conn->query($second_sql_query);

            if($second_sql_result){
                $sec_row = $second_sql_result->fetch_assoc();
                $email_trainee_code     = $sec_row['course_code'];
                $email_trainee_course   = $sec_row['course_name'];
                $email_trainee_pin      = $sec_row['course_pin'];
                $email_trainee_course_handler = $sec_row['course_assign'];
                $email_time_hour        = floor($sec_row['course_time_duration'] / 60);
                $email_time_min         = $sec_row['course_time_duration'] % 60 ;

            }else{
                echo "There is no data , echo from send_mail.php". $conn->error;
            }

            // -----------------------------------------------------------------------------
            // 3rd Query , update in learnbetter_email_log
            // Second Query , get course credential by course code
            $second_sql_query= "INSERT INTO learnbetter_email_log (email_log_code, email_log_name, email_log_trainee, email_log_candi, email_log_send_date_time)
                                VALUES ('$email_trainee_code', '$email_trainee_course', '$email_trainee_course_handler', '$email_train_candi_id', '$email_curr_time') ";

            $conn->query($second_sql_query);

            // -----------------------------------------------------------------------------
            // Get Trainee Assign name 
            $thrd_sql_query = "SELECT user_firstname, user_lastname FROM learnbetter_users
            WHERE id = $email_trainee_course_handler";
            
            $thrd_sql_result = $conn->query($thrd_sql_query);

            if($thrd_sql_result){
                
            $thrd_row = $thrd_sql_result->fetch_assoc();

            $email_trainee_fullname = $thrd_row['user_firstname']." ".$thrd_row['user_lastname'];

            }else{
                echo "Database have error ". $conn->error;
            }
            
            // Mail Section here
            $mail->SMTPDebug = 0;	// change 2 to display debuggin 								
            $mail->isSMTP();										
            $mail->Host	 = 'smtp.gmail.com;';				
            $mail->SMTPAuth = true;							
            $mail->Username = 'wenfung11211@gmail.com';				
            $mail->Password = 'rrafevszupshnazn';					
            $mail->SMTPSecure = 'tls';							
            $mail->Port	 = 587;

            $mail->setFrom('wenfung11211@gmail.com', 'learnBetter Team');	

            // Specific 
            $mail->addAddress($email_trainee_email, 'Name');
            $mail->isHTML(true);		
            
            // Imagine like writing an email
            $mail->Subject = 'New Training : '.$email_trainee_course;
            $mail->Body = '
                            <b>Training require to Attend</b><br><br>

                            <p>Please review the training credntial show below, <br> 
                            You are require to participate the training below  </p>
                            <br>
                            <a href="http://localhost/learnbetter_main/src/1_front_end/learnbetter_login_page.php"> Click here to login account</a>
                            <br><br>

                            <table style="width: 100%; border-collapse: collapse; padding: 5px; text-align: center;">
                                <tr>
                                    <th style="border: 1px solid;"> Training Code           </th>
                                    <th style="border: 1px solid;"> Training Name           </th>
                                    <th style="border: 1px solid;"> Training Pin Code       </th>                     
                                    <th style="border: 1px solid;"> TrainignTime Duration   </th>
                                    <th style="border: 1px solid;"> Assign Trainee          </th>
                                </tr>

                                <tr>
                                    <td style="border: 1px solid;">'.$email_trainee_code .'</td>
                                    <td style="border: 1px solid;">'.$email_trainee_course .'</td>
                                    <td style="border: 1px solid;">'.$email_trainee_pin .'</td>                     
                                    <td style="border: 1px solid;">'.$email_time_hour.' hours '.$email_time_min.' minutes</td>
                                    <td style="border: 1px solid;">'.$email_trainee_fullname.'</td>
                                </tr>
                            </table>                            
                        ';
            
            $mail->send();
            
            echo '<script>
                    alert("Email had successfully send to candidate inbox");
                    window.location.href = "../1_front_end/learnbetter_A1_candidate_mng_page.php"; 
                </script>';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }  
?>