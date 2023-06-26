<?php   
    include "../2_back_end/send_mail_forget_password.php";

    // function to just generate random string token
    function gen_rand_str($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        $maxIndex = strlen($characters) - 1;
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $maxIndex)];
        }

        return $randomString;
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
  <link rel="stylesheet" href="../../css/learnbetter_forget_pass_style.css">

</head>

<body>

  <main>

    <div class="container">

        <div class="login_container_style">
            
        <img src="../../img/learnbetter_logo.png" alt="icondo_logo" class="obj_alg_center">
        <h3 class="login_txt_alg_center">Forget Password? We got you</h3><br>
       
        <form method="POST" autocomplete="off">

            <!-- Input Username + hold previous value if enter wrong -->
            <h5> User E-mail:</h5>
            <input type="email" name="user_forget_pass_email" placeholder="example@gmail.com"> <br> 

            <button type="submit" class="login_btn_style">Submit E-mail</button>
         
            <input type="hidden" name="user_forget_pass_rand_str" value="<?php echo gen_rand_str(); ?>">
        </form>

        <a href="../1_front_end/learnbetter_login_page.php" class="bold_link_style ">Already have account?</a>
    
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