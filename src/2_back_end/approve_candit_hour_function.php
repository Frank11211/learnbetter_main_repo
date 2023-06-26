<?php
    include "../3_database/db_connection.php";

    $temp_checkbox_candit_course_code = null;
    $temp_checkbox_candit_course_name = null;

    $course_completed_code          = null;
    $course_completed_name          = null;
    $course_completed_trainee       = null;
    $course_completed_date          = null;
    $course_total_amount            = 0; 


    $temp_checkbox_candit_group = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $temp_checkbox_candit_course_code = $_POST['approve_course_code'];
        $temp_checkbox_candit_course_name = $_POST['approve_course_name'];

        if (isset($_POST['checkbox_group'])) {
            $temp_checkbox_candit_group = $_POST['checkbox_group'];
        } else {
            $temp_checkbox_candit_group = array();
        }

        $sql_trainee_query = "SELECT learnbetter_enrollment.enroll_course_code, learnbetter_enrollment.enroll_course_name,
                                    learnbetter_enrollment.enroll_candi_id, learnbetter_enrollment.enroll_course_hour,
                                    learnbetter_enrollment.enroll_course_trainee, learnbetter_users.user_candit_total_credit_hour
                            FROM learnbetter_enrollment
                            JOIN learnbetter_users ON learnbetter_enrollment.enroll_candi_id = learnbetter_users.id
                            WHERE learnbetter_enrollment.enroll_course_code = '$temp_checkbox_candit_course_code'
                            AND learnbetter_enrollment.enroll_course_name = '$temp_checkbox_candit_course_name' ";

        $sql_result = $conn->query($sql_trainee_query);

        if ($sql_result) {
            //Proceed update credit hour and delete from the row
            while ($row = $sql_result->fetch_assoc()) {
                $course_completed_code      = $row['enroll_course_code'];
                $course_completed_name      = $row['enroll_course_name'];
                $course_completed_trainee   = $row['enroll_course_trainee'];
                $course_completed_date      = date("Y-m-d H:i:s");

                // $course_total_amount = $row['enroll_candi_id'];

                // Update credit hour and delete selected candidates
                if (in_array($row['enroll_candi_id'], $temp_checkbox_candit_group)) {
                    $row['user_candit_total_credit_hour'] += $row['enroll_course_hour'];

                    // Update the user_candit_total_credit_hour column
                    $user_id = $row['enroll_candi_id'];
                    $credit_hour = $row['user_candit_total_credit_hour'];

                    $update_query = "UPDATE learnbetter_users SET user_candit_total_credit_hour = $credit_hour WHERE id = $user_id";
                    $update_result = $conn->query($update_query);

                    if ($update_result) {
                        // Delete the selected candidate from the course
                        $temp_sql_query = "DELETE FROM learnbetter_enrollment WHERE enroll_candi_id = $user_id";
                        $conn->query($temp_sql_query);
                    } else {
                        echo "Database update query error: " . $conn->error;
                    }
                }
            }

            // Check if course remain candidate still inside course 
            $temp_query_2 = "SELECT *
                            FROM learnbetter_enrollment
                            WHERE enroll_course_code = '$course_completed_code'  
                            AND enroll_course_name = '$course_completed_name'";

            $temp_query_2_result = $conn->query($temp_query_2);


            if($temp_query_2_result){
                $row = $temp_query_2_result->fetch_assoc();
                $course_total_amount = $row['enroll_candi_id'];
            }else{
                $course_total_amount = array();
            }

            if ($course_total_amount > 0) {
                // There are remaining candidates, so redirect to the respective course page
                echo '<script>
                    alert("Selected candidates have been approved");
                    window.location.href = "../1_front_end/learnbetter_B2_approve_candit_page.php";
                </script>';
            } else {
                // All candidates approved, proceed to close the course

                $sql_first_query = "INSERT INTO learnbetter_complete_log (complete_course_code, complete_course_name, complete_course_trainee, complete_date) 
                                    VALUES ('$course_completed_code', '$course_completed_name', '$course_completed_trainee', '$course_completed_date')";
            
                $sql_first_result = $conn->query($sql_first_query);
            
                if ($sql_first_result) {
                    $sql_second_query = "DELETE FROM learnbetter_courses WHERE course_code = '$course_completed_code' AND course_name = '$course_completed_name'";
            
                    $sql_second_result = $conn->query($sql_second_query);
            
                    if ($sql_second_result) {
                        echo '<script>
                            alert("All candidates approved and training course has been closed");
                            window.location.href = "../1_front_end/learnbetter_B2_approve_candit_page.php";
                        </script>';
                    } else {
                        echo "Database delete query error: " . $conn->error;
                    }
                } else {
                    echo "Database insert query error: " . $conn->error;
                }
            }
            
        } else {
            echo "There is no data fetching back: " . $conn->error;
        }
    } 
?>