<?php
    include "../2_back_end/register_function.php";
?>

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <!-- CSS external style -->
  <link rel="stylesheet" href="../../css/learnbetter_register_style.css">

  <?php 
   
   // If variable have value, display error message 

    if($error_msg_firstname != null){
      ?> <style> .error_req_firstname {display: block}</style><?php
    }
    
    if($error_msg_lastname  != null){
      ?> <style> .error_req_lastname {display: block}</style><?php
    }
    
    // if gender + priority value is unkonwn, display error message (*Because gender default value is Unknown)
    if($error_msg_gender === "Gender is missing"){
      ?> <style> .error_req_gender {display: block}</style><?php
    }

    if($error_msg_priority === "Priority is missing"){
      ?> <style> .error_req_priority {display: block}</style><?php
    }
    
    if($error_msg_email != null){
      ?> <style> .error_req_email {display: block}</style><?php
    }

    if($error_msg_username != null){
      ?> <style> .error_req_username {display: block}</style><?php
    }
    
    if($error_msg_password != null){
      ?> <style> .error_req_password {display: block}</style><?php
    }

    
  ?>

</head>

<body>

  <main>

    <div class="container">
  
        <div class="reg_container_style">
          
        <!-- Logo & Title  -->
        <img src="../../img/learnbetter_logo.png" alt="icondo_logo" class="obj_alg_center">
        <h3 class="login_txt_alg_center">Learn With Us Now</h3><br>
       
        
        <form method="POST" name="reg_form" autocomplete="off">

          <h5> First-name: </h5>

          <input type="text"      name="user_reg_firstname" placeholder="e.g. Wen Fung" value=<?php echo $reg_firstname; ?>> <br>
          
          <!-- Error messsage first-name -->
          <div class="alert alert-danger error_req_firstname" role="alert"> <?php echo $error_msg_firstname; ?></div>
          

          <h5> Last-Name: </h5>

          <input type="text"      name="user_reg_lastname" placeholder="e.g. Lee" value=<?php echo $reg_lastname; ?>> <br> 
          
          <!-- Error messsage last-name -->
          <div class="alert alert-danger error_req_lastname" role="alert"> <?php echo $error_msg_lastname; ?> </div>
          
          <h5> Gender: </h5>
          
          <input type="radio"     name="user_reg_gender" value="Male"> <label class="reg_radio_style"> Male </label>
          
          <input type="radio"     name="user_reg_gender" value="Female"> <label class="reg_radio_style"> Female </label>  
          
          <!-- Error messsage gender -->
          <div class="alert alert-danger error_req_gender" role="alert"> <?php echo $error_msg_gender; ?></div>
          

          <h5> Position : </h5>
          
          <input type="radio"     name="user_reg_priority" value="1"> <label class="reg_radio_style"> Trainee </label>
          
          <input type="radio"     name="user_reg_priority" value="2"> <label class="reg_radio_style"> Candidate </label>
          
          <!-- Error messsage priority -->
          <div class="alert alert-danger error_req_priority" role="alert"> <?php echo $error_msg_priority; ?></div>

            
          <h5> Email: </h5>

          <input type="email"     name="user_reg_email" placeholder="example@gmail.com" value=<?php echo $reg_email; ?>> <br> 

          <!-- Error messsage e-mail -->
          <div class="alert alert-danger error_req_email" role="alert"> <?php echo $error_msg_email; ?> </div>
          
            
          <h5> Username: </h5>

          <input type="text"      name="user_reg_username" value=<?php echo $reg_username; ?>> <br> 

          <!-- Error messsage username -->
          <div class="alert alert-danger error_req_username" role="alert" > <?php echo $error_msg_username; ?> </div>
          

          <h5> Password: </h5>

          <input type="text"      name="user_reg_password" value=<?php echo $reg_password; ?>> <br> 
          
          <!-- Error messsage password -->
          <div class="alert alert-danger error_req_password" role="alert" > <?php echo $error_msg_password; ?> </div>
          

          <button type="submit" class="reg_btn_style">Register Now </button>
        </form>
        
         <a href="../1_front_end/learnbetter_login_page.php" class="reg_return_login_link_style"> Click here to login </a>
          
        </div>
    </div>

  </main>

  <footer>
    <?php include "../4_component/footer.php" ?>
  </footer>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>