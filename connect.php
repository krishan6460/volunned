<?php

$host="localhost";
$user="krishabhi_2003";
$pass="Volunned@2024";
$db="krishabhi_2003";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){
    echo "Failed to connect DB".$conn->connect_error;
}
?>