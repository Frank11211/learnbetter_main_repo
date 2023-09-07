<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/confirm_enroll_function.php";
   
    $valid_course_code = $_SESSION["valid_course_code"];

    $sql_query = "SELECT learnbetter_courses.course_name, learnbetter_courses.course_code, 
                         learnbetter_courses.course_assign, learnbetter_courses.course_date_begin,
                         learnbetter_courses.course_time_duration
                  FROM learnbetter_users
                  JOIN learnbetter_courses ON learnbetter_users.id = learnbetter_courses.course_assign 
                  WHERE learnbetter_courses.course_code =  $valid_course_code ";

    $sql_result = $conn->query($sql_query);

    if($sql_result){

      $row = $sql_result->fetch_assoc();

      $check_course_name          = $row['course_name'];
      $check_course_code          = $row['course_code'];
      $check_course_trainee       = $row['course_assign'];
      $check_course_time_duration = $row['course_time_duration'];

      $check_course_date_begin    = $row['course_date_begin'];
      $modify_time_duration       = date("Y-m-d h:ia", strtotime($check_course_date_begin));
      
    }else{
        echo "Database error" . $conn->error;
    }

    // Perform second query to check name 
    $second_sql_query = "SELECT user_firstname, user_lastname 
                            FROM learnbetter_users
                            WHERE id = $check_course_trainee ";

    $second_sql_result = $conn->query($second_sql_query);

    if($second_sql_result){
      $row = $second_sql_result->fetch_assoc();
      $check_course_fullname = $row['user_firstname']." ".$row['user_lastname'];
    }

    $user_fullname = $_SESSION["user_firstN"]." ".$_SESSION["user_lastN"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>User Template</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/learnbetter_C_confirm_page_style.css">
</head>

<body>
  
  <input type="checkbox" id="check">
   <label for="check">
      <i class="fas fa-bars " id="menu_btn"> </i>
      <i class="fas fa-times " id="menu_cancel"> </i>  
   </label>
  
  <!-- sidebar  -->
  <div class="sidebar-wrapper"> 

    <header><img src="../../img/learnbetter_logo.png" style="height:50px; width:50px; margin-top: 10px;" alt="logo_img"> LearnBetter </header>

    <div class="sidebar-acc-wrapper">
        <img src="data:image;base64, <?php echo base64_encode( dis_admin_acc_img($conn, $_SESSION['user_id'])); ?>" style="height:90px; width:90px;" alt="img_user"> 
        <h4> 
            <?php 
                if($_SESSION['user_gen'] === "Male"){
                    echo " Mr. ".$_SESSION["user_firstN"];
                }elseif($_SESSION['user_gen'] === "Female"){
                    echo " Ms. ".$_SESSION["user_firstN"];
                }
            ?> 
        </h4><br>

        <ul class="sidebar-acc-post">
          <li> Position : 
          <?php 
                if(isset($_SESSION["user_level"]) && $_SESSION['user_level'] == 2 ){
                    echo "<b>Candidate</b>";
                }else{
                    echo "No Position";
                }
            ?>
          </li> <br>
          <!-- Show number of course taken -->
          <li> 
            Enroll Course : <?php echo dis_num_enrollment_course($conn, $_SESSION["user_id"]) ?>
          </li>
        </ul>
    </div>
    
    <?php include "../4_component/C3_sidebar.php"; ?>
    
  </div>

 <section> 


  
  <div class="candi_confirm_table">

    <h2>Training Enrollment Section</h2>

    <hr>

    <div class="candi_confirm_info_table">

      <div class="candi_course_info_table">
        <p> Training Name : </p><br>
        <p style="color:gold;"> <?php echo $check_course_name; ?></p><br>

        <p> Training Code : </p><br>
        <p style="color:gold;"> <?php echo $check_course_code; ?></p><br>

        <p> Training Lecture : </p><br>
        <p style="color:gold;"> <?php echo $check_course_fullname; ?></p><br>

      </div>

      <div class="candi_date_info_table">
        <p> Training Date & Time : </p><br>
        <p style="color:gold;"> <?php echo $modify_time_duration  ?> </p><br>

        <p> Completion Hour : </p><br>
        <p style="color:gold;"> <?php echo convert_hour_minute($check_course_time_duration);?> </p><br>

        <p> Candidate Name : </p><br>
        <p style="color:gold;"> <?php echo $user_fullname; ?></p><br>

      </div>

    </div>

    <button type="button" class="btn_style_4">
        <a href="../1_front_end/learnbetter_C3_enroll_training_page.php" style="color:white;">Cancel Enroll</a>
      </button>

      <button type="submit" class="btn_style_3" form="send_enroll">Enroll Training </button>

    <!-- When submit button submit, the form send  -->
    <form method="POST" id="send_enroll">
      
      <input type="hidden" name="enroll_course_name"       value="<?php echo $check_course_name ?>">
      <input type="hidden" name="enroll_course_code"       value="<?php echo $check_course_code ?>">
      <input type="hidden" name="enroll_course_trainee"    value="<?php echo $check_course_trainee ?>">
      <input type="hidden" name="enroll_course_date_begin" value="<?php echo $check_course_date_begin ?>">
      <input type="hidden" name="enroll_course_time_dur"   value="<?php echo $check_course_time_duration ?>">
      <input type="hidden" name="enroll_course_candi_name" value="<?php echo $user_fullname ?>">
      <input type="hidden" name="enroll_course_candi_id"   value="<?php echo $_SESSION["user_id"] ?>">

    </form>

  </div>
</section>

</body>
</html>