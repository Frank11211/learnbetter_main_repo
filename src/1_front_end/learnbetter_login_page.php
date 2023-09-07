<?php
    include "../2_back_end/login_function.php";
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
  <link rel="stylesheet" href="../../css/learnbetter_login_style.css">

  <?php 

    if($username_error != null){
      ?> <style> .error_msg_user {display: block}</style><?php
    }
    
    if($password_error != null){
      ?> <style> .error_msg_pass {display: block}</style><?php
    }

  ?>
  

</head>

<body>

  <main>

    <div class="container">

        <div class="login_container_style">
            
        <img src="../../img/learnbetter_logo.png" alt="icondo_logo" class="obj_alg_center">
        <h3 class="login_txt_alg_center">Let's Learn Better</h3><br>
       
        <form method="POST" name="login_form" autocomplete="off">

            <!-- Input Username + hold previous value if enter wrong -->
            <h5> Username: </h5>
            <input type="text"      name="user_login_username"  value =<?php echo $check_username ?>> <br> 
            
            <!-- Error messsage username -->
            <div class="alert alert-danger error_msg_user" role="alert">
              <?php echo $username_error ?>
            </div>
            
            <h5> Password: </h5>
            <input type="password"  name="user_login_password" value =<?php echo $check_password ?>> <br>
            
            <!-- Error message password -->
            <div class="alert alert-danger error_msg_pass" role="alert">
              <?php echo $password_error ?>
            </div>

            <button type="submit" class="login_btn_style">Login</button>

        </form>
        
        <button class="reg_btn_style" onclick= myRegisterPage() >Sign Up Now</button>
        
        <!-- Function to direct to register account page "learnbetter_register_page.php" -->
        <script>
            function myRegisterPage() {
                window.location = "../1_front_end/learnbetter_register_page.php";
            }
        </script>

        <a href="../1_front_end/learnbetter_forget_pass_page.php" class="bold_link_style ">Forget Password ?</a>
    
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