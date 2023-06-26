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

  <link rel="stylesheet" href="../../css/learnbetter_B_view_training.css">
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
    <img src="data:image;base64, <?php echo base64_encode( dis_admin_acc_img($conn, $_SESSION['trainee_id'])); ?>" style="height:90px; width:90px;" alt="img_user"> 
        <h4> 
            <?php 
                if($_SESSION['trainee_gen'] === "Male"){
                    echo " Mr. ".$_SESSION["trainee_firstN"];
                }elseif($_SESSION['user_gen'] === "Female"){
                    echo " Ms. ".$_SESSION["trainee_firstN"];
                }
            ?> 
        </h4><br>

        <ul class="sidebar-acc-post">
          <li> Position : 
            <?php 
                if(isset($_SESSION['trainee_level']) && $_SESSION['trainee_level'] == 1 ){
                  echo "<b>Trainee</b>";
              }else{
                  echo "No Position";
              }
            ?>
          </li> <br>
          <!-- Show number of course taken -->
          <li> 
            Total Course : <?php echo dis_num_trainee_handle_course($conn, $_SESSION["trainee_id"]); ?>
          </li>
        </ul>
    </div>

    <?php include "../4_component/B2_sidebar.php"; ?>
    
  </div>

 <section> 

  <div class="view_train_asign_table">
      <h2>Newly Created Course</h2>

    <table style="width:100%; padding:10px;">
          <tr>
            <!-- Table Title  -->
              <th>No.</th>
              <th>Training Code     </th>
              <th>Training Name     </th>
              <th>Trainer Handle    </th>
              <th>Training Pin      </th>
              <th>Time Duration     </th>
              <th>Begin Date & Time  </th>
              <th>Action            </th>

          </tr>
    <?php 
      // Join table in order to use the 
      $get_trainee_id = $_SESSION['trainee_id'];
      
      $sql_trainee_query= "SELECT learnbetter_users.user_firstname, learnbetter_users.user_lastname, learnbetter_courses.id, 
                          learnbetter_users.id AS user_id, learnbetter_courses.course_code, learnbetter_courses.course_name, 
                          learnbetter_courses.course_pin, learnbetter_courses.course_time_duration, learnbetter_courses.course_date_begin
                          FROM learnbetter_users 
                          JOIN learnbetter_courses ON learnbetter_users.id = learnbetter_courses.course_assign
                          WHERE learnbetter_courses.course_assign = $get_trainee_id;
                          ";
      $sql_result = $conn ->query($sql_trainee_query);

      if($sql_result){

        $i = 1;
        
          while ($row = $sql_result->fetch_assoc()) {

            // Get course id, 
            $train_course_id = $row['id'];
            $train_course_code = $row['course_code'];
            $train_course_name = $row['course_name'];
        
            echo "<tr>";
            echo "<td>". $i ."</td>"; 
            echo "<td>".$row['course_code'] ."</td>"; 
            echo "<td>".$row['course_name'] ."</td>"; 
            echo "<td>".$row['user_firstname']." ".$row['user_lastname']."</td>"; 
            echo "<td>".$row['course_pin']  ."</td>"; 
            echo "<td>".convert_hour_minute($row['course_time_duration']) ."</td>"; 
            echo "<td>".$row['course_date_begin'] ."</td>";
            
            echo '<td>
                    <button class="btn_style_2">
                      <a href="../1_front_end/learnbetter_B2_upload_doc_page.php?upl_course_name='.$train_course_name.'&upl_course_id='.$train_course_id.'&upl_course_code='.$train_course_code.'" style="color:white;">
                        Upload Document  
                      </a>
                    </button>
                    
                  </td>
                  
                  </tr>
                  ';
            $i++;
          }

      }else{
        echo "There is no data fetching back ". $conn->error;
      }

    ?>

    </table>
  </div>
  
</section>

</body>
</html>