<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/trainee_request_course_function.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>User Template</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/learnbetter_B_request_course_style.css">
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

   <div  class="add_trainee_table_style">
    <h2>Training Course Management</h2><br><br>
    <form method="POST">
      <div class="info_wrapper">
          <div class="trainee_info_style">

            <p>Training Name    : <input type="text" name="request_name"  > </p><br>
            <p>Training Code    : <input type="text" name="request_code" > </p><br>
            <p>Training Pin Number: <input type="text" name="request_pin" >  </p><br>

          </div>

          <div class="trainee_acc_style">

            <p>Training Duration  : </p>
            <div class="training_time_info">

              <p>Hours  : <input type="number"  name="request_hours"   min="0"  max="20"> </p>
              <p>Minutes: <input type="number"  name="request_minute"  min="0" max="59"></p>
             
            </div><br>

            <p>Beginning Date & Time :<br> <input type="datetime-local" name="request_date_time" >  </p>
           
          </div>
            
          <input type="hidden" name="request_trainee_id" value="<?php echo $_SESSION['trainee_id']; ?>">
          <div>
            <button button type="submit" class="btn_add_trainee_style" > Submit Request  </button> 
          </div>
      </div>
    </form>

    <script>
        // Attach an event listener to the submit button
        document.querySelector('button.btn_add_trainee_style').addEventListener('click', function(event) {
        // Prevent the form from submitting by default
        event.preventDefault();

        // Perform validation checks
        var requestName     = document.querySelector('input[name="request_name"]').value;
        var requestCode     = document.querySelector('input[name="request_code"]').value;
        var requestPin      = document.querySelector('input[name="request_pin"]').value;
        var requestHours    = document.querySelector('input[name="request_hours"]').value;
        var requestMinutes  = document.querySelector('input[name="request_minute"]').value;
        var requestDateTime = document.querySelector('input[name="request_date_time"]').value;

        // Regular Expression
        var alphanumericRegex = /^[a-zA-Z0-9]+$/;

        // Perform validation checks
        if (requestName.trim() === '') {
          alert("Training Name can't be empty.");
          return;
        }

        if (requestCode.trim() === '') {
          alert("Training Code can't be empty.");
          return;
        }

        // Probhite user enter any special character pin
        if (!alphanumericRegex.test(requestCode)) {
          alert("Training Code can only contain numbers and letters.");
          return;
        }
        
        if (requestPin.trim() === '') {
          alert("Training Pin Number can't be empty.");
          return;
        }

        // Probhite user enter any special character pin
        if (!alphanumericRegex.test(requestPin)) {
          alert("Training Pin Number can only contain numbers and letters.");
          return;
        }
        
        if (requestHours.trim() === '' || isNaN(requestHours) || requestHours < 0 || requestHours > 20) {
          alert("Invalid Training Hours, Max 20 hour.");
          return;
        }

        if (requestMinutes.trim() === '' || isNaN(requestMinutes) || requestMinutes < 0 || requestMinutes > 60) {
          alert("Invalid Training Minutes, Max 59 minute.");
          return;
        }

        if (requestDateTime.trim() === '') {
          alert("Beginning Date & Time can't be empty.");
          return;
        }

        event.target.form.submit();

      })
    </script>

  </div>

  <div class="view_train_asign_table">
    <h2>Newly Created Course</h2>
    <table style="width:100%; padding:10px;">
      <tr>
        <!-- Table Title  -->
          <th>No.</th>
          <th>Course Code         </th>
          <th>Course Name         </th>
          <th>Handled By          </th>
          <th>Course Pin Number   </th>
          <th>Course Duration     </th>
          <th>Date & Time Created </th>
          <th>Action              </th>

      </tr>
    <?php 
      // Join table in order to use the 
      $get_trainee_id = $_SESSION['trainee_id'];
      
      $sql_trainee_query= "SELECT learnbetter_users.user_firstname, learnbetter_users.user_lastname, learnbetter_request.id, 
                          learnbetter_users.id AS user_id, 
                          learnbetter_request.req_course_code, 
                          learnbetter_request.req_course_name, 
                          learnbetter_request.req_course_trainee,
                          learnbetter_request.req_course_time,
                          learnbetter_request.req_course_pin,
                          learnbetter_request.req_course_begin_date_time

                          FROM learnbetter_users 
                          JOIN learnbetter_request ON learnbetter_users.id = learnbetter_request.req_course_trainee
                          WHERE learnbetter_request.req_course_trainee = $get_trainee_id;
                          ";
      $sql_result = $conn ->query($sql_trainee_query);

      if($sql_result){

        $i = 1;
        
          while ($row = $sql_result->fetch_assoc()) {

            // Get course id, 
            $train_course_id = $row['id'];

        
            echo "<tr>";
            echo "<td>". $i ."</td>"; 
            echo "<td>".$row['req_course_code'] ."</td>"; 
            echo "<td>".$row['req_course_name'] ."</td>"; 
            echo "<td>".$row['user_firstname']." ".$row['user_lastname']."</td>"; 
            echo "<td>".$row['req_course_pin']  ."</td>"; 
            echo "<td>".convert_hour_minute($row['req_course_time']) ."</td>"; 
            echo "<td>".$row['req_course_begin_date_time'] ."</td>";
            
            echo '<td>
                    <button class="btn_style_2">
                      <a href="" style="color:white;">Delete</a>
                    </button>
                    
                  </td>';
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