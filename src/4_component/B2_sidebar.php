<?php 
    echo '
    <ul class="sidebar-item">
        <li><a href="../1_front_end/learnbetter_B2_home_page.php"><i class="fa-solid fa-house"> </i> Home </a></li>
        <li><a href="../1_front_end/learnbetter_B2_account_page.php"><i class="fa-solid fa-user">  </i> My Account </a></li>
        <li><a href="../1_front_end/learnbetter_B2_view_training_page.php"><i class="fa-solid fa-book">  </i> View All Training </a></li>
        <li><a href="../1_front_end/learnbetter_B2_approve_candit_page.php"><i class="fa-solid fa-person-circle-check"></i>Approve Candidate</a></li>
        <li><a href="../1_front_end/learnbetter_B2_request_course_page.php"><i class="fa-solid fa-file-circle-plus"></i>Create Course Request </a></li>
        <li><a href="../2_back_end/logout_function.php?log_lv='.$_SESSION['trainee_level'].'"><i class="fa-solid fa-right-from-bracket""></i> Logout </a></li>
    </ul>
    
    ';
?>