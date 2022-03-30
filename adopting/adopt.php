<?php
session_start();
require_once '../components/db_connect.php';

if (isset($_SESSION['']) != "") {
    header("Location: ../home.php");
    exit;
}

if (!isset($_SESSION['']) && !isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
$res = mysqli_query($connect, "SELECT * FROM users WHERE user_id=" . $_SESSION['user']);
$row = mysqli_fetch_array($res, MYSQLI_ASSOC);
if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animals WHERE anim_id = {$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $kind = $data['kind'];
        $breed = $data['breed'];
        $picture = $data['picture'];
        $sex = $data['sex'];
        $name = $data['name'];
        $size = $data['size'];
        $age = $data['age'];
        $location = $data['location'];
        $descript = $data['descript'];
        $status = $data['status'];  
    
$user_id=$_SESSION['user'];
    }}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once '../components/boot.php' ?>
    <title>Adopt this pet</title>
<link rel="stylesheet" type="text/css" href="2.css">
    <style>
        fieldset {
            margin: auto;
            margin-top: 100px;
            width: 60%;
        }
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

<body >
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
    <fieldset>
        <legend class='h2'>Adopt this Pet</legend>
        <form action="./a_adopt.php" method="post" enctype="multipart/form-data">
            <table class='table'>
                <tr>
                    <th>Kind</th>
                    <td><h1><?php echo $kind ?></h1></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><h1><?php echo $name ?> </h1></td>
                </tr>
                <tr>
                    <th>Date of Adoption</th>
                    <td><input class='form-control' type="date" name="date" /></td>
                </tr>
               
                
                <tr>
                  <input type="hidden" name="id" value="<?php echo $id ?>" />
                    <td><button class='btn btn-success' type="submit">Go</button></td>
                    <td><a href="../index.php"><button class='btn btn-warning' type="button">Home</button></a></td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>
</html>