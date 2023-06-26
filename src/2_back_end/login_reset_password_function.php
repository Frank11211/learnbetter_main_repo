<?php 

    include "../3_database/db_connection.php";

    $reset_pass_new     = null;
    $reset_pass_conf    = null;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $reset_pass_new     = $_POST['user_forget_pass_new'];
        $reset_pass_conf    = $_POST['user_forget_pass_conf'];
        $reset_pass_token   = $_POST['user_forget_pass_token'];

        $sql_query = "SELECT * FROM learnbetter_users
                     WHERE user_pass_token = '$reset_pass_token' 
                     LIMIT 1;";

        $sql_result = $conn->query($sql_query);

        if($sql_result && $sql_result->num_rows > 0){

            $row = $sql_result->fetch_assoc();
            $user_id = $row['id'];

            if($reset_pass_new === $reset_pass_conf){
                
                $sed_sql_query = "UPDATE learnbetter_users
                                  SET user_password = '$reset_pass_new'
                                  WHERE id = '$user_id'
                                  LIMIT 1;";

                $conn->query($sed_sql_query);
                
                echo '<script>
                    alert("Password has been updated");
                    window.location.href = "../1_front_end/learnbetter_login_page.php"; 
                </script>';
                
            }else{
                echo '<script>
                    alert("Passwords do not match, please try again");
                    window.location.href = "../1_front_end/learnbetter_reset_password_page.php?token='.$reset_pass_token.'"; 
                </script>';
            }

        }else{
            echo '<script>
                    alert("No data has been found, please submit the correct email");
                    window.location.href = "../1_front_end/learnbetter_forget_pass_page.php"; 
                </script>';
        }

    }

?>
