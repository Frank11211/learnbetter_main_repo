<?php 
    include "../2_back_end/check_login.php";
    //check_login();
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>Admin Tempalte</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>
     <!-- 
    Reference 
    - https://www.youtube.com/watch?v=V0O4pY2xX10&ab_channel=CodingNepal 
    -->
  <link rel="stylesheet" href="../../css/dashboard_admin_temp_style.css">
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
        <img src="https://placehold.co/80x80" alt="img_user"> 
        <h4> 
            Welcome
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
                if($_SESSION['user_level'] == 0){
                    echo "<b>Admin</b>";
                }elseif($_SESSION['user_level'] == 1){
                    echo "<b>Trainer</b>";
                }elseif($_SESSION['user_level'] == 2){
                    echo "<b>Candidate</b>";
                }
            ?>
          </li> <br>
          <!-- Show number of course taken -->
          <li> Organized Course :</li>
        </ul>
    </div>

    <ul class="sidebar-item">
        <li><a href="#"><i class="fa-solid fa-house"> </i> Home </a></li>
        <li><a href="#"><i class="fa-solid fa-user">  </i> My Account </a></li>
        <li><a href="#"><i class="fa-solid fa-user">  </i> Trainee Managment </a></li>
        <li><a href="#"><i class="fa-solid fa-plus">  </i> Course Management </a></li>
        <li><a href="#"><i class="fa-solid fa-gear">  </i> Settings </a></li>
        <li><a href="../2_back_end/logout_function.php"><i class="fa-solid fa-right-from-bracket""></i> Logout </a></li>
    </ul>
  </div>

  <section> 
  <!-- Start your code hwere,   -->
  <div  class="num_dis_style_acc">
    <p> This is an testing </p>
  </div>
  </section> 

</body>
</html>