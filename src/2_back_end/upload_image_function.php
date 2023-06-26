<?php 

    include "../3_database/db_connection.php";

    $cur_upload_course_id = null;
    $cur_upload_course_name = null;
    $cur_upload_course_code = null;
    $cur_upload_course_trainee = null;
    $cur_upload_course_date_time = date("Y-m-d H:i:s");

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        $cur_upload_course_id = $_POST['hidden_upload_course_id'];
        $cur_upload_course_name = $_POST['hidden_upload_course_name'];
        $cur_upload_course_code = $_POST['hidden_upload_course_code'];
        $cur_upload_course_trainee = $_POST['hidden_upload_course_trainee'];
        
        $fileCount = count($_FILES['file']['name']);
        
        for($i = 0; $i < $fileCount; $i++){
            $fileName = $_FILES['file']['name'][$i];
            $sql_query = "INSERT INTO learnbetter_upload (upload_course_id, upload_course_name, upload_course_code ,upload_trainee_id, upload_file, upload_current_date) 
                          VALUES ('$cur_upload_course_id', '$cur_upload_course_name', '$cur_upload_course_code', '$cur_upload_course_trainee', '$fileName', '$cur_upload_course_date_time')";

          if($conn->query($sql_query) === TRUE){
            echo '<script>
                        alert("Document uploaded successfuly in training");
                        window.location.href = "../1_front_end/learnbetter_B2_view_training_page.php"; 
                  </script>';
          }else{
            echo 'Connection Error'.$conn->error;
          }
            
        }
        
    }


?>