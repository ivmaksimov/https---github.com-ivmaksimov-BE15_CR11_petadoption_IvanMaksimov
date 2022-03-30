<?php
session_start();
require_once '../components/db_connect.php';
// if session is not set this will redirect to login page
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("Location:../index.php");
    exit;
}
if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
    exit;
}

$class = 'd-none';

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM adoptions WHERE adpt_id = {$id}";
    $result = mysqli_query($connect, $sql);
    $data = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) == 1) {
        $user_id = $data['fk_user_id'];
        $anim_id = $data['fk_anim_id'];
        $date = $data['date'];
        
    
    }
}

if ($_POST) {
    $id = $_POST['id'];
    $status = 'Available';

    $sql = "DELETE FROM adoptions WHERE adpt_id = {$id}";
    $sqla = "UPDATE animals SET status = '$status' WHERE anim_id = {$anim_id}";
    if ($connect->query($sql) === TRUE) {
        $class = "alert alert-success";
        $message = "Successfully Deleted!";
        header("refresh:3;url=../adopt_adm.php");
    } else {
        $class = "alert alert-danger";
        $message = "The entry was not deleted due to: <br>" . $connect->error;
    }
     $sqla = "UPDATE animals SET status = '$status' WHERE anim_id = {$anim_id}";
if (mysqli_query($connect, $sqla ) === true) {
        $classs = "success";
        $messages = "You have Booked the Car <br>";
            
       
    } else {
        $classs = "danger";
        $messages = "Error while creating record. Try again: <br>" ;
       
    }

}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <?php require_once '../components/boot.php' ?>
    <style type="text/css">
        fieldset {
            margin: auto;
            margin-top: 100px;
            width: 70%;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }
        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
</head>

<body style="background-image: url(./aaaas.jpeg)" class="text-center">
    <div class="hero">
     <h1 class="text-white">The Best Car Rent Agency </h1>
    </div>
    <div class="<?php echo $class; ?>" role="alert">
        <p><?php echo ($message) ?? ''; ?></p>
    </div>
    <fieldset>
        <legend class='h2 mb-3'>Delete request </legend>
        <h5>You have selected the data below:</h5>
        <table class="table w-75 mt-3">
            <tr>
                <td>Adoption ID  <?php echo $id ?></td>
                <td>User ID   <?php echo $user_id ?></td>
                <td>Animal ID   <?php echo $anim_id ?></td>
                <td>Date of Adoption    <?php echo $date ?></td>
                
            </tr>
        </table>
        <h3 class="mb-4">Do you really want to delete this user?</h3>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id ?>" />
            <input type="hidden" name="picture" value="<?php echo $picture ?>" />
            <button class="btn btn-danger" type="submit">Yes, delete it!</button>
            <a href="../adopt_adm.php"><button class="btn btn-warning" type="button">No, go back!</button></a>
        </form>
    </fieldset>
</body>
</html>