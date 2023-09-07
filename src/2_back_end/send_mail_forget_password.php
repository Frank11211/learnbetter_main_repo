<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    
    require '../../vendor/autoload.php';

    // Include other files or perform other actions  
    include "../3_database/db_connection.php";
    
    // Create PHPMailer Object 
    $mail = new PHPMailer(true);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      

        $forget_pass_email = $_POST["user_forget_pass_email"];
        $forget_pass_rand_str = $_POST["user_forget_pass_rand_str"];

        $upd_sql_query = "UPDATE learnbetter_users 
                          SET user_pass_token = '$forget_pass_rand_str'
                          WHERE user_email = '$forget_pass_email'
                          LIMIT 1 ;";

        $conn->query($upd_sql_query);   
        
        $sql_query = "SELECT * FROM learnbetter_users
                     WHERE user_email = '$forget_pass_email' 
                     LIMIT 1 ; ";


        $sql_result = $conn->query($sql_query);

        if($sql_result){

            $row = $sql_result->fetch_assoc();
            $recover_email = $row['user_email'];

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
            $mail->addAddress($recover_email, 'Name');
            $mail->isHTML(true);		

            $mail->Subject = 'LearnBetter Forget Password';
            $mail->Body = '
                <h2>Reset Your Password</h2>
                <p>Dear User,</p>
                <p>Click the link below to reset your password:</p><br>

                
                <p><a href="http://localhost/learnbetter_main/src/1_front_end/learnbetter_reset_password_page.php?token='.$forget_pass_rand_str.'">Click Here to Reset Password</a></p>
                <p>If you did not request a password reset, please ignore this email.</p>
                <p>Regards,</p>
                <p>LearnBetter Team</p>
                 ';
            $mail->send();

            echo '<script>
                    alert("Reset link had send successfully, kindly check your inbox.");
                    window.location.href = "../1_front_end/learnbetter_login_page.php"; 
                </script>';

        }else{
            echo "There is no data , echo from send_mail.php". $conn->error;
        }
    }

?>   
<a href=""></a>