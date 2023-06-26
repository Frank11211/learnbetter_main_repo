<?php 

include "../3_database/db_connection.php";

//  Use Preapre statment to prevent SQL injection

if(isset($_GET['deleteid'])) {
    $train_id = $_GET['deleteid'];
    $sql_query = "DELETE FROM `learnbetter_users` WHERE id = ?";
    
    $stmt = $conn->prepare($sql_query);
    $stmt->bind_param("i", $train_id); // assuming the id column is an integer
    
    if ($stmt->execute()) {
        echo '<script>
                alert("Trainee Account has been deleted ");
                window.location.href = "../1_front_end/learnbetter_A1_trainee_mng_page.php"; 
             </script>';
    } else {
        echo '<script>
                alert("Database Query Error: '.$conn->error.'");
                console.log('.$conn->error.');
             </script>';
    }
    $stmt->close();
}