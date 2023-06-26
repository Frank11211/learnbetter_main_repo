<?php 
    // connection databse 
    include "../3_database/db_connection.php";

    $view_course_name       = null;
    $view_course_code       = null;
    $view_course_trainee    = null;
    $view_course_date_begin = null;
    $view_course_time_dur   = null;
    $view_course_candi_name = null;
    $view_course_candi_id   = null;
    

    if($_SERVER["REQUEST_METHOD"] == "POST"){

       $view_course_name             = $_POST["enroll_course_name"];      
       $view_course_code             = $_POST["enroll_course_code" ];
       $view_course_candi_name       = $_POST["enroll_course_candi_name"];
       $view_course_candi_id         = $_POST["enroll_course_candi_id"];
       $view_course_trainee          = $_POST["enroll_course_trainee" ];
       $view_course_date_begin       = $_POST["enroll_course_date_begin" ];
       $view_course_time_dur         = $_POST["enroll_course_time_dur" ];
       $view_course_current_reg_date = date("Y-m-d H:i:s");
        
       $sql_query = "INSERT INTO learnbetter_enrollment 
                    (enroll_course_name, enroll_course_code, enroll_candi_name, enroll_candi_id, enroll_course_trainee, 
                    enroll_date_time, enroll_course_hour, enroll_current_enroll_date)
                    VALUES ('$view_course_name', '$view_course_code', '$view_course_candi_name', '$view_course_candi_id', '$view_course_trainee',
                            '$view_course_date_begin', '$view_course_time_dur', '$view_course_current_reg_date')";

        $sql_result = $conn->query($sql_query);

        // Update candidate course by candidate id 
        $second_sql_query = "UPDATE learnbetter_users
                            SET candidate_course = candidate_course + 1
                            WHERE id=$view_course_candi_id";

         $conn->query($second_sql_query);

        if($sql_result){

            echo '<script>
                        alert("You have enroll successfully");
                        window.location.href = "../1_front_end/learnbetter_C3_view_enrollment_page.php"; 
                      </script>';

        }else{
            echo '<script>
                        alert("Some error occus, please try again ");
                        window.location.href = "../1_front_end/learnbetter_C3_enroll_training_page.php"; 
                </script>';
        }
        

    }
?>
