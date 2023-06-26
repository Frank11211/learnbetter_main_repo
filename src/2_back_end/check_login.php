<?php
    session_start();

    function check_login(){
        // if session "user_name" have value, proceed to it's page
       
        if(isset($_SESSION["user_name"])){

            echo $_SESSION["user_name"];
            echo "<br>";
            echo $_SESSION["user_pass"];
            echo "<br>";
            echo $_SESSION["user_firstN"];
            echo "<br>";
            echo $_SESSION["user_lastN"];
            echo "<br>";
            echo $_SESSION["user_gen"];
            echo "<br>";
            echo $_SESSION["user_mail"];
            echo "<br>";
            echo "This echo from check_login function file";
        }
    }  

    function dis_num_course($db){
        $sql_query = "SELECT * FROM learnbetter_courses";
        $result = $db->query($sql_query);

        if ($result){
            
            $num_courses = $result->num_rows;
            return  $num_courses;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                    console.log('Database Query Error: ".$db->error."');
                </script>";
        }
    }

    // All trainee integer is == 2
    function dis_num_trainee($db){
        
        $sql_query = "SELECT * FROM learnbetter_users WHERE user_prio = 1";
        $result = $db->query($sql_query);

        if ($result){
        
            $num_trainees = $result->num_rows;
            return  $num_trainees;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                    console.log('Database Query Error: ".$db->error."');
                 </script>";
        }

    }

    // All candidate integer is == 1 
    function dis_num_candidate($db){
        $sql_query = "SELECT * FROM learnbetter_users WHERE user_prio = 2";
        $result = $db->query($sql_query);

        if ($result){
            
            $num_candidate = $result->num_rows;
            return  $num_candidate;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                    console.log('Database Query Error: ".$db->error."');
                </script>";
        }
    }

    function dis_num_course_pending($db){
        $sql_query = "SELECT * FROM learnbetter_request";
        $result = $db->query($sql_query);

        if ($result){
            
            $num_candidate = $result->num_rows;
            return  $num_candidate;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                    console.log('Database Query Error: ".$db->error."');
                </script>";
        }
    }

    function dis_num_course_pending_trainer($db, $trainee_id){
        $sql_query = "SELECT * FROM learnbetter_request WHERE req_course_trainee = $trainee_id";
        $result = $db->query($sql_query);

        if ($result){
            
            $num_candidate = $result->num_rows;
            return  $num_candidate;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                    console.log('Database Query Error: ".$db->error."');
                </script>";
        }
    }

    // show total number trainee course handle 
    function dis_num_trainee_handle_course($db, $trainee_id){
        $sql_query = "SELECT id FROM learnbetter_courses WHERE course_assign = $trainee_id";

        $result = $db->query($sql_query);

        if ($result){
            
            $num_candidate = $result->num_rows;
            return  $num_candidate;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                    console.log('Database Query Error: ".$db->error."');
                </script>";
        }
    }

    // show total number candidate enroll course  
    function dis_num_candidate_course_enroll($db, $candidate_id){
       
        $sql_query = "SELECT candidate_course FROM learnbetter_users WHERE id = $candidate_id";

        $result = $db->query($sql_query);

        if ($result){
            
            $num_candidate = $result->num_rows;
            return  $num_candidate;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                    console.log('Database Query Error: ".$db->error."');
                </script>";
        }
    }

    // show total number candidate enroll course  
    function dis_num_trainee_course_enroll($db, $candidate_id){
        
        $sql_query = "SELECT trainee_course FROM learnbetter_users WHERE id = $candidate_id";

        $result = $db->query($sql_query);

        if ($result){
            
            $num_candidate = $result->num_rows;
            return  $num_candidate;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                    console.log('Database Query Error: ".$db->error."');
                </script>";
        }
    }

    function convert_hour_minute($total_minutes) {
        $hours = floor($total_minutes / 60);
        $minutes = $total_minutes % 60;
    
        return sprintf("%02d hour %02d minutes", $hours, $minutes);
    }

    function convert_hour($total_hour) {
        $hours = floor($total_hour / 60);
    
        return $hours;
    }

    function convert_minute($total_minutes) {
        $minutes = $total_minutes % 60;
    
        return $minutes;
    }

    function get_trainee_name($db, $trainee_id){
        $sql_query = "SELECT user_firstname, user_lastname FROM learnbetter_users
                    WHERE id = $trainee_id";

        $sql_result = $db->query($sql_query);

        if($sql_result){
            $row = $sql_result->fetch_assoc();
            $get_trainee_name = $row['user_firstname']." ".$row['user_lastname'];
            
            return  $get_trainee_name;

        }else{
            echo "Database have error ". $db->error;
        }
    }

    function get_candi_name($db, $trainee_id){
        $sql_query = "SELECT user_firstname, user_lastname FROM learnbetter_users
                    WHERE id = $trainee_id";

        $sql_result = $db->query($sql_query);

        if($sql_result){
            $row = $sql_result->fetch_assoc();
            $get_trainee_name = $row['user_firstname']." ".$row['user_lastname'];
            
            return  $get_trainee_name;

        }else{
            echo "Database have error ". $db->error;
        }
    }

    function generate_rand_pass($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        
        $characterCount = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, $characterCount - 1)];
        }
        
        return $password;
    }

    function get_course_name($db, $course_id){
        $sql_query = "SELECT course_name FROM learnbetter_courses
                    WHERE id = $course_id";

        $sql_result = $db->query($sql_query);

        if($sql_result){
            $row = $sql_result->fetch_assoc();
            $get_course_name = $row['course_name'];
            
            return  $get_course_name;

        }else{
            echo "Database have error ". $db->error;
        }
    }

    function dis_admin_acc_img($db, $user_id) {
        $sql_query = "SELECT user_upload_img FROM learnbetter_users WHERE id = $user_id";
        $result = $db->query($sql_query);
    
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['user_upload_img'];
        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                console.log('Database Query Error: ".$db->error."');
            </script>";
        }
    }

    function dis_complete_course_trainer($db, $user_id){

        $sql_query = "SELECT * FROM learnbetter_complete_log WHERE complete_course_trainee = $user_id";
        $result = $db->query($sql_query);
    
        if ($result) {
            $row = $result->num_rows;
            return $row;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                console.log('Database Query Error: ".$db->error."');
            </script>";
        } 
    }

    function dis_upload_doc_trainer($db, $user_id){

        $sql_query = "SELECT * FROM learnbetter_upload WHERE upload_trainee_id = $user_id";
        $result = $db->query($sql_query);
    
        if ($result) {
            $row = $result->num_rows;
            return $row;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                console.log('Database Query Error: ".$db->error."');
            </script>";
        } 
    }


    function dis_num_enrollment_course($db, $user_id){

        $sql_query = "SELECT * FROM learnbetter_enrollment WHERE enroll_candi_id = $user_id";
        $result = $db->query($sql_query);
    
        if ($result) {
            $row = $result->num_rows;
            return $row;

        } else {
            echo "Database error, check console.log for DB error";
            echo "<script>
                console.log('Database Query Error: ".$db->error."');
            </script>";
        } 
    }

    function dis_num_credit_hour($db, $user_id){

        $sql_query = "SELECT * FROM learnbetter_users WHERE id = $user_id";
        $result = $db->query($sql_query);

        if($result){
            $row = $result->fetch_assoc();
            return $row['user_candit_total_credit_hour'];
        }else{
            echo "There is no data return";
        }
    }

    function dis_num_assign_candi_email($db, $user_id){

        $sql_query = "SELECT * FROM learnbetter_email_log WHERE email_log_candi = $user_id";
        $result = $db->query($sql_query);

        if($result){
            $row = $result->num_rows;
            return $row;
        }else{
            echo "There is no data return";
        }
    }

?>