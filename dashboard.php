<?php
session_start();
require_once './components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
//if session user exist it shouldn't access dashboard.php
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

$id = $_SESSION['adm'];
$status = 'adm';


mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adm-Dashboard</title>
    <?php require_once 'components/boot.php' ?>
    <link rel="stylesheet" type="text/css" href="2.css">
    <style type="text/css">
        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }

        td {
            text-align: left;
            vertical-align: middle;
        }

        tr {
            text-align: center;
        }

        .userImage {
            width: 100px;
            height: auto;
        }
        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
</head>

<body style="background-image: url(./aaaas.jpeg)" class="text-center">
    <div class="hero">
            
            <h1 class="text-white">Animal Adoption</h1>
        </div>
    <div class="container">
        <div class="">
            <div class="">
                <img class="userImage" src="./pictures/admavatar.png" alt="Adm avatar">
                <p class="">Administrator</p>
                <a class="btn btn-success" href="animals/index.php">Manage Animals</a>
                <a class="btn btn-primary" href="users_adm.php">Manage Users</a>
                <a class="btn btn-warning" href="adopt_adm.php">Manage Adoptions</a>
                <a class="btn btn-danger" href="logout.php?logout">Sign Out</a>
            </div>
            <div class="col-8 mt-2">
                

                
            </div>
        </div>
    </div>
</body>
</html>