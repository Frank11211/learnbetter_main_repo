<?php 
    // connection databse 
    include "../3_database/db_connection.php";

    $check_course_code = null;
    $check_course_pin = null;

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $check_course_code  = $_POST['candi_training_code'];
        $check_course_pin   = $_POST['candi_training_pin'];

        // candi_training_pin
        $sql_query = "SELECT * FROM learnbetter_courses 
                      WHERE course_code = $check_course_code";

        $sql_result = $conn->query($sql_query);

        if($sql_result->num_rows > 0){
            $row = $sql_result->fetch_assoc(); 

            if($row['course_pin'] === $check_course_pin){

                $_SESSION['valid_course_code'] = $check_course_code;

                echo '<script>
                        alert("Enroll Success, Require check credential info");
                        window.location.href = "../1_front_end/learnbetter_C3_confirm_enroll_page.php"; 
                      </script>';

            }elseif($row['course_pin'] != $check_course_pin){
             
                echo '<script>
                        alert("Incorrect training pin, try again");
                        window.location.href = "../1_front_end/learnbetter_C3_enroll_training_page.php"; 
                      </script>'; 
            }

        }else{
            echo '<script>
                        alert("Invalid training code or none exsit, try again ");
                        window.location.href = "../1_front_end/learnbetter_C3_enroll_training_page.php"; 
                </script>';
        }
        

    }
?>
