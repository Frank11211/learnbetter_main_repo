<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    
    require '../../vendor/autoload.php';

    // Include other files or perform other actions  
    include "../3_database/db_connection.php";
    
    // Create PHPMailer Object 
    $mail = new PHPMailer(true);


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        try {
           
            date_default_timezone_set("Asia/Kuala_Lumpur");

            $email_train_add_firstN     = $_POST["upd_acc_firstN_A1"];
            $email_train_add_lastN      = $_POST["upd_acc_lastN_A1"];
            $email_train_add_mail       = $_POST["upd_acc_mail_A1"];
            $email_train_add_gen        = $_POST["upd_acc_gen_A1"];
            $email_train_add_username   = $_POST["upd_acc_name_A1"];
            $email_train_add_password   = $_POST["upd_acc_pass_A1"];
        
            
            // Mail Section here
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
            $mail->addAddress( $email_train_add_mail, 'Name');
            $mail->isHTML(true);		
            
            // Imagine like writing an email
            $mail->Subject = 'New Trainer Account Created :- ';
            $mail->Body = '
                            <b>Below are the trainer account created</b><br><br>

                            <p>Please review the login credential shown below, <br><br> 
                               You may alter the login credential after login below.</p>
                            <br>

                            <a href="http://localhost/learnbetter_main/src/1_front_end/learnbetter_login_page.php"> Click here to login</a>
                            <br><br>

                            <table style="width: 100%; border-collapse: collapse; padding: 5px; text-align: center;">
                                <tr>
                                    <th style="border: 1px solid;"> First Nname        </th>
                                    <th style="border: 1px solid;"> Last Name         </th>
                                    <th style="border: 1px solid;"> Trainer E-mail   </th>                     
                                    <th style="border: 1px solid;"> Trainer Gender   </th>
                                    <th style="border: 1px solid;"> Account Username </th>
                                    <th style="border: 1px solid;"> Account Password </th>
                                </tr>

                                <tr>
                                    <td style="border: 1px solid;">'.$email_train_add_firstN   .'</td>
                                    <td style="border: 1px solid;">'.$email_train_add_lastN    .'</td>
                                    <td style="border: 1px solid;">'.$email_train_add_mail     .'</td>                     
                                    <td style="border: 1px solid;">'.$email_train_add_gen      .'</td>
                                    <td style="border: 1px solid;">'.$email_train_add_username .'</td>
                                    <td style="border: 1px solid;">'.$email_train_add_password .'</td>    
                                </tr>
                            </table>                            
                        ';
            
            $mail->send();
            
            echo '<script>
                    alert("Email had successfully send to trainee inbox");
                    window.location.href = "../1_front_end/learnbetter_A1_trainee_mng_page.php"; 
                </script>';
                
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }  
?>