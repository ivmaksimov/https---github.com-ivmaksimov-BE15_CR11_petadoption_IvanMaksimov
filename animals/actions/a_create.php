<?php

session_start();

if (isset($_SESSION['user']) != "") {
    header("Location: ../../home.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../components/db_connect.php';
require_once '../../components/file_upload.php';

if ($_POST) {
    $kind = $_POST['kind'];
    $breed = $_POST['breed'];
    $sex = $_POST['sex'];
    $name = $_POST['name'];
    $size = $_POST['size'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    $descript = $_POST['descript'];
    $status = $_POST['status'];
    $uploadError = '';
    
    $picture = file_upload($_FILES['picture'], 'product');

    
        
        $sql = "INSERT INTO animals (kind, breed,  sex, name, size, age, location,  descript, status, picture) VALUES ('$kind', '$breed', '$sex', '$name', '$size', $age, '$location', '$descript', '$status',  '$picture->fileName' )";
    
    

    if (mysqli_query($connect, $sql) === true) {
        $class = "success";
        $message = "The entry below was successfully created <br>
            <table class='table w-50'><tr>
            <td> $kind </td>
            <td> $breed </td>
            <td> $sex </td>
            <td> $name </td>
            <td> $size </td>
            <td> $age </td>
            <td> $location </td>
            <td> $descript </td>
            <td> $status </td>
            </tr></table><hr>";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    } else {
        $class = "danger";
        $message = "Error while creating record. Try again: <br>" . $connect->error;
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
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
    <title>Create</title>
    <?php require_once '../../components/boot.php' ?>
    <style type="text/css">
        
        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
        .container{
            margin-top: 7rem;
        }
    </style>
</head>


<body style="background-image: url(./aaaas.jpeg)" class="text-center">
    <div class="hero">
     <h1 class="text-white">The Best Car Rent Agency </h1>
    </div>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Create request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../index.php'><button class="btn btn-primary" type='button'>Back to Animals</button></a>
        </div>
    </div>
</body>
</html>