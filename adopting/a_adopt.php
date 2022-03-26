<?php
session_start();
require_once '../components/db_connect.php';
if (isset($_SESSION['adm']) != "") {
    header("Location: ../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

$res = mysqli_query($connect, "SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
if ($_POST) {
    $anim_id = $_POST['id'];
    $date = $_POST['date'];
    
    
    $user_id=$_SESSION['user'];
    $status='Adopted';
    


$sql = "INSERT INTO adoptions (date, fk_user_id, fk_anim_id ) VALUES ('$date', $user_id, $anim_id)";

$sqla = "UPDATE animals SET status = '$status' WHERE anim_id = {$anim_id}";

if (mysqli_query($connect, $sql ) === true && empty($date) ===false ) {
        $class = "success";
        $message = "You have  Adopted  this Pet <br> You have two days to take your pet home. If not the adoption will be canceled. <br> Thank You. <br> Have a nice day.";
            
       
    } else {
        $class = "danger";
        $message = "Error while creating record. Enter Valid dates. <br>" ;
       
    }
    $sqla = "UPDATE animals SET status = '$status' WHERE anim_id = {$anim_id}";
if (mysqli_query($connect, $sqla ) === true) {
        $classs = "success";
        $messages = "You have Adopted <br>";
            
       
    } else {
        $classs = "danger";
        $messages = "Error while creating record. Try again: <br>" ;
       
    }

    mysqli_close($connect);
} else {
    header("location: ../error.php");
}
  




?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Adopt</title>
  <?php require_once '../components/boot.php' ?>
     <link rel="stylesheet" type="text/css" href="2.css">
  <style>
       .userImage {
            width: 200px;
            height: 200px;
        }
        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }

        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        } 
        .image{
            margin:1rem
        }
        .name{
            margin-top:50px;
            margin-left:50px;
        }
  </style>
</head>
<body style="background-image: url(./aaaas.jpeg)">
    <div class="container">
        <div class="hero text-center d-flex">
            <div class="image" >
            <img class="userImage" src="../pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['f_name']; ?>">
            <p class="text-white">Hi <?php echo $row['f_name']; ?></p>
            </div>
            <div class="name">
            <h1 class="text-white">Animal Adoption</h1>
            <h3 class="text-danger">Great Choice </h3>
            </div>
        </div>
       
    </div>
  <h1><?php echo $message ?></h1>
  <a href='../home.php'><button class="btn btn-primary" type='button'>Home</button></a>
</body>
</html>