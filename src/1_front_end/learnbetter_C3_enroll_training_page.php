<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/check_course_pin_function.php"
    // check_login();
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
          <!-- Show number of course taken -->
          <li> 
            Total Course : <?php echo dis_num_trainee_handle_course($conn, $_SESSION["user_id"]); ?>
          </li>
        </ul>
    </div>

    <?php include "../4_component/C3_sidebar.php"; ?>
    
  </div>

 <section> 

  <div class="candi_enroll_table">
    
    <h2>Training Enrollment Section</h2>

    <hr>
    
    <div class="course_enroll_wrapper">
      
      <form method="POST">

        <p> Training Code : </p>
        <input type="text" name="candi_training_code" >

        <p> Pin Number : </p>
        <input type="text" name="candi_training_pin">
        
        <button type="submit" class="btn_style_3"> Submit Code </button>

      </form>

      <script>
         
        // Attach an event listener to the submit button
        document.querySelector('button.btn_style_3').addEventListener('click', function(event) {
        // Prevent the form from submitting by default
        event.preventDefault();

        // Perform validation checks
        var enrollCode = document.querySelector('input[name="candi_training_code"]').value;
        var enrollPin  = document.querySelector('input[name="candi_training_pin"]').value;
 
        // Regular Expression
        var alphanumericRegex = /^[a-zA-Z0-9]+$/;

        // Perform validation checks
        if (enrollCode.trim() === '') {
          alert("Invalid course code, please renter correct code.");
          return;
        }

        // Probhite user enter any special character pin
        if (!alphanumericRegex.test(enrollCode)) {
          alert("Special Character is invalid, please renter correct code.");
          return;
        }

         // Perform validation checks
         if (enrollPin.trim() === '') {
          alert("Invalid pin number, please renter correct pin.");
          return;
        }

        // Probhite user enter any special character pin
        if (!alphanumericRegex.test(enrollPin)) {
          alert("Special Character is invalid, please renter correct pin number.");
          return;
        }

        event.target.form.submit();
      })

      </script>

    </div>

  </div>
  
</section>

</body>
</html>