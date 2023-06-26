<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/delete_training_function.php";
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>Admin Tempalte</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="../../css/dashboard_admin_temp_style.css">
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
                }elseif($_SESSION['user_gen'] === "Female"){
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
          <li> Created Training : <?php echo dis_num_course($conn);?></li>
        </ul>
    </div>

    <?php include "../4_component/A1_sidebar.php"; ?>
    
</div>
<!-------------------------------------------Table Info Style ---------------------------------------------- -->
  <section> 
        <!---------------------- Small number Dashboard Menu ------------------------------>
        <div  class="num_dis_style">

            <div class="dboard_design">     
                <p>Training Organized</p>
                <br>
                <p class="count_num_style"><?php echo dis_num_course($conn);?></p>  
            </div>  

            <div class="dboard_design"> 
                <p>Trainer Members</p>
                <br>
                <p class="count_num_style"><b><?php echo dis_num_trainee($conn); ?></b></p>
            </div>  

            <div class="dboard_design">
                <p>Candidate Members</p>
                <br>
                <p class="count_num_style"><b><?php echo dis_num_candidate($conn); ?></b></p>
            </div>  

            <div class="dboard_design">
                <p>Training Request </p>
                <br>
                <p class="count_num_style"><b><?php echo dis_num_course_pending($conn)?></b></p>
            </div> 

        </div>

        

        <!-- Trainee Display Table Menu -->
        <div class="table_trainee_menu">
            <h2>Trainer Info</h2>
            <table style="width:100%; padding:10px;">
                <tr>
                    <th>No.</th>
                    <th>Trainer </th>
                    <th>Course Handel</th>
                </tr>

                <?php 

                    $sql_trainee_query = "SELECT * FROM `learnbetter_users` WHERE user_prio = 1";

                    $num_trainee = $conn->query($sql_trainee_query);

                    if($num_trainee->num_rows > 0){  
                        $i = 1;     

                        while($row = $num_trainee->fetch_assoc()) {
    
                            echo "<tr>";
                            echo "<td>". $i ."</td>"; 
                            echo "<td>".$row['user_firstname'] ." ".$row['user_lastname']."</td>"; 
                            echo "<td> <b>".$row['trainee_course'] ."</b></td>"; 
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

        <!-- Candidate Dashboard Menu -->
        <div class="table_candidate_menu">
            <h2>Candidate Info</h2>
            <table style="width:100%; padding:10px;">
                <tr>
                    <th>No.</th>
                    <th>Candidate </th>
                    <th>Course Enrollment</th>
                </tr>
                <?php 

                    $sql_candidate_query = "SELECT * FROM `learnbetter_users` WHERE user_prio = 2";
                    $num_candidate = $conn->query($sql_candidate_query);

                    if($num_candidate->num_rows > 0){  
                        $i = 1;     

                        while($row = $num_candidate->fetch_assoc()) {
    
                            echo "<tr>";
                            echo "<td>". $i ."</td>"; 
                            echo "<td>".$row['user_firstname'] ."</td>"; 
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

        <!-- All Training Info Dashboard Menu -->
        <div class="table_course_menu">
            <h2>All Training Info </h2>
            <table style="width:100%; padding:10px;">
                <tr>
                    <th>No.</th>
                    <th>Training Code </th>
                    <th>Training Name</th>
                    <th>Date Register </th>
                    <th>Trainer  </th>     
                </tr>
                <?php 


                    $sql_training_query= "SELECT learnbetter_users.user_firstname, learnbetter_users.user_lastname, 
                                            learnbetter_courses.course_code, learnbetter_courses.course_name, 
                                            learnbetter_courses.course_pin, learnbetter_courses.course_time_duration, 
                                            learnbetter_courses.course_date_begin
                                            FROM learnbetter_users 
                                            JOIN learnbetter_courses ON learnbetter_users.id = learnbetter_courses.course_assign;";

                    $training_query_result = $conn->query($sql_training_query);

                   
                    if($training_query_result->num_rows > 0){  
                        $i = 1;     

                        while($row = $training_query_result->fetch_assoc()) {

                            echo "<tr>";
                            echo "<td>". $i ."</td>"; 
                            echo "<td>".$row['course_code'] ."</td>"; 
                            echo "<td>".$row['course_name'] ."</td>"; 
                            echo "<td>".$row['course_date_begin'] ."</td>";    
                            echo "<td>".$row['user_firstname']." ".$row['user_lastname']."</td>"; 
                            echo "</tr>";   
                            $i++;           
                        }
                    }else{
                        echo "<tr >";
                        echo "<td colspan= 5> No Data is Available</td>"; 
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        
        <!-- Detail Training Dashboard Menu -->
        <div class="crud_course_table_menu">
            <h2>Training Detail Info </h2>
            <table style="width:100%; padding:10px;">
            <tr>
            <!-- Table Title  -->
                <th>No.</th>
                <th>Training Code     </th>
                <th>Training Name     </th>
                <th>Assign Trainer    </th>
                <th>Training Pin Code </th>
                <th>Training Vacant   </th>
                <th>Date Register     </th>
                <th>Action            </th>

            </tr>

            <!-- ALL DATA PERFORM BELOW   -->
            <?php 
                // Join table in order to use the 
                $sql_trainee_query= "SELECT learnbetter_users.user_firstname, learnbetter_users.user_lastname, learnbetter_courses.id, learnbetter_users.id AS user_id,
                                    learnbetter_courses.course_code, learnbetter_courses.course_name, 
                                    learnbetter_courses.course_pin, learnbetter_courses.course_time_duration, 
                                    learnbetter_courses.course_date_begin
                                    FROM learnbetter_users 
                                    JOIN learnbetter_courses ON learnbetter_users.id = learnbetter_courses.course_assign;";

                $trainee_query_result = $conn->query($sql_trainee_query);

                if($trainee_query_result->num_rows > 0){
                // first initiate variable to show number
                $i = 1;

                // if priority is trainee, display out in table

                while ($row = $trainee_query_result->fetch_assoc()) {

                    $train_course_id = $row['id'];
                
                    echo "<tr>";
                    echo "<td>". $i ."</td>"; 
                    echo "<td>".$row['course_code'] ."</td>"; 
                    echo "<td>".$row['course_name'] ."</td>"; 
                    echo "<td>".$row['user_firstname']." ".$row['user_lastname']."</td>"; 
                    echo "<td>".$row['course_pin']  ."</td>"; 
                    echo "<td>".convert_hour_minute($row['course_time_duration']) ."</td>"; 
                    echo "<td>".$row['course_date_begin'] ."</td>"; 
                    
                    // Training Detail Dashboard Action Button 
                    echo '<td>
                            <button class="btn_style_2">
                                <a href="../1_front_end/learnbetter_A1_update_training_page.php?trainId='.$train_course_id.'" style="color:white;">Update </a>
                            </button>
                            
                            <button class="btn_style_3">
                                <a href="../2_back_end/delete_training_function.php?delete_trainId='.$train_course_id.'&trainee_Id='.$row['user_id'].'" style="color:white;">Delete</a>
                            </button>
                          </td>';
                    echo "</tr>";

                    // increase counter
                    $i++;
                }

                }else{
                    echo "<tr >";
                    echo "<td colspan= 7> No Data is Available</td>"; 
                    echo "</tr>";
                }
            
            ?>
            
            </table> 
        </div>

  </section> 
</body>
</html>