<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/send_mail_candidate_phpmailer.php"
    // include "../2_back_end/delete_training_function.php";
    // include "../2_back_end/send_mail_phpmailer.php";
    // include "../2_back_end/add_training_function.php";
    //include "../../success_direct.php";

    //include "../2_back_end/add_trainee_function.php";
    //include "../2_back_end/delete_trainee_function.php";
    //check_login();
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>Admin Tempalte</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/learnbetter_A_candidate_mng_style.css">
</head>

<body>
  
  <input type="checkbox" id="check">
   <label for="check">
      <i class="fas fa-bars " id="menu_btn"> </i>
      <i class="fas fa-times " id="menu_cancel"> </i>  
   </label>
  
  <!-- Sidebar -->
  <div class="sidebar-wrapper"> 

    <header><img src="../../img/learnbetter_logo.png" style="height:50px; width:50px; margin-top: 10px;" alt="logo_img"> LearnBetter </header>

    <div class="sidebar-acc-wrapper">
      <img src="data:image;base64, <?php echo base64_encode( dis_admin_acc_img($conn, $_SESSION['admin_id'])); ?>" style="height:90px; width:90px;" alt="img_user"> 
        <h4> 
            <?php 
                if($_SESSION['admin_gen'] === "Male"){
                    echo " Mr. ".$_SESSION["admin_firstN"];
                }elseif($_SESSION['admin_gen'] === "Female"){
                    echo " Ms. ".$_SESSION["admin_firstN"];
                }
            ?> 
        </h4><br>

        <ul class="sidebar-acc-post">
          <li> Position : 
            <?php 
                if(isset($_SESSION['admin_level']) && $_SESSION['admin_level'] == 0 ){
                    echo "<b>Admin</b>";
                }else{
                    echo "No Position";
                }
            ?>
          </li> <br>
          <!-- Show number of course taken -->
          <li> Created Course : </li>
        </ul>
    </div>

    <?php include "../4_component/A1_sidebar.php"; ?>
    
  </div>

  <!-- Code Start Here -->
  <section> 
  
  <!-- Add Trainee Wrapper  -->
  <div  class="add_trainee_table_style">

    <h2>Candidate Assign Management</h2><br><br>
  
    <form method="POST">
      <div class="info_wrapper">
        <div class = "table_trainee_menu" >
              <h2>Candidate Total Course</h2>
              <table style="width:100%; padding:10px;" >
                  <tr>
                      <th>No.</th>
                      <th>Candidate Name</th>
                      <th>Amount Training Attend</th>
                  </tr>
                  <?php 

                      $sql_candidate_query = "SELECT * FROM `learnbetter_users` WHERE user_prio = 2";
                      $num_candidate = $conn->query($sql_candidate_query);

                      if($num_candidate->num_rows > 0){  
                          $i = 1;     

                          while($row = $num_candidate->fetch_assoc()) {
      
                              echo "<tr>";
                              echo "<td>". $i ."</td>"; 
                              echo "<td>".$row['user_firstname']." ".$row['user_lastname']."</td>"; 
                              echo "<td> <b>".$row['candidate_course'] ."</b></td>"; 
                              echo "</tr>";
                              $i++;                       
                          }
                      }else{
                          echo "<tr >";
                          echo "<td colspan= 3> No Data is Available</td>"; 
                          echo "</tr>";
                      }
                  ?>
              </table>
         </div>
          
        <div class="trainee_acc_style">
          
          <p>Training Course Select  : <br>
              <select name="send_email_course_id">
                  <?php 
                      $sql_query = "SELECT course_code, course_name FROM learnbetter_courses ";
                      $sql_result = $conn->query($sql_query);
                      
                      if($sql_result->num_rows > 0){
                          while($row = $sql_result->fetch_assoc()){
                            echo "<option value=".$row["course_code"].">".$row["course_name"]."</option>";
                          }

                      }else{
                          echo "No data is been retrieve";
                      }
                  ?>
              </select>
          </p><br>

          <p>Candidate Select  : <br>
              <select name="send_email_candi_id">
                  <?php 
                      $sql_query = "SELECT id, user_firstname, user_lastname FROM learnbetter_users WHERE user_prio = 2";
                      $sql_result = $conn->query($sql_query);
                      
                      if($sql_result->num_rows > 0){
                          while($row = $sql_result->fetch_assoc()){
                            echo "<option value=".$row["id"].">".$row["user_firstname"]." ".$row["user_lastname"]."</option>";
                          }

                      }else{
                          echo "No data is been retrieve";
                      }
                  ?>
              </select>
          </p><br>
          
          <button button type="submit" class="btn_add_trainee_style" > Send Email  </button> 
        </div>
          
      </div>
    </form>
  </div>

  <!-- Add Trainee Wrapper  -->
  <div class="shw_trainee_table_style">

    <h2>Send Mail History </h2>
    
    <table style="width:100%; padding:10px;">
        <tr>
          <!-- Table Title  -->
            <th>No.</th>
            <th>Training Code     </th>
            <th>Training Name     </th>
            <th>Trainer Handle    </th>
            <th>Candidate Send    </th>
            <th>Date Send         </th>

        </tr>

        <!-- ALL DATA PERFORM BELOW   -->
       <?php 
        // Join table in order to use the 
        $sql_trainee_query= "SELECT * FROM learnbetter_email_log";

        $trainee_query_result = $conn->query($sql_trainee_query);

        if($trainee_query_result->num_rows > 0){
          // first initiate variable to show number
          $i = 1;

          // if priority is trainee, display out in table

          while ($row = $trainee_query_result->fetch_assoc()) {
        
            echo "<tr>";
            echo "<td>". $i ."</td>"; 
            echo "<td>".$row['email_log_code'] ."</td>"; 
            echo "<td>".$row['email_log_name'] ."</td>"; 
            echo "<td>".get_trainee_name($conn, $row['email_log_trainee']) ."</td>"; 
            echo "<td>".get_candi_name($conn, $row['email_log_candi'])."</td>"; 
            echo "<td>".$row['email_log_send_date_time'] ."</td>"; 
        
            // increase counter
            $i++;
          }

        }else{
          echo "There is no data available";
        }
       
       ?>
       
    </table>  
  </div>
  

</section> 

</body>
</html>

