<?php 
   include "../3_database/db_connection.php";
   include "../2_back_end/check_login.php";
   include "../2_back_end/update_info.php";
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport", initial-scale=1.0">
  <title>Admin Tempalte</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/learnbetter_A_account_page_style.css">
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
        <img src="data:image;base64, <?php echo base64_encode( dis_admin_acc_img($conn, $_SESSION['admin_id'])); ?>" style="height:90px; width:90px;" alt="img_user"> 
        <h4> 
            <?php 
                if($_SESSION['admin_gen'] === "Male"){
                    echo " Mr. ".$_SESSION["admin_firstN"];
                }elseif($_SESSION['user_gen'] === "Female"){
                    echo " Ms. ".$_SESSION["admin_firstN"];
                }
            ?> 
        </h4><br>

        <ul class="sidebar-acc-post">
          <li> Position : 
            <?php 
                if(isset($_SESSION['admin_level']) && $_SESSION['admin_level'] == 0 ){
                    echo "<b>Admin</b>";
                }else{
                    echo "No Position";
                }
            ?>
          </li> <br>
          <!-- Show number of course taken -->
          <li> Created Course : </li>
        </ul>
    </div>

    <?php include "../4_component/A1_sidebar.php"; ?>
  </div>


  <section> 
  
  <div  class="num_dis_style_acc">
        <!-- Account Wrapper -->
        <div class="account_wrapper">
            <p class="title_style">My Account</p><br><br>

            <img src=" data:image;base64, <?php echo base64_encode(dis_admin_acc_img($conn, $_SESSION['admin_id'])); ?>" id="preview_image" style="height: 150px; width: 150px;" alt="image_placehold"><br>

            <!-- verticle line -->
            <div class="verticle_line_style"></div>

            <!-- submit form to it's self -->
            <form name="A1_update_acc" method="POST" enctype="multipart/form-data">
                <div class= "info_wrapper">
                
                    <div class="info_edit_wrapper">
                        <h2>Account Information</h2><br><br>
                        <p>Firstname : <input type="text" name="upd_acc_firstN_A1"   value= "<?php echo $_SESSION["admin_firstN"] ?>"> </p><br>
                        <p>Lastname  : <input type="text" name="upd_acc_lastN_A1"    value= "<?php echo $_SESSION['admin_lastN'] ?>"> </p><br>
                        <p>Username  : <input type="text" name="upd_acc_username_A1" value= "<?php echo $_SESSION['admin_name'] ?>"> </p><br>
                        <p>Gmail     : <input type="text" name="upd_acc_mail_A1"     value= "<?php echo $_SESSION['admin_mail'] ?>"> </p><br>
                    </div>

                    <div class="verticle_line_style_2"></div>

                    <div class="info_pass_wrapper">
                        <h2>Change Password </h2><br><br>
                        <button type= "button" id="show_password_btn" class="btn_style_5">Show Password</button>
                        <p>Current Password :       <input type="password" name="upd_acc_new_pass_A1" id="display_password" value="<?php echo $_SESSION['admin_pass'] ?>" placeholder="*Min 6 character"></p><br>
                        <p>Reconfirm Setup Password :  <input type="password" name="upd_acc_retype_pass_A1" id="display_conf_password" value="<?php echo $_SESSION['admin_pass'] ?>" > </p><br>
                    </div>

                </div>

                <!-- JavaScript Display Password -->
                <script>
                    const currentPassword = document.getElementById('display_password');
                    const confirmPassword = document.getElementById('display_conf_password');
                    const showPasswordButton = document.getElementById('show_password_btn');

                    showPasswordButton.addEventListener('click', function() {
                        if (currentPassword.type === 'password') {
                            currentPassword.type = 'text';
                            confirmPassword.type = 'text';
                            showPasswordButton.textContent = 'Hide Password';
                        } else {
                            currentPassword.type = 'password';
                            confirmPassword.type = 'password';
                            showPasswordButton.textContent = 'Show Password';
                        }
                    });
                </script>

                <!-- check which user to direct  -->
                <input type="hidden" name="user_access_level" value="<?php echo $_SESSION['admin_level']; ?>">

                <!-- Save infromation button -->
                <input type="file" name="upd_uploaded_image" id="uploaded_image" class="custom-file-input">
                <input type="button" class="btn_style_2" value="Upload Photo">

                <input type="submit" class="btn_style_3" value="Save Info">
                
                <!-- Script to trigger the upload function -->
                <script>
                // Get the input field and image tag elements
                const inputField = document.getElementById('uploaded_image');
                const previewImage = document.getElementById('preview_image');

                // Add an event listener to the input field
                inputField.addEventListener('change', function (event) {
                    const file = event.target.files[0]; // Get the selected file, 

                    // Check if a file is selected
                    if (file) {
                    const reader = new FileReader();

                    // Set up the reader to read the file
                    reader.readAsDataURL(file);

                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                    };
                    } 
                    else {
                        previewImage.src = " data:image;base64, <?php echo base64_encode( dis_admin_acc_img($conn, $_SESSION['admin_id'])); ?>"
                    }
                });
                </script>
            </form>

            <!-- Form Validation -->
            <script>
                // Attach an event listener to the submit button
                document.querySelector('input[type="submit"]').addEventListener('click', function(event) {
                // Prevent the form from submitting by default
                event.preventDefault();

                // Perform validation checks
                var firstName = document.querySelector('input[name="upd_acc_firstN_A1"]').value;
                var lastName = document.querySelector('input[name="upd_acc_lastN_A1"]').value;
                var username = document.querySelector('input[name="upd_acc_username_A1"]').value;
                var email = document.querySelector('input[name="upd_acc_mail_A1"]').value;
                var newPassword = document.querySelector('input[name="upd_acc_new_pass_A1"]').value;
                var confirmPassword = document.querySelector('input[name="upd_acc_retype_pass_A1"]').value;

                // Regular Expression
                var alphanumericRegex = /^[a-zA-Z0-9]+$/;
                var alphabetRegex = /^[a-zA-Z]+$/;
                var numberRegex = /^[0-9]+$/;

                // Perform validation checks
                if (firstName.trim() === '') {
                    alert("First name can't be empty.");
                    return;
                }

                // Probhite user enter any special character or number
                if (!alphabetRegex.test(firstName)) {
                    alert("Only alphabet available in fist name.");
                    return;
                }

                if (lastName.trim() === '') {
                    alert("Last name can't be empty.");
                    return;
                }

                // Probhite user enter any special character or number
                if (!alphabetRegex.test(lastName)) {
                    alert("Only alphabet available in last name.");
                    return;
                }

                if (username.trim() === '') {
                    alert("Username can't be empty.");
                    return;
                }

                // Handling both empty and special charecter invalid
                if (!email.trim() || !validateEmail(email)) {
                    alert("Empty or Invalid email address.");
                    return;
                }

                if (newPassword === "" || newPassword.length < 6) {
                    alert("New password can't be empty or less than 6 characters.");
                    return;
                }
                
                if(newPassword !== confirmPassword || confirmPassword == ""){
                    alert('Please retype correctly your new passsword ');
                    return;
                }

                event.target.form.submit();
                });

                // funtction to validate email input
                function validateEmail(email) {
                    var re = /\S+@\S+\.\S+/;
                    return re.test(email);
                }
            </script>

       </div>

  </div>

  </section> 

</body>
</html>