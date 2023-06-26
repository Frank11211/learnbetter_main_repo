<?php 
    echo '
    <ul class="sidebar-item">
        <li><a href="../1_front_end/learnbetter_A1_home_page.php"><i class="fa-solid fa-house"> </i> Home </a></li>
        <li><a href="../1_front_end/learnbetter_A1_account_page.php"><i class="fa-solid fa-address-card"></i> My Account </a></li>
        <li><a href="../1_front_end/learnbetter_A1_trainee_mng_page.php"><i class="fa-solid fa-user-plus">  </i> Trainer Managment </a></li>
        <li><a href="../1_front_end/learnbetter_A1_training_mng_page.php"><i class="fa-sharp fa-solid fa-book"></i> Course Management </a></li>
        <li><a href="../1_front_end/learnbetter_A1_candidate_mng_page.php"><i class="fa-sharp fa-solid fa-users"></i>Assign Candidate  </a></li>
        <li><a href="../1_front_end/learnbetter_A1_course_approval_page.php"><i class="fa-solid fa-check-double"></i>Course Approvel</a></li>
        <li><a href="../2_back_end/logout_function.php?log_lv='.$_SESSION['admin_level'].'"><i class="fa-solid fa-right-from-bracket"></i> Logout </a></li>
    </ul>    
    
    ';
?>