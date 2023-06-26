<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/approve_trainee_course_function.php";

?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>Admin Tempalte</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/learnbetter_A_course_approv_style.css">
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
          <li> Created Course : </li>
        </ul>
    </div>

    <?php include "../4_component/A1_sidebar.php"; ?>
    
  </div>


  <section> 
  
  <!-- Add Trainee Wrapper  -->
  <div class="shw_trainee_table_style">

    <h2>Trainer Course Request List </h2>
    
    <table style="width:100%; padding:10px;">
    <tr>
        <!-- Table Title  -->
          <th>No.</th>
          <th>Training Code       </th>
          <th>Training Name       </th>
          <th>Trainer Request     </th>
          <th>Training Pin        </th>
          <th>Time Duration       </th>
          <th>Create Date & Time  </th>
          <th>Action              </th>

      </tr>
    <?php 
      
      $sql_trainee_query= "SELECT * FROM  learnbetter_request ";

      $sql_result = $conn ->query($sql_trainee_query);

      if($sql_result){

        $i = 1;
        
          while ($row = $sql_result->fetch_assoc()) {

            // Get course id, 
            $req_course_id = $row['id'];
            $req_course_trainee_id = $row['req_course_trainee'];

            echo "<tr>";
            echo "<td>". $i ."</td>"; 
            echo "<td>".$row['req_course_code'] ."</td>"; 
            echo "<td>".$row['req_course_name'] ."</td>"; 
            echo "<td>".get_trainee_name($conn,  $row['req_course_trainee'])."</td>"; 
            echo "<td>".$row['req_course_pin']  ."</td>"; 
            echo "<td>".convert_hour_minute($row['req_course_time']) ."</td>"; 
            echo "<td>".$row['req_course_begin_date_time'] ."</td>";

            echo '<td>
            
                    <button class="btn_style_2">
                      <a href="../2_back_end/approve_trainee_course_function.php?approve_courseId='.$req_course_id .'&tmp_trainee_email= '.$req_course_trainee_id .'" style="color:white;">Approve</a>
                    </button>

                    <button class="btn_style_3">
                      <a href="../2_back_end/delete_trainee_course_function.php?delete_courseId='.$req_course_id .'" style="color:white;">Delete</a>
                    </button>           
                  
                    
                  </td>
                  ';

                  
            echo "</tr>";
            
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

