<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/approve_candit_hour_function.php";
 
    $temp_course_code = null;
    $temp_course_name = null;
    
    if(isset($_GET['candi_course_code']) && isset($_GET['candi_course_name'])){
        $temp_course_code = $_GET['candi_course_code'];
        $temp_course_name = $_GET['candi_course_name'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>User Template</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/learnbetter_B_candit_list_style.css ">
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

        <br>
        <h2>Candidate Course Approvel List </h2> 
               
        <table style="width:100%; padding:10px;">
            <tr>
                <!-- Table Title  -->
                
                <th>No.</th>
                <th>Candidate Name                </th>
                <th>Candidate Email               </th>
                <th>Candidate Enroll Date & Time  </th>
                <th><button type="button"  id="checkAllButton" class="btn_style_3">Check All</button></th>
            </tr>

            <script>

            var checkAllButton = document.getElementById("checkAllButton");
            checkAllButton.addEventListener("click", function() {
                var checkboxes = document.querySelectorAll("input[name='checkbox_group[]']");
                var allChecked = true;

                checkboxes.forEach(function(checkbox) {
                if (!checkbox.checked) {
                    allChecked = false;
                    checkbox.checked = true;
                }
                });

                if (allChecked) {
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
                }
            });
            </script>

    <form method="POST">
        <button type="submit" class="btn_style_2">
                Approve Candidate
        </button>
         
        <?php 
                
        $sql_trainee_query= "SELECT learnbetter_enrollment.enroll_course_code, learnbetter_enrollment.enroll_candi_name,learnbetter_enrollment.enroll_candi_id,
                                learnbetter_enrollment.enroll_date_time, learnbetter_users.user_email      
                                FROM learnbetter_enrollment
                                JOIN learnbetter_users ON learnbetter_users.id = learnbetter_enrollment.enroll_course_trainee
                                WHERE learnbetter_enrollment.enroll_course_code = '$temp_course_code' && learnbetter_enrollment.enroll_course_name = '$temp_course_name' ";

        $sql_result = $conn ->query($sql_trainee_query);

        if($sql_result){

            $i = 1;
            
            while ($row = $sql_result->fetch_assoc()) {

            // Get course id, 
        
            echo "<tr>";
            echo "<td>". $i ."</td>"; 
            echo "<td>".$row['enroll_candi_name'] ."</td>"; 
            echo "<td>".$row['user_email'] ."</td>"; 
            echo "<td>".$row['enroll_date_time'] ."</td>"; 
            echo "<td> <input type='checkbox' name='checkbox_group[]' value=".$row['enroll_candi_id']."></td>";

            $i++;
            }

        }else{
            echo "There is no data fetching back ". $conn->error;
        }
        ?>

        <input type="hidden" name="approve_course_code"  value="<?php echo $temp_course_code ; ?>">
        <input type="hidden" name="approve_course_name"  value="<?php echo $temp_course_name ; ?>">

        </table>
    </form>
  </div>
  
</section>

</body>
</html>