<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/update_info.php";
    // check_login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>Trainee Template</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/dashboard_user_temp_style.css">
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
                  echo "<b>Trainer</b>";
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
  <!-- Start your code hwere,   -->
  <div  class="num_dis_style">

    <div class="dboard_design">     
        <p>Training Pending</p>
        <br>
        <p class="count_num_style"><b><?php echo dis_num_trainee_handle_course($conn, $_SESSION["trainee_id"]); ?></b></p>  
    </div>  
    
    <div class="dboard_design"> 
        <p>Training Requested</p>
        <br>
        <p class="count_num_style"><b><?php echo dis_num_course_pending_trainer($conn, $_SESSION["trainee_id"])?></b></p>
    </div>  
    
    <div class="dboard_design">
        <p>Completed Training</p>
        <br>
        <p class="count_num_style"><b><?php echo dis_complete_course_trainer($conn, $_SESSION["trainee_id"])?></b></p>
    </div>  

    <div class="dboard_design">
        <p>Uploaded Doc</p>
        <br>
        <p class="count_num_style"><b><?php echo dis_upload_doc_trainer ($conn, $_SESSION["trainee_id"])?></b></p>
    </div> 
    
  </div>

  <div class="crud_train_asign_table">
    <h2>Training Detail Info </h2>
      <div>
          <div class="table_show_trainer_data_1">
            <h2>Training Pending List</h2>

            <table style="width:100%; padding:10px;">
              <tr>
              <!-- Table Title  -->
                  <th>No.</th>
                  <th>Course Code              </th>
                  <th>Course Name              </th>
                  <th>Date & Time <br> Created </th>

              </tr>

              <?php 
                $user_id = $_SESSION['trainee_id'];
                $sql_query = "SELECT * FROM learnbetter_courses WHERE course_assign = $user_id ";

                $sql_result = $conn->query($sql_query);

                if($sql_result->num_rows > 0){
                    // first initiate variable to show number
                    $i = 1;

                    // if priority is trainee, display out in table

                    while ($row = $sql_result->fetch_assoc()) {

                        $train_course_id = $row['id'];
                    
                        echo "<tr>";
                        echo "<td>". $i ."</td>"; 
                        echo "<td>".$row['course_code'] ."</td>"; 
                        echo "<td>".$row['course_name'] ."</td>"; 
                        echo "<td>".$row['course_date_begin'] ."</td>"; 
                        $i++;
                    }

                  }else{
                    echo "<tr>";
                    echo "<td colspan='4'> No Data available</td>"; 
                    echo "</tr>";
                  }
              ?>
            </table>

          </div>

          <div class="table_show_trainer_data_2">
            <h2>Request Training List</h2>

            <table style="width:100%; padding:10px;">
              <tr>
              <!-- Table Title  -->
                  <th>No.</th>
                  <th>Course Code     </th>
                  <th>Course Name     </th>
                  <th>Date Submitted  </th>

              </tr>

              <?php 
                $user_id = $_SESSION['trainee_id'];
                $sql_query = "SELECT * FROM learnbetter_request WHERE req_course_trainee =$user_id ";

                $sql_result = $conn->query($sql_query);

                if($sql_result->num_rows > 0){
                    // first initiate variable to show number
                    $i = 1;

                    // if priority is trainee, display out in table

                    while ($row = $sql_result->fetch_assoc()) {

                        $train_course_id = $row['id'];
                    
                        echo "<tr>";
                        echo "<td>". $i ."</td>"; 
                        echo "<td>".$row['req_course_code'] ."</td>"; 
                        echo "<td>".$row['req_course_name'] ."</td>"; 
                        echo "<td>".$row['req_course_date'] ."</td>"; 
                        echo "</tr>";
                        $i++;
                    }

                  }else{
                        echo "<tr>";
                        echo "<td colspan='4'> No Data available</td>"; 
                        echo "</tr>";
                  }
              ?>
            </table> 
            
          </div>


          <div class="table_show_trainer_data_3">
        
            <h2>Training Completed List</h2>
            <table style="width:100%; padding:10px;">
              <tr>
              <!-- Table Title  -->
                  <th>No.</th>
                  <th>Course Code       </th>
                  <th>Course Name       </th>
                  <th>Date & Time       </th>

              </tr>

              <?php 
                $user_id = $_SESSION['trainee_id'];
                $sql_query = "SELECT * FROM learnbetter_complete_log WHERE complete_course_trainee = $user_id ";

                $sql_result = $conn->query($sql_query);

                if($sql_result->num_rows > 0){
                    // first initiate variable to show number
                    $i = 1;

                    // if priority is trainee, display out in table

                    while ($row = $sql_result->fetch_assoc()) {

                        $train_course_id = $row['id'];
                    
                        echo "<tr>";
                        echo "<td>". $i ."</td>"; 
                        echo "<td>".$row['complete_course_code'] ."</td>"; 
                        echo "<td>".$row['complete_course_name'] ."</td>"; 
                        echo "<td>".$row['complete_date'] ."</td>"; 
                        $i++;
                    }

                  }else{
                      echo "<tr>";
                      echo "<td colspan='4'> No Data available</td>"; 
                      echo "</tr>";
                  }
              ?>
            </table>  
        
          </div>
      </div>
  </div>
  
</section>

</body>
</html>


