<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/send_mail_trainee_create_phpmailer.php";
    include "../2_back_end/add_trainee_function.php";
    include "../2_back_end/delete_trainee_function.php";

?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>Admin Tempalte</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/laernbetter_A_trainee_mng_style.css">
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
          <li> Course Created : <?php echo dis_num_course($conn);?></li>
        </ul>
    </div>

    <?php include "../4_component/A1_sidebar.php"; ?>
    
  </div>

  <section> 

    <!-- Add Trainee Wrapper  -->
    <div  class="add_trainee_table_style">
      <h2>Add New Trainer Account</h2><br><br>

      <form method="POST">
        <div class="info_wrapper">
            <div class="trainee_info_style">

              <p>Firstname : <input type="text" name="upd_acc_firstN_A1" > </p><br>
              <p>Lastname  : <input type="text" name="upd_acc_lastN_A1"  > </p><br>
              <p>User Mail : <input type="text" name="upd_acc_mail_A1" placeholder="example@gmail.com">  </p><br>
              <p>User Gender   : 
                <input type="radio"   name="upd_acc_gen_A1" value="Male"> <label class="radio_font_size"> Male </label>    
                <input type="radio"   name="upd_acc_gen_A1" value="Female"> <label class="radio_font_size"> Female </label>  
              </p><br>

            </div>

            <div class="trainee_acc_style">

              <p>Username  : <input type="text" name="upd_acc_name_A1" > </p><br>
              <p>Password  : <input type="text" name="upd_acc_pass_A1" placeholder="*min 6 password length"> </p><br>
          
              <button type="submit" class="btn_add_trainee_style"> Add Trainee </button> 

            </div>

        </div>
      </form>

      <script>
        // Attach an event listener to the submit button
        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
          // Prevent the form from submitting by default
          event.preventDefault();

          // Perform validation checks
          var firstName = document.querySelector('input[name="upd_acc_firstN_A1"]').value;
          var lastName = document.querySelector('input[name="upd_acc_lastN_A1"]').value;
          var email = document.querySelector('input[name="upd_acc_mail_A1"]').value;
          var gender = document.querySelector('input[name="upd_acc_gen_A1"]:checked');
          var username = document.querySelector('input[name="upd_acc_name_A1"]').value;
          var password = document.querySelector('input[name="upd_acc_pass_A1"]').value;

          // Perform validation checks
          if (firstName.trim() === '') {
            alert("First name can't be empty.");
            return;
          }

          if (lastName.trim() === '') {
            alert("Last name can't be empty.");
            return;
          }

          // Handling Email 
          if (!email.trim() || !validateEmail(email)) {
            alert("Empty or Invalid email address.");
            return;
          }

          if (!gender) {
            alert("Please select a gender.");
            return;
          }

          if(username.trim() === ""){
            alert("Username can't be empty.");
            return;
          }

          if(password.trim() === "" && password.length < 6){
            alert("Invalid, Password less than 6 character or empty");
            return;
          }

          event.target.form.submit();
        });

        // funtction to validate email input
        function validateEmail(email) {
          var re = /\S+@\S+\.\S+/;
          return re.test(email);
        }
        
      </script>
  </div>

  <!-- Add Trainee Wrapper  -->
  <div class="shw_trainee_table_style">

    <h2>Trainer Account Information </h2>

    <table style="width:100%; padding:10px;">
        <tr>
          <!-- Table Title  -->
            <th>No.</th>
            <th>First-name </th>
            <th>Last-name  </th>
            <th>User Mail  </th>
            <th>User Gender</th>
            <th>Username   </th>
            <th>Password   </th>
            <th>Action     </th>

        </tr>

        </a>

        <a href="../1_front_end/learnbetter_A1_update_trainee_page.php"></a>

        <!-- ALL DATA PERFORM BELOW   -->
       <?php 

        $sql_trainee_query = "SELECT * FROM `learnbetter_users`";
        $trainee_query_result = $conn->query($sql_trainee_query);

        if($trainee_query_result->num_rows > 0){
          // first initiate variable to show number
          $i = 1;

          // if priority is trainee, display out in table
          while ($row = $trainee_query_result->fetch_assoc()) {
            
            $trainee_id         = $row['id'];
           
            if($row['user_prio'] == "1"){
              echo "<tr>";
              echo "<td>". $i ."</td>"; 
              echo "<td>".$row['user_firstname'] ."</td>"; 
              echo "<td>".$row['user_lastname'] ."</td>"; 
              echo "<td>".$row['user_email'] ."</td>"; 
              echo "<td>".$row['user_gender'] ."</td>"; 
              echo "<td> <b>".$row['user_username'] ." </b></td>"; 
              echo "<td> <b>".$row['user_password'] ."</b></td>"; 

              // Assign number to ensure  
              echo '<td>
                    <button class="btn_style_2">
                     <a href="../1_front_end/learnbetter_A1_update_trainee_page.php?updateid='.$trainee_id.'" style="color:white;">Update</a>
                    </button>
                    
                    <button class="btn_style_3">
                      <a href="../2_back_end/delete_trainee_function.php?deleteid='.$trainee_id.'" style="color:white;">Delete</a>
                    </button>
                    </td>';
              echo "</tr>";
              // increase counter
              $i++;

            } 
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