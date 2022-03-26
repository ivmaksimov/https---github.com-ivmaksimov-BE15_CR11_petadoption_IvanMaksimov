<?php
session_start();
require_once '../components/db_connect.php';
require_once '../components/file_upload.php';

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$backBtn = '';

if (isset($_SESSION["user"])) {
    $backBtn = "home.php";
}

if (isset($_SESSION["adm"])) {
    $backBtn = "../booking_adm.php";
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM booking WHERE id = {$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $user_id = $data['user_id'];
        $car_id = $data['car_id'];
        
        $date_from = $data['date_from'];
        $date_to = $data['date_to'];
        $days = $data['reserv_days'];
        
    }
}


$class = 'd-none';
if (isset($_POST["submit"])) {
    $user_id = $_POST['user_id'];
    $car_id = $_POST['car_id'];
    
   $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        $days = $_POST['reserv_days'];
    $id = $_POST['id'];
    
    
    
        $sql = "UPDATE booking SET  user_id = $user_id, car_id = $car_id,  date_from = '$date_from', date_to = '$date_to', reserv_days = $days WHERE id = {$id}";
    
    if (mysqli_query($connect, $sql) === true) {
        $class = "alert alert-success";
        $message = "The record was successfully updated";
        
        header("refresh:3;url=update.php?id={$id}");
    } else {
        $class = "alert alert-danger";
        $message = "Error while updating record : <br>" . $connect->error;
       
        header("refresh:3;url=update.php?id={$id}");
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <?php require_once '../components/boot.php' ?>
       <link rel="stylesheet" type="text/css" href="2.css">
    <style type="text/css">
        fieldset {
            margin: auto;
            margin-top: 100px;
            width: 60%;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
    </style>
</head>

<body style="background-image: url(./aaaas.jpeg)">
    <div class="container">
        <div class="<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
        </div>
        <h2>Update Adopt</h2>
        
        <form method="post" enctype="multipart/form-data">
            <table class="table">
               <h2>Booking ID <?php echo $id  ?></h2>
                <tr>
                    <th>User ID</th>
                    <td><input class="form-control" type="number" name="user_id" placeholder="Insert User ID" value="<?php echo $user_id ?>" /></td>
                </tr>
                <tr>
                    <th>Car ID</th>
                    <td><input class="form-control" type="number" name="car_id" placeholder="Insert Car ID" value="<?php echo $car_id ?>" /></td>
                </tr>
                <tr>
                    <th>Date From</th>
                    <td><input class="form-control" type="date" name="date_from" placeholder="Insert Date From" value="<?php echo $date_from ?>" /></td>
                </tr>
                <tr>
                    <th>Date To</th>
                    <td><input class="form-control" type="date" name="date_to" placeholder="Insert Date To" value="<?php echo $date_to ?>" /></td>
                </tr>
                 <tr>
                    <th>Days Booked</th>
                    <td><input class="form-control" type="number" name="reserv_days" placeholder="Insert Number of Days" value="<?php echo $days ?>" /></td>
                </tr>
                <tr>
                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" />
                    <input type="hidden" name="picture" value="<?php echo $picture ?>" />
                    <td><button name="submit" class="btn btn-success" type="submit">Save Changes</button></td>
                    <td><a href="<?php echo $backBtn ?>"><button class="btn btn-warning" type="button">Back</button></a></td>
                    <td><a href="../dashboard.php"><button class="btn btn-primary" type="button">Home</button></a></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>