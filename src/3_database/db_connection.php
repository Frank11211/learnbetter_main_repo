<?php 

$db_servername  = "localhost" ;
$db_username    = "root" ;
$db_password    = "";
$db_name        = "learn_better_db" ;

// Set up connection 
$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

// Check connection 

// object Oriented Style
// if connection fail, print error on top of file, else proceed normal

if($conn->connect_error){
    echo "Datbase fail connect :". $conn->connect_error;
}


?>