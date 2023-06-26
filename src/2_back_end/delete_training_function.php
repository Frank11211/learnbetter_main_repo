<?php 

include "../3_database/db_connection.php";

//  Use Preapre statment to prevent SQL injection  

if(isset($_GET['delete_trainId'])) {
    $delete_train_id = $_GET['delete_trainId'];
    $trainee_unique_id = $_GET['trainee_Id'];

    $sql_query = "DELETE FROM `learnbetter_courses` WHERE id = ?";
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $delete_train_id); // assuming the id column is an integer
    
    if ($stmt->execute()) {

        $second_sql_query = "UPDATE `learnbetter_users`
                            SET `learnbetter_users`.`trainee_course` = `learnbetter_users`.`trainee_course` - 1
                            WHERE `learnbetter_users`.`id` = ?";

        $second_stmt = $conn->prepare($second_sql_query);
        $second_stmt->bind_param("i", $trainee_unique_id); // assuming the id column is an integer

        if ($second_stmt->execute()) {
            echo '<script>
                    alert("Trainee Account has been deleted ");
                    window.location.href = "../1_front_end/learnbetter_A1_training_mng_page.php"; 
                </script>';
        }else {
            echo '<script>
                    alert("Database Second Query Error: '.$conn->error.'");
                    console.log('.$conn->error.');
                 </script>';
        }

        $stmt->close();
 
    } else {
        echo '<script>
                alert("Database First Query Error: '.$conn->error.'");
                console.log('.$conn->error.');
             </script>';
    }
    $stmt->close();
}