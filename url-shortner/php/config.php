<?php
    $conn =  mysqli_connect("localhost", "root", "", "urlshortener");
    if(!$conn){
        echo "Database connection error".mysqli_connect_error();
    }
?>
