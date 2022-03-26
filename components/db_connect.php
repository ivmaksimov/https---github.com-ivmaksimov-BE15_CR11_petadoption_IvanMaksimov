<?php

$localhost = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "be15cr11_petadoption_ivanmaksimov";


$connect = new  mysqli($localhost, $username, $password, $dbname);


// if ($connect->connect_error) {
//     die("Connection failed: " . $connect->connect_error);
//  } else {
//      echo "Successfully Connected";
// }