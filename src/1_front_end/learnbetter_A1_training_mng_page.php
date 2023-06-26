<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/delete_training_function.php";
    include "../2_back_end/add_training_function.php";
    include "../2_back_end/send_mail_phpmailer.php";

?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>Admin Tempalte</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/learnbetter_A_course_mng_style.css">
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
  <div  class="add_trainee_table_style">
    <h2>Training Course Management</h2><br><br>
    <form method="POST">
      <div class="info_wrapper">
          <div class="trainee_info_style">

            <p>Training Name    : <input type="text" name="training_name_A1"  > </p><br>
            <p>Training Code    : <input type="text" name="training_code_A1" > </p><br>
            <p>Training Pin Number: <input type="text" name="training_pin_A1" >  </p><br>

          </div>

          <div class="trainee_acc_style">
            
            <p>Trainee Assign : <br>
                <select name="training_trainee_assign_A1">
                    <?php 
                        $sql_query = "SELECT id, user_firstname, user_lastname FROM learnbetter_users WHERE user_prio = 1";
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

            <p>Training Duration  : </p>
            <div class="training_time_info">

              <p>Hours  : <input type="number"  name="training_hours"   min="0" max="20"> </p>
              <p>Minutes: <input type="number"  name="training_minute"  min="0" max="59"></p>
             
            </div><br>

            <p>Begining Date & Time :<br> <input type="datetime-local" name="training_date_time" >  </p>
           
          </div>

          <div>
            <button button type="submit" class="btn_add_trainee_style" > Add Course </button> 
          </div>
      </div>
    </form>
    <script>
        // Attach an event listener to the submit button
        document.querySelector('button.btn_add_trainee_style').addEventListener('click', function(event) {
        // Prevent the form from submitting by default
        event.preventDefault();

        // Perform validation checks
        var trainingName = document.querySelector('input[name="training_name_A1"]').value;
        var trainingCode = document.querySelector('input[name="training_code_A1"]').value;
        var trainingPin = document.querySelector('input[name="training_pin_A1"]').value;
        var trainingHours = document.querySelector('input[name="training_hours"]').value;
        var trainingMinutes = document.querySelector('input[name="training_minute"]').value;
        var trainingDateTime = document.querySelector('input[name="training_date_time"]').value;
        
        // Regular Expression
        var alphanumericRegex = /^[a-zA-Z0-9]+$/;

        // Perform validation checks
        if (trainingName.trim() === '') {
          alert("Training Name can't be empty.");
          return;
        }

        if (trainingCode.trim() === '') {
          alert("Training Code can't be empty.");
          return;
        }

        // Probhite user enter any special character pin
        if (!alphanumericRegex.test(trainingCode)) {
          alert("Training Code can only contain numbers and letters.");
          return;
        }
        
        if (trainingPin.trim() === '') {
          alert("Training Pin Number can't be empty.");
          return;
        }

        // Probhite user enter any special character pin
        if (!alphanumericRegex.test(trainingPin)) {
          alert("Training Pin Number can only contain numbers and letters.");
          return;
        }
        
        if (trainingHours.trim() === '' || isNaN(trainingHours) || trainingHours < 0 || trainingHours > 20) {
          alert("Invalid Training Hours, Max 20 hour.");
          return;
        }

        if (trainingMinutes.trim() === '' || isNaN(trainingMinutes) || trainingMinutes < 0 || trainingMinutes > 60) {
          alert("Invalid Training Minutes, Max 59 minute.");
          return;
        }

        if (trainingDateTime.trim() === '') {
          alert("Beginning Date & Time can't be empty.");
          return;
        }

        event.target.form.submit();

      })
    </script>

  </div>

  <!-- Add Trainee Wrapper  -->
  <div class="shw_trainee_table_style">

    <h2>Training Detail Info </h2>

    <table style="width:100%; padding:10px;">
        <tr>
          <!-- Table Title  -->
            <th>No.</th>
            <th>Training Code     </th>
            <th>Training Name     </th>
            <th>Assign Trainee    </th>
            <th>Training Pin Code </th>
            <th>Time Duration     </th>
            <th>Date Register     </th>
            <th>Action            </th>

        </tr>

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

            // Get course id, 
            $train_course_id = $row['id'];

        
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
          echo "There is no data available";
        }
       
       ?>
       
    </table>  
  </div>
  

</section> 

</body>
</html>