<?php
    include "../2_back_end/login_A1_function.php";
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
  <link rel="stylesheet" href="../../css/learnbetter_A_login_style.css">
  
</head>

<body>

  <main>

    <div class="container">

        <div class="login_container_style">
            
        <img src="../../img/learnbetter_logo.png" alt="icondo_logo" class="obj_alg_center">
        <h3 class="login_txt_alg_center">Training Provider Panel</h3><br>
       
        <form method="POST" name="login_form">
            <h5> Username: </h5>

            <input type="text"      name="user_login_username" > <br> 
            
            <!-- Error message Username empty or Less than 4 alphabet length -->
            <div class= "txt_wrong_username_dis" id="login_wrong_username_txt">
              <h5>Wrong or Empty Input <br> Please try again</h5>
            </div>


            <h5> Password: </h5>

            <input type="password"  name="user_login_password" > <br>
            
            <!-- Error message Password empty or Less than 4 alphabet length -->
            <div class= "txt_wrong_password_dis" id="login_wrong_password_txt">
              <h5>Wrong or Empty Input <br> Please try again</h5>
            </div>

            <button type="submit" class="login_btn_style">Login In</button>
            
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