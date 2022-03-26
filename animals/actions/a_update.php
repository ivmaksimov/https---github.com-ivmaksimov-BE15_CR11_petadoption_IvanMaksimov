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
    $id = $_POST['id'];
    $kind = $_POST['kind'];
    $breed = $_POST['breed'];
    $sex = $_POST['sex'];
    $name = $_POST['name'];
    $size = $_POST['size'];
    $age = $_POST['age'];
    $location = $_POST['location'];
    $descript = $_POST['descript'];
    $status = $_POST['status'];
    $picture = $_POST['picture'];
    $uploadError = '';

    $picture = file_upload($_FILES['picture'], 'product' );   
    if ($picture->error === 0) {
        ($_POST["picture"] == "product.png") ?: unlink("../pictures/$_POST[picture], " );
        $sql = "UPDATE animals SET  kind = '$kind', breed = '$breed', sex = '$sex', name = '$name', size = '$size', age = $age, location = '$location', descript = '$descript',  status= '$status', picture = '$picture->fileName'  WHERE anim_id = {$id}";
    } else {
        $sql = "UPDATE animals SET kind = '$kind', breed = '$breed', sex = '$sex', name = '$name', size = '$size', age = $age, location = '$location', descript = '$descript',  status= '$status'  WHERE anim_id = {$id}";}
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "The record was successfully updated";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    } else {
        $class = "danger";
        $message = "Error while updating record : <br>" . mysqli_connect_error();
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    }}
    mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update</title>
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
            <h1 class="text-white">Animal Adoption </h1>
        </div>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Update request response</h1>
        </div>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            
            <a href='../index.php'><button class="btn btn-primary" type='button'>Animals</button></a>
            <a href='../dashboard.php'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>
</html>