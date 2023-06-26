<?php   
   include "../2_back_end/check_login.php";  
   include "../2_back_end/login_reset_password_function.php";
   
   $pass_token = null;

   if(isset($_GET['token'])){
        $pass_token = $_GET['token'];
    }

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
  <link rel="stylesheet" href="../../css/learnbetter_reset_password_style.css">

</head>

<body>

  <main>

    <div class="container">

        <div class="login_container_style">
            
            <img src="../../img/learnbetter_logo.png" alt="icondo_logo" class="obj_alg_center">
            <h3 class="login_txt_alg_center">Reset Account Password</h3><br>
        
            <form method="POST" autocomplete="off">

                <!-- Input Username + hold previous value if enter wrong -->
                <h5> New Password :</h5>
                <input type="text" name="user_forget_pass_new" placeholder="6 digit min"> <br>
                
                <h5> Confirm Password :</h5>
                <input type="text" name="user_forget_pass_conf" placeholder="6 digit min"> <br>
                
                <input type="hidden" name="user_forget_pass_token" value="<?php echo $pass_token; ?>">

                <button type="submit" class="login_btn_style">Reset Password</button>
            
            </form>
    
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