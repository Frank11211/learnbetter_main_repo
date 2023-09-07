<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/update_info.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>User Template</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/learnbetter_C_home_page_style.css">
  
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

          <li> 
            Enroll Course : <?php echo dis_num_enrollment_course($conn, $_SESSION["user_id"]) ?>
          </li>
        </ul>
    </div>

    <?php include "../4_component/C3_sidebar.php"; ?>
    
  </div>

 <section> 
  <!-- Start your code hwere,   -->
  <div  class="num_dis_style">

    <div class="dboard_design">     
        <p> Course Enrolled </p>
        <br>
        <p class="count_num_style"><b><?php echo dis_num_enrollment_course($conn, $_SESSION["user_id"]) ?></b></p>  
    </div>  
    
    <div class="dboard_design">
        <p>Total Credit Hour </p>
        <br>
        <p class="count_num_style">
            <b>
                <?php 
                    $time = dis_num_credit_hour($conn, $_SESSION["user_id"]);
                    echo convert_hour($time)." hr ".convert_minute($time)." min";
                ?>
            </b>
        </p>
    </div>  

    <div class="dboard_design"> 
        <p>Enrollment Required</p>
        <br>
        <!-- From the email log , assign by Admin, require to cather delete email log if enrolled -->
        <p class="count_num_style"><b><?php echo dis_num_assign_candi_email($conn, $_SESSION["user_id"]); ?></b></p>
    </div>  
    
  </div>

    <!-- ...............................................  -->
         <!-- CRUD  Course Table Menu -->
         <div class="crud_train_asign_table">
         <h2>Training Enrollment History </h2>
            <table style="width:100%; padding:10px;">
            <tr>
            <!-- Table Title  -->
                <th>No.</th>
                <th>Course Code        </th>
                <th>Course Name        </th>
                <th>Course Trainer       </th>
                <th>Course Duration    </th>
                <th>Beginning Date & Time </th>     
            </tr>

            <!-- ALL DATA PERFORM BELOW   -->
            <?php 
                $get_user_id = $_SESSION["user_id"] ;

                // Join table in order to use the 
                $sql_trainee_query= "SELECT * FROM learnbetter_enrollment  
                                    WHERE enroll_candi_id = $get_user_id";

                $trainee_query_result = $conn->query($sql_trainee_query);

                if($trainee_query_result->num_rows > 0){
                // first initiate variable to show number
                $i = 1;

                // if priority is trainee, display out in table

                while ($row = $trainee_query_result->fetch_assoc()) {

                    $train_course_id = $row['id'];
                
                    echo "<tr>";
                    echo "<td>". $i ."</td>"; 
                    echo "<td>".$row['enroll_course_code'] ."</td>"; 
                    echo "<td>".$row['enroll_course_name'] ."</td>"; 
                    echo "<td>".get_trainee_name($conn, $row['enroll_course_trainee'])."</td>"; 
                    echo "<td>".convert_hour_minute($row['enroll_course_hour']) ."</td>"; 
                    echo "<td>".$row['enroll_date_time']  ."</td>"; 
  
                    // increase counter
                    $i++;
                }

                }else{
                    
                    echo "<tr >";
                    echo "<td colspan='6'>No Training been Enrolled</td>"; 
                    echo "</tr>";
                      
                }
            
            ?>
            
            </table> 
        </div>
  
</section>

</body>
</html>