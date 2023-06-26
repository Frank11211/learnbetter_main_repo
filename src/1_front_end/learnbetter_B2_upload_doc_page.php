<?php 
    include "../3_database/db_connection.php";
    include "../2_back_end/check_login.php";
    include "../2_back_end/upload_file_function.php";

    $upload_course_id = null;
    $upload_course_name = null;
    $upload_course_code = null;
    $upload_course_trainee = $_SESSION['trainee_id'];
    
    if (isset($_GET['upl_course_id']) && isset($_GET['upl_course_name']) && isset($_GET['upl_course_code'])) {
        $upload_course_id = $_GET['upl_course_id'];
        $upload_course_name = $_GET['upl_course_name'];
        $upload_course_code = $_GET['upl_course_code'];

    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=  , initial-scale=1.0">
  <title>User Template</title>
  <script src="https://kit.fontawesome.com/d29dfd4236.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/learnbetter_B_upload_doc_style.css">
</head>

<body>
  
  <input type="checkbox" id="check">
   <label for="check">
      <i class="fas fa-bars " id="menu_btn"> </i>
      <i class="fas fa-times " id="menu_cancel"> </i>  
   </label>
  
  <!-- sidebar  -->
  <div class="sidebar-wrapper"> 

    <header><img src="../../img/learnbetter_logo.png" style="height:50px; width:50px; margin-top: 10px;" alt="logo_img"> LearnBetter </header>

    <div class="sidebar-acc-wrapper">
    <img src="data:image;base64, <?php echo base64_encode( dis_admin_acc_img($conn, $_SESSION['trainee_id'])); ?>" style="height:90px; width:90px;" alt="img_user"> 
        <h4>
            <?php 
                if($_SESSION['trainee_gen'] === "Male"){
                    echo " Mr. ".$_SESSION["trainee_firstN"];
                }elseif($_SESSION['user_gen'] === "Female"){
                    echo " Ms. ".$_SESSION["trainee_firstN"];
                }
            ?> 
        </h4><br>

        <ul class="sidebar-acc-post">
          <li> Position : 
            <?php 
                if(isset($_SESSION['trainee_level']) && $_SESSION['trainee_level'] == 1 ){
                  echo "<b>Trainee</b>";
              }else{
                  echo "No Position";
              }
            ?>
          </li> <br>
          <!-- Show number of course taken -->
          <li> 
            Total Course : <?php echo dis_num_trainee_handle_course($conn, $_SESSION["trainee_id"]); ?>
          </li>
        </ul>
    </div>
 
    <?php include "../4_component/B2_sidebar.php"; ?>

  </div>

 <section> 
  <!-- Start your code hwere,   -->
  <div  class="num_dis_style">

      <form method="POST" enctype="multipart/form-data">
        
        <input type="file" id="fileInput" name="file[]" multiple><br>
        <button type="submit" class="btn_style_3"> Submit Now</button>
        <div class = "dis_file_list">
          <h2 style="text-align: center;"> Uploaded Document List</h2><br>
            
          <!-- JS function will create the list  -->
          <ul id="fileList" class="file_list_style"> </ul>
        </div>

        <!-- JS function display file  -->
        <script>
          const fileInput = document.getElementById('fileInput');
          const fileList = document.getElementById('fileList');
          

          fileInput.addEventListener('change', function() {
            fileList.innerHTML = ''; // Clear the previous list

            // Loop through the selected files and display their names
            for (let i = 0; i < fileInput.files.length; i++) {
              const file = fileInput.files[i];
              const listItem = document.createElement('li');
              listItem.textContent = (i+1) + ". " + file.name;
              fileList.appendChild(listItem);
            }
          });
        </script>
        
         <!-- direct pass hidden key   -->
        <input type="hidden" name="hidden_upload_course_id" value="<?php echo $upload_course_id ;?>">
        <input type="hidden" name="hidden_upload_course_name" value="<?php echo $upload_course_name ;?>">
        <input type="hidden" name="hidden_upload_course_code" value="<?php echo $upload_course_code ;?>">
        <input type="hidden" name="hidden_upload_course_trainee" value="<?php echo $upload_course_trainee;?>">
       
 
      </form>

  </div>

  <div class="crud_train_asign_table">

    <table style="width:100%; padding:10px;">

     </br><h2> Document Upload History </h2></br>

      <tr>
        <!-- Table Title  -->
          <th>No.</th>
          <th>Uploaded Document </th>
          <th>Uploaded Date     </th>
          <th>Action            </th>

      </tr>

      <?php 
        $sql_query = "SELECT * FROM learnbetter_upload
                      WHERE upload_course_id = $upload_course_id";
        
        $sql_result = $conn->query($sql_query);

        if($sql_query){
          
          $i = 1;
          
          while ($row = $sql_result->fetch_assoc()) {

            echo "<tr>";
            echo "<td>". $i ."</td>"; 
            echo '<td>'.$row['upload_file'].'</td>';
            echo "<td>".$row['upload_current_date'] ."</td>"; 
            
            echo '<td>
                    <button class="btn_style_2">
                        Delete Doc
                    </button>
                        
                  </td>
                  </tr>
                  ';
            $i++;
          }
        }

        if (!$sql_result || $sql_result->num_rows === 0) {
          echo "<tr rowspan>";
          echo "<td colspan='4'>No Document has been uploaded</td>"; 
          echo "</tr>";
        }
      ?>
    </table>

  </div>
  
</section>

</body>
</html>