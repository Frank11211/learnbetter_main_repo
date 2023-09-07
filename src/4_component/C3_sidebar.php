<?php 
echo '
    <ul class="sidebar-item">
        <li><a href="../1_front_end/learnbetter_C3_home_page.php"><i class="fa-solid fa-house"> </i> Home </a></li>
        <li><a href="../1_front_end/learnbetter_C3_account_page.php"><i class="fa-solid fa-user">  </i> My Account </a></li>
        <li><a href="../1_front_end/learnbetter_C3_enroll_training_page.php"><i class="fa-solid fa-book">  </i> Course Enrolled </a></li>
        <li><a href="../1_front_end/learnbetter_C3_download_doc_page.php"><i class="fa-solid fa-file-arrow-down"></i> Download Document </a></li>
        <li><a href="../1_front_end/learnbetter_C3_view_enrollment_page.php"><i class="fa-solid fa-clock-rotate-left"> </i> Enrollment History </a></li>
        <li><a href="../2_back_end/logout_function.php?log_lv='.$_SESSION['user_level'].'"><i class="fa-solid fa-right-from-bracket""> </i> Logout </a></li>
    </ul>

';

?>