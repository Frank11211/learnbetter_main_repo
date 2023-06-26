<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    //use PHPMailer\PHPMailer\Exception;
    
    require '../../vendor/autoload.php';

    // Include other files or perform other actions  
    include "../3_database/db_connection.php";
    
    // Create PHPMailer Object 
    $mail = new PHPMailer(true);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      
        $email_train_name       = $_POST["training_name_A1"];
        $email_train_code       = $_POST["training_code_A1"];
        $email_train_pin        = $_POST["training_pin_A1"];
        $email_train_trainee    = $_POST["training_trainee_assign_A1"]; // only the course_assign number
        $email_time_hour        = $_POST["training_hours"];
        $email_time_min         = $_POST["training_minute"];

        $email_trainee_email    = null;
        $email_trainee_fullname = null;

        $sql_query = "SELECT  learnbetter_users.user_email, learnbetter_users.user_firstname, learnbetter_users.user_lastname
                      FROM learnbetter_users  
                      JOIN learnbetter_courses ON learnbetter_users.id = learnbetter_courses.course_assign
                      WHERE learnbetter_courses.course_assign = $email_train_trainee ";

        $sql_result = $conn->query($sql_query);

        if($sql_result){

            $row = $sql_result->fetch_assoc();
            $email_trainee_email = $row['user_email'];
            $email_trainee_fullname = $row['user_firstname'].' '.$row['user_lastname'];

        }else{
            echo "There is no data , echo from send_mail.php". $conn->error;
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

        $mail->setFrom('wenfung11211@gmail.com', 'Lee Wen Fung');	

        // Specific 
        $mail->addAddress($email_trainee_email, 'Name');
        $mail->isHTML(true);		
        
        // Imagine like writing an email
        $mail->Subject = 'New Training Assign : '.$email_train_name ;
        $mail->Body = '
                        <b>Below are Course been assigned</b>

                        <p>Kindly refer to the assign course credential below, <br> 
                           You are free to upload any relevant document in account. </p>
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
                                <td style="border: 1px solid;">'.$email_train_code .'</td>
                                <td style="border: 1px solid;">'.$email_train_name .'</td>
                                <td style="border: 1px solid;">'.$email_train_pin .'</td>                     
                                <td style="border: 1px solid;">'.$email_time_hour.' hours '.$email_time_min.' minutes</td>
                                <td style="border: 1px solid;">'.$email_trainee_fullname.'</td>
                            </tr>
                        </table>
                      ';
        
        $mail->send();
      
        
    }
    
?>